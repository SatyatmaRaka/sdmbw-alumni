<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;

// TODO: Import file dalam jumlah besar sebaiknya dipanggil via dispatch() dari controller ke background job.
class AlumniImport implements ToCollection, WithEvents, WithChunkReading, ShouldQueue
{
    protected $adminId;
    protected $cacheKeySuccess;
    protected $cacheKeyFailed;

    // Counter untuk laporan setelah import selesai (sync mode)
    protected int $successCount = 0;
    protected int $failedCount = 0;

    // Optimasi: Cache data untuk menghindari N+1 queries
    protected $angkatans;
    protected $existingNisns;
    protected $existingUsernames;

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
        $this->cacheKeySuccess = "import_alumni_{$adminId}_success";
        $this->cacheKeyFailed = "import_alumni_{$adminId}_failed";
        
        // Preload data dasar (Memory-intensive but much faster)
        // Kita gunakan array keyed by unique identifier untuk O(1) lookup
        $this->angkatans = Angkatan::all()->keyBy(function($item) {
            return strtolower($item->nama_angkatan);
        })->toArray();
        
        // Kita hanya ambil NISN & Username untuk validasi duplikat cepat
        $this->existingNisns = Alumni::pluck('nisn', 'nisn')->toArray();
        $this->existingUsernames = User::pluck('username', 'username')->toArray();
    }

    public function collection(Collection $rows)
    { 

        $localImportedCount = 0;
        $localFailedCount = 0;
        $dataStarted = false;

        // BUNGKUS DALAM TRANSAKSI TUNGGAL PER CHUNK (SANGAT SIGNIFIKAN UNTUK KECEPATAN)
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 1;
                
                // Auto-detect header
                $rowString = implode(' ', array_map('strval', $row->toArray()));
                if (!$dataStarted && (str_contains(strtolower($rowString), 'nama') || str_contains(strtolower($rowString), 'nisn'))) {
                    $dataStarted = true;
                    continue;
                }

                if (!$dataStarted) continue;

                $namaLengkap   = trim($row[1] ?? '');
                $nipd          = trim($row[2] ?? '');
                $jenisKelamin  = trim($row[3] ?? '');
                $nisn          = trim($row[4] ?? '');
                $angkatanInput = trim($row[5] ?? '');
                $tahunLulus    = trim($row[6] ?? '');

                // Normalisasi NISN
                if (!empty($nisn)) {
                    $nisn = preg_replace('/\.0$/', '', $nisn);
                    if (str_contains(strtoupper($nisn), 'E+')) {
                        $nisn = number_format((float)$nisn, 0, '', '');
                    }
                }

                // Skip baris kosong
                if (empty($namaLengkap) && empty($nisn)) continue;

                // Validasi NISN & Duplikat (O(1) lookup via array key)
                if (empty($nisn) || !preg_match('/^[0-9]{10}$/', $nisn)) {
                    $localFailedCount++;
                    $this->failedCount++;
                    continue;
                }

                if (isset($this->existingNisns[$nisn])) {
                    $localFailedCount++;
                    $this->failedCount++;
                    continue;
                }

                // Basic Validation
                if (empty($namaLengkap) || empty($tahunLulus) || empty($angkatanInput)) {
                    $localFailedCount++;
                    continue;
                }

                // Find or Create Angkatan (Optimized)
                $angkatanObj = null;
                $searchName = is_numeric($angkatanInput) ? "angkatan {$angkatanInput}" : strtolower($angkatanInput);
                
                // Cari di cache array dulu
                if (isset($this->angkatans[$searchName])) {
                    $angkatanId = $this->angkatans[$searchName]['id'];
                } else {
                    // Create jika benar-benar tidak ada
                    $tahunMasuk = intval($tahunLulus) - 6;
                    $tahunAjaran = $tahunMasuk . '/' . (intval($tahunMasuk) + 1);
                    $newAngkatan = Angkatan::create([
                        'nama_angkatan' => is_numeric($angkatanInput) ? "Angkatan {$angkatanInput}" : $angkatanInput,
                        'tahun_ajaran' => $tahunAjaran,
                        'status' => 'LULUS'
                    ]);
                    // Update cache
                    $this->angkatans[strtolower($newAngkatan->nama_angkatan)] = $newAngkatan->toArray();
                    $angkatanId = $newAngkatan->id;
                }

                // Create User & Alumni
                $username = $nisn;
                if (isset($this->existingUsernames[$username])) {
                    $counter = 1;
                    while (isset($this->existingUsernames[$username . $counter])) {
                        $counter++;
                    }
                    $username = $nisn . $counter;
                }

                $user = User::create([
                    'username'             => $username,
                    'password'             => $nisn, // Tanpa Hash
                    'role'                 => 'alumni',
                    'is_active'            => true,
                    'must_change_password' => true,
                ]);

                Alumni::create([
                    'user_id' => $user->id,
                    'nisn' => $nisn,
                    'nipd' => $nipd,
                    'nama_lengkap' => $namaLengkap,
                    'jenis_kelamin' => $this->normalizeJK($jenisKelamin),
                    'angkatan_id' => $angkatanId,
                    'tahun_lulus' => $tahunLulus,
                    'status_verifikasi' => 'verified',
                    'is_profile_complete' => false,
                ]);

                // Update cache untuk baris berikutnya dalam chunk yang sama
                $this->existingNisns[$nisn] = $nisn;
                $this->existingUsernames[$username] = $username;
                
                $localImportedCount++;
                $this->successCount++; // Increment instance counter
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Import Chunk Error: " . $e->getMessage());
            // Kita anggap chunk ini gagal, namun chunk lain tetap bisa jalan jika dipanggil terpisah
        }

        // Akumulasi ke Cache
        if ($localImportedCount > 0) {
            if (!Cache::has($this->cacheKeySuccess)) Cache::put($this->cacheKeySuccess, 0, 3600);
            Cache::increment($this->cacheKeySuccess, $localImportedCount);
        }
        if ($localFailedCount > 0) {
            if (!Cache::has($this->cacheKeyFailed)) Cache::put($this->cacheKeyFailed, 0, 3600);
            Cache::increment($this->cacheKeyFailed, $localFailedCount);
        }
    }

    private function normalizeJK($input)
    {
        $jkInput = strtoupper(trim($input));
        if (in_array($jkInput, ['L', 'LAKI-LAKI', 'LAKI LAKI', 'PRIA', 'MALE'])) return 'L';
        if (in_array($jkInput, ['P', 'PEREMPUAN', 'WANITA', 'FEMALE'])) return 'P';
        return null;
    }

    /**
     * Mengembalikan jumlah baris yang berhasil diimport.
     * Digunakan oleh controller untuk menampilkan feedback ke user.
     */
    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    /**
     * Mengembalikan jumlah baris yang gagal/dilewati saat import.
     * Digunakan oleh controller untuk menampilkan feedback ke user.
     */
    public function getFailedCount(): int
    {
        return $this->failedCount;
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
                    "Import data alumni selesai (Optimized). Sukses: $success, Gagal/Skip: $failed."
                );
            },
        ];
    }

    public function chunkSize(): int
    {
        return 500; // Dikurangi sedikit agar memori per chunk lebih aman karena kita cache data
    }
}