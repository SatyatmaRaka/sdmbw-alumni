<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Alumni;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik lengkap
     * Cache digunakan untuk mengurangi beban query database (TTL: 5 menit)
     *
     * @return View
     */
    public function index(): View
    {
        // 1. Statistik Utama — di-cache 5 menit
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
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
        $recentAlumni = Cache::remember('admin_dashboard_recent_alumni', 300, function () {
            return Alumni::with(['user', 'angkatan'])
                ->latest()
                ->take(5)
                ->get();
        });

        // 3. Statistik per angkatan — di-cache 10 menit (jarang berubah)
        $angkatanStats = Cache::remember('admin_dashboard_angkatan_stats', 600, function () {
            return Angkatan::whereIn('status', ['AKTIF', 'LULUS'])
                ->withCount('alumni')
                ->orderBy('id', 'asc')
                ->get();
        });

        // 4. Alumni dengan profil lengkap (update terkini) — di-cache 5 menit
        $recentUpdates = Cache::remember('admin_dashboard_recent_updates', 300, function () {
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
