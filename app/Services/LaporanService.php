<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\Angkatan;
use App\Enums\AlumniStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;
use Illuminate\Support\Collection;

class LaporanService
{
    /**
     * Dapatkan Statistik Umum Laporan
     */
    public function getGeneralStats(): array
    {
        return Cache::remember(CacheService::LAPORAN_GENERAL_STATS, 600, function () {
            return [
                'total_alumni'         => Alumni::count(),
                'alumni_verified'      => Alumni::where('status_verifikasi', AlumniStatus::VERIFIED->value)->count(),
                'alumni_pending'       => Alumni::where('status_verifikasi', AlumniStatus::PENDING->value)->count(),
                'alumni_rejected'      => Alumni::where('status_verifikasi', AlumniStatus::REJECTED->value)->count(),
                'profil_lengkap'       => Alumni::where('is_profile_complete', true)->count(),
                'profil_belum_lengkap' => Alumni::where('is_profile_complete', false)->count(),
            ];
        });
    }

    /**
     * Dapatkan Statistik per Angkatan
     */
    public function getAngkatanStats(): Collection
    {
        return Cache::remember(CacheService::LAPORAN_ANGKATAN_STATS, 600, function () {
            return Angkatan::withCount([
                'alumni',
                'alumni as verified_count' => function ($query) {
                    $query->where('status_verifikasi', AlumniStatus::VERIFIED->value);
                },
                'alumni as pending_count' => function ($query) {
                    $query->where('status_verifikasi', AlumniStatus::PENDING->value);
                },
                'alumni as complete_count' => function ($query) {
                    $query->where('is_profile_complete', true);
                }
            ])
            ->orderBy('id', 'asc')
            ->get();
        });
    }

    /**
     * Dapatkan Statistik Pendidikan Terpopuler
     */
    public function getPendidikanStats(): Collection
    {
        return Cache::remember(CacheService::LAPORAN_PENDIDIKAN_STATS, 600, function () {
            return DB::table('alumni_pendidikan')
                ->select('nama_instansi as pendidikan_lanjutan', DB::raw('count(*) as total'))
                ->whereNotNull('nama_instansi')
                ->where('nama_instansi', '!=', '')
                ->groupBy('nama_instansi')
                ->orderBy('total', 'desc')
                ->take(10)
                ->get();
        });
    }

    /**
     * Dapatkan Statistik Pekerjaan Terpopuler
     */
    public function getPekerjaanStats(): Collection
    {
        return Cache::remember(CacheService::LAPORAN_PEKERJAAN_STATS, 600, function () {
            return DB::table('alumni_pekerjaan')
                ->select('nama_perusahaan as pekerjaan', DB::raw('count(*) as total'))
                ->whereNotNull('nama_perusahaan')
                ->where('nama_perusahaan', '!=', '')
                ->groupBy('nama_perusahaan')
                ->orderBy('total', 'desc')
                ->take(10)
                ->get();
        });
    }

    /**
     * Format pendidikan menjadi readable string
     */
    public function formatPendidikan($pendidikanCollection): string
    {
        if (!$pendidikanCollection || $pendidikanCollection->isEmpty()) {
            return '-';
        }

        // Ambil pendidikan terakhir (dengan tahun lulus paling baru atau tahun masuk terbaru)
        $pendidikan = $pendidikanCollection->sortByDesc('tahun_lulus')->first();

        if (!$pendidikan) {
            return '-';
        }

        $text = $pendidikan->jenjang;
        if ($pendidikan->nama_instansi) {
            $text .= ' - ' . $pendidikan->nama_instansi;
        }
        if ($pendidikan->program_studi && $pendidikan->jenjang === 'Perguruan Tinggi') {
            $text .= ' (' . $pendidikan->program_studi . ')';
        }

        return $text;
    }

    /**
     * Format pekerjaan menjadi readable string
     */
    public function formatPekerjaan($pekerjaanCollection): string
    {
        if (!$pekerjaanCollection || $pekerjaanCollection->isEmpty()) {
            return '-';
        }

        // Ambil pekerjaan terkini (is_current = true)
        $pekerjaan = $pekerjaanCollection->where('is_current', true)->first();

        // Jika tidak ada is_current, ambil pekerjaan terakhir
        if (!$pekerjaan) {
            $pekerjaan = $pekerjaanCollection->last();
        }

        if (!$pekerjaan) {
            return '-';
        }

        $text = $pekerjaan->jabatan;
        if ($pekerjaan->nama_perusahaan) {
            $text .= ' di ' . $pekerjaan->nama_perusahaan;
        }

        return $text;
    }

    /**
     * Dapatkan Query Alumni untuk laporan angkatan atau PDF
     */
    public function getLaporanAlumniQuery(?Angkatan $angkatan, ?string $status)
    {
        $query = Alumni::with(['user', 'pendidikan', 'pekerjaan']);

        if ($angkatan) {
            $query->where('angkatan_id', $angkatan->id);
        }

        if ($status) {
            $query->where('status_verifikasi', $status);
        }

        return $query;
    }

    /**
     * Format Alumni Array untuk tabel laporan
     */
    public function formatAlumniLaporan($alumniRaw)
    {
        return $alumniRaw->map(function ($item) {
            return [
                'id' => $item->id,
                'nisn' => $item->nisn ?? '-',
                'nama_lengkap' => $item->nama_lengkap,
                'username' => $item->user->username ?? '-',
                'angkatan' => $item->angkatan->nama_angkatan ?? '-',
                'no_hp' => $item->no_hp ?? '-',
                'show_no_hp' => $item->show_no_hp ?? false,
                'alamat' => $item->alamat ?? '-',
                'pendidikan_terakhir' => $this->formatPendidikan($item->pendidikan),
                'pekerjaan_terkini' => $this->formatPekerjaan($item->pekerjaan),
                'status_verifikasi' => $item->status_verifikasi,
                'is_profile_complete' => $item->is_profile_complete,
            ];
        });
    }
}
