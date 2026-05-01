<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AlumniImport implements ToCollection, WithEvents, WithChunkReading
{
    protected $adminId;
    protected $cacheKeySuccess;
    protected $cacheKeyFailed;

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
        $this->cacheKeySuccess = "import_alumni_{$adminId}_success";
        $this->cacheKeyFailed = "import_alumni_{$adminId}_failed";
    }

    public function collection(Collection $rows)
    {
        $localImportedCount = 0;
        $localFailedCount = 0;

        $dataStarted = false;

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 1;
            
            // Auto-detect header: Jika baris mengandung kata 'Nama' atau 'NISN'
            $rowString = implode(' ', array_map('strval', $row->toArray()));
            if (!$dataStarted && (str_contains(strtolower($rowString), 'nama') || str_contains(strtolower($rowString), 'nisn'))) {
                $dataStarted = true;
                continue; // Lewati baris header ini
            }

            if (!$dataStarted) {
                continue; // Belum ketemu data
            }

            // Kolom: 0:NO (Skip), 1:Nama, 2:NIPD, 3:JK, 4:NISN, 5:Angkatan, 6:Tahun Lulus
            $namaLengkap   = trim($row[1] ?? '');
            $nipd          = trim($row[2] ?? '');
            $jenisKelamin  = trim($row[3] ?? '');
            $nisn          = trim($row[4] ?? '');
            $angkatanInput = trim($row[5] ?? '');
            $tahunLulus    = trim($row[6] ?? '');

            // Normalisasi NISN (Hilangkan .0 jika terbaca sebagai float dari Excel)
            if (!empty($nisn)) {
                $nisn = preg_replace('/\.0$/', '', $nisn);
                if (str_contains(strtoupper($nisn), 'E+')) {
                    $nisn = number_format((float)$nisn, 0, '', '');
                }
            }

            // Skip jika baris benar-benar kosong
            if (empty($namaLengkap) && empty($nisn)) {
                Log::info("Import Skip Row $rowNumber: Baris kosong.");
                continue;
            }

            // Validasi NISN (Wajib 10 digit angka)
            if (empty($nisn) || !preg_match('/^[0-9]{10}$/', $nisn)) {
                Log::warning("Import Skip Row $rowNumber: NISN tidak valid ($nisn) - harus 10 digit.");
                $localFailedCount++;
                continue;
            }

            // Normalisasi Jenis Kelamin
            $jk = null;
            $jkInput = strtoupper($jenisKelamin);
            if (in_array($jkInput, ['L', 'LAKI-LAKI', 'LAKI LAKI', 'PRIA', 'MALE'])) {
                $jk = 'L';
            } elseif (in_array($jkInput, ['P', 'PEREMPUAN', 'WANITA', 'FEMALE'])) {
                $jk = 'P';
            }

            // Basic Validation (Nama & Tahun Lulus wajib)
            if (empty($namaLengkap) || empty($tahunLulus) || empty($angkatanInput)) {
                Log::warning("Import Skip Row $rowNumber: Nama, Tahun Lulus, atau Angkatan kosong.");
                $localFailedCount++;
                continue;
            }

            // Check duplicate NISN (Cek di DB)
            if (Alumni::where('nisn', $nisn)->exists()) {
                $localFailedCount++;
                continue;
            }

            // Find or Create Angkatan
            $angkatan = null;
            
            // 1. Coba cari berdasarkan ID (jika input adalah angka murni)
            if (is_numeric($angkatanInput)) {
                $angkatan = Angkatan::find($angkatanInput);
            }
            
            // 2. Coba cari berdasarkan Nama (Misal: "1" atau "Angkatan 1")
            if (!$angkatan) {
                $searchName = is_numeric($angkatanInput) ? "Angkatan {$angkatanInput}" : $angkatanInput;
                $angkatan = Angkatan::where('nama_angkatan', $searchName)
                    ->orWhere('nama_angkatan', $angkatanInput)
                    ->first();
            }

            if (!$angkatan) {
                // Fallback: Create if not found
                $tahunMasuk = intval($tahunLulus) - 6; // Asumsi SD 6 tahun
                $tahunAjaran = $tahunMasuk . '/' . (intval($tahunMasuk) + 1);
                
                $angkatan = Angkatan::create([
                    'nama_angkatan' => is_numeric($angkatanInput) ? "Angkatan {$angkatanInput}" : $angkatanInput,
                    'tahun_ajaran' => $tahunAjaran,
                    'status' => 'LULUS'
                ]);
            }

            try {
                DB::beginTransaction();

                // Username: Gunakan NISN langsung agar mudah diingat
                $username = $nisn;
                
                // Jika NISN duplikat di tabel User (kasus langka), tambahkan suffix
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $nisn . $counter;
                    $counter++;
                }

                $user = User::create([
                    'username'             => $username,
                    'password'             => Hash::make($nisn),
                    'role'                 => 'alumni',
                    'is_active'            => true,
                    'email'                => null, // Email diisi sendiri oleh alumni nanti
                    'must_change_password' => true,
                ]);

                Alumni::create([
                    'user_id' => $user->id,
                    'nisn' => $nisn,
                    'nipd' => $nipd,
                    'nama_lengkap' => $namaLengkap,
                    'jenis_kelamin' => $jk,
                    'angkatan_id' => $angkatan->id,
                    'tahun_lulus' => $tahunLulus,
                    'status_verifikasi' => 'verified',
                    'is_profile_complete' => false,
                ]);

                DB::commit();
                $localImportedCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                $localFailedCount++;
                Log::error("Import Error on Row $rowNumber: " . $e->getMessage());
            }
        }

        // Akumulasi perhitungan ke Cache (Gunakan increment yang aman)
        if ($localImportedCount > 0) {
            if (!Cache::has($this->cacheKeySuccess)) Cache::put($this->cacheKeySuccess, 0, 3600);
            Cache::increment($this->cacheKeySuccess, $localImportedCount);
        }
        if ($localFailedCount > 0) {
            if (!Cache::has($this->cacheKeyFailed)) Cache::put($this->cacheKeyFailed, 0, 3600);
            Cache::increment($this->cacheKeyFailed, $localFailedCount);
        }
    }



    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                $success = Cache::pull($this->cacheKeySuccess, 0);
                $failed = Cache::pull($this->cacheKeyFailed, 0);
                
                \App\Models\AdminLog::log(
                    $this->adminId,
                    'import_alumni',
                    'alumni',
                    null,
                    "Import data alumni via Excel selesai diproses. Sukses: $success data, Gagal/Skip: $failed data."
                );
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
