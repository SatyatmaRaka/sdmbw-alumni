<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    // Admin Dashboard Cache Keys
    public const ADMIN_DASHBOARD_STATS = 'admin_dashboard_stats';
    public const ADMIN_DASHBOARD_RECENT_ALUMNI = 'admin_dashboard_recent_alumni';
    public const ADMIN_DASHBOARD_ANGKATAN_STATS = 'admin_dashboard_angkatan_stats';
    public const ADMIN_DASHBOARD_RECENT_UPDATES = 'admin_dashboard_recent_updates';

    // Kepala Sekolah Dashboard Cache Keys
    public const KEPALA_SEKOLAH_DASHBOARD_STATS = 'kepala_sekolah_dashboard_stats';
    public const KEPALA_SEKOLAH_ANGKATAN_STATS = 'kepala_sekolah_angkatan_stats';
    public const KEPALA_SEKOLAH_RECENT_ALUMNI = 'kepala_sekolah_recent_alumni';

    // Laporan Cache Keys
    public const LAPORAN_GENERAL_STATS = 'laporan_general_stats';
    public const LAPORAN_ANGKATAN_STATS = 'laporan_angkatan_stats';
    public const LAPORAN_PENDIDIKAN_STATS = 'laporan_pendidikan_stats';
    public const LAPORAN_PEKERJAAN_STATS = 'laporan_pekerjaan_stats';

    // Landing Page Cache Keys
    public const LANDING_STATS = 'landing_stats';

    /**
     * Clear admin and kepala sekolah dashboard caches.
     */
    public function clearDashboardCache(): void
    {
        Cache::forget(self::ADMIN_DASHBOARD_STATS);
        Cache::forget(self::ADMIN_DASHBOARD_RECENT_ALUMNI);
        Cache::forget(self::ADMIN_DASHBOARD_ANGKATAN_STATS);
        Cache::forget(self::ADMIN_DASHBOARD_RECENT_UPDATES);

        Cache::forget(self::KEPALA_SEKOLAH_DASHBOARD_STATS);
        Cache::forget(self::KEPALA_SEKOLAH_ANGKATAN_STATS);
        Cache::forget(self::KEPALA_SEKOLAH_RECENT_ALUMNI);
    }

    /**
     * Clear reports (laporan) caches.
     */
    public function clearLaporanCache(): void
    {
        Cache::forget(self::LAPORAN_GENERAL_STATS);
        Cache::forget(self::LAPORAN_ANGKATAN_STATS);
        Cache::forget(self::LAPORAN_PENDIDIKAN_STATS);
        Cache::forget(self::LAPORAN_PEKERJAAN_STATS);
    }

    /**
     * Clear landing page stats cache.
     */
    public function clearLandingCache(): void
    {
        Cache::forget(self::LANDING_STATS);
    }

    /**
     * Clear all caches related to alumni.
     */
    public function clearAllAlumniRelated(): void
    {
        $this->clearDashboardCache();
        $this->clearLaporanCache();
        $this->clearLandingCache();
    }
}
