<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AlumniProfileService
{
    /**
     * Update data profil alumni termasuk relasi dan foto.
     */
    public function updateProfile(User $user, Alumni $alumni, array $data, $fotoFile = null): void
    {
        DB::beginTransaction();
        try {
            // 1. Update Data Dasar
            $alumni->update([
                'alamat'     => $data['alamat'] ?? $alumni->alamat,
                'no_hp'      => $data['no_hp'] ?? $alumni->no_hp,
                'show_no_hp' => isset($data['show_no_hp']) ? 1 : 0,
                'email'      => $data['email'] ?? $alumni->email,
                'harapan'    => $data['harapan'] ?? $alumni->harapan,
                'jenjang_pendidikan_saat_ini' => $data['jenjang_pendidikan_saat_ini'] ?? $alumni->jenjang_pendidikan_saat_ini,
            ]);

            // 2. Update Kredensial User
            // must_change_password hanya di-reset ke false jika profil baru pertama kali diisi
            // (yaitu saat is_profile_complete masih false). Jika admin sudah reset password
            // (must_change_password = true) dan user bukan first-time, flag tetap terjaga.
            $userUpdateData = [];
            if (!$alumni->is_profile_complete) {
                // First-time onboarding: bebaskan dari wajib ganti password
                $userUpdateData['must_change_password'] = false;
            }
            if (!empty($data['email'])) {
                $userUpdateData['email'] = $data['email'];
            }
            if (!empty($data['username']) && $data['username'] !== $user->username) {
                $userUpdateData['username'] = $data['username'];
            }
            if (!empty($userUpdateData)) {
                $user->update($userUpdateData);
            }

            // 3. Handle Foto Profil
            if ($fotoFile) {
                $this->handleFotoUpload($alumni, $fotoFile);
            }

            // 4. Update Riwayat Pendidikan
            if (isset($data['pendidikan'])) {
                $this->syncPendidikan($alumni, $data['pendidikan']);
            }

            // 5. Update Riwayat Pekerjaan
            if (isset($data['pekerjaan'])) {
                $this->syncPekerjaan($alumni, $data['pekerjaan']);
            }

            // 6. Update status kelengkapan profil
            $alumni->update(['is_profile_complete' => $alumni->isDataComplete()]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleFotoUpload(Alumni $alumni, $file): void
    {
        // Hapus foto lama jika ada
        $fotoLama = $alumni->fotos()->where('is_main', true)->first();
        if ($fotoLama) {
            if (Storage::disk('public')->exists($fotoLama->path_file)) {
                Storage::disk('public')->delete($fotoLama->path_file);
            }
            $fotoLama->delete();
        }

        if (!Storage::disk('public')->exists('foto_alumni')) {
            Storage::disk('public')->makeDirectory('foto_alumni');
        }

        $filename = 'alumni_' . $alumni->id . '_' . time() . '.jpg';
        $path = 'foto_alumni/' . $filename;
        
        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getPathname());
        
        $image->scale(width: 800);
        $image->save(storage_path('app/public/' . $path));

        $alumni->fotos()->create([
            'path_file' => $path,
            'kategori'  => 'profil',
            'is_main'   => true,
        ]);
    }

    private function syncPendidikan(Alumni $alumni, array $pendidikanData): void
    {
        $hasValidEducation = collect($pendidikanData)->contains(function ($edu) {
            return !empty($edu['nama_instansi']);
        });

        if ($hasValidEducation) {
            $alumni->pendidikan->each->delete();
            foreach ($pendidikanData as $edu) {
                if (!empty($edu['nama_instansi'])) {
                    $isOngoing = (isset($edu['is_ongoing']) && $edu['is_ongoing'] == 1) ? 1 : 0;
                    $alumni->pendidikan()->create([
                        'jenjang'       => $edu['jenjang'] ?? null,
                        'nama_instansi' => $edu['nama_instansi'],
                        'fakultas'      => $edu['fakultas'] ?? null,
                        'program_studi' => $edu['program_studi'] ?? null,
                        'tahun_masuk'   => $edu['tahun_masuk'] ?? null,
                        'tahun_lulus'   => $isOngoing ? null : ($edu['tahun_lulus'] ?? null),
                        'is_ongoing'    => $isOngoing,
                    ]);
                }
            }
        }
    }

    private function syncPekerjaan(Alumni $alumni, array $pekerjaanData): void
    {
        $alumni->pekerjaan->each->delete();
        foreach ($pekerjaanData as $job) {
            if (!empty($job['nama_perusahaan'])) {
                $isCurrent = (isset($job['is_current']) && $job['is_current'] == 1) ? 1 : 0;
                $alumni->pekerjaan()->create([
                    'nama_perusahaan' => $job['nama_perusahaan'],
                    'jabatan'         => $job['jabatan'] ?? null,
                    'tahun_mulai'     => $job['tahun_mulai'] ?? null,
                    'is_current'      => $isCurrent,
                ]);
            }
        }
    }
}
