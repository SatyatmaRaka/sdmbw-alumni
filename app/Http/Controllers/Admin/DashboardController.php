<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Alumni;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Services\CacheService;

class DashboardController extends Controller
{
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    /**
     * Tampilkan dashboard admin dengan statistik lengkap
     * Cache digunakan untuk mengurangi beban query database (TTL: 5 menit)
     *
     * @return View
     */
    public function index(): View
    {
        // 1. Statistik Utama — di-cache 5 menit
        $stats = Cache::remember(CacheService::ADMIN_DASHBOARD_STATS, 300, function () {
            return [
                'total_alumni'         => Alumni::count(),
                'total_angkatan'       => Angkatan::whereIn('status', ['AKTIF', 'LULUS'])->count(),
                'angkatan_aktif'       => Angkatan::where('status', 'AKTIF')->count(),
                'angkatan_lulus'       => Angkatan::where('status', 'LULUS')->count(),
                'angkatan_belum_lulus' => Angkatan::where('status', 'BELUM_LULUS')->count(),
                'profil_lengkap'       => Alumni::where('is_profile_complete', true)->count(),
                'profil_belum_lengkap' => Alumni::where('is_profile_complete', false)->count(),
                'status_distribution'  => Alumni::select('jenjang_pendidikan_saat_ini', \DB::raw('count(*) as total'))
                                            ->groupBy('jenjang_pendidikan_saat_ini')
                                            ->pluck('total', 'jenjang_pendidikan_saat_ini')
                                            ->toArray(),
            ];
        });

        // 2. Alumni terbaru dengan eager loading — di-cache 5 menit
        $recentAlumni = Cache::remember(CacheService::ADMIN_DASHBOARD_RECENT_ALUMNI, 300, function () {
            return Alumni::with(['user', 'angkatan'])
                ->latest()
                ->take(5)
                ->get();
        });

        // 3. Statistik per angkatan — di-cache 10 menit (jarang berubah)
        $angkatanStats = Cache::remember(CacheService::ADMIN_DASHBOARD_ANGKATAN_STATS, 600, function () {
            return Angkatan::whereIn('status', ['AKTIF', 'LULUS'])
                ->withCount('alumni')
                ->orderBy('id', 'asc')
                ->get();
        });

        // 4. Alumni dengan profil lengkap (update terkini) — di-cache 5 menit
        $recentUpdates = Cache::remember(CacheService::ADMIN_DASHBOARD_RECENT_UPDATES, 300, function () {
            return Alumni::with(['user', 'angkatan'])
                ->where('is_profile_complete', true)
                ->latest('updated_at')
                ->take(5)
                ->get();
        });

        return view('admin.dashboard', compact(
            'stats',
            'recentAlumni',
            'angkatanStats',
            'recentUpdates'
        ));
    }
}
