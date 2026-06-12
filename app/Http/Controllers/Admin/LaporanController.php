<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\LaporanService;
use App\Enums\AlumniStatus;

class LaporanController extends Controller
{
    private LaporanService $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Tampilkan halaman laporan utama
     */
    public function index(Request $request)
    {
        $stats = $this->laporanService->getGeneralStats();
        $angkatanStats = $this->laporanService->getAngkatanStats();
        $pendidikanStats = $this->laporanService->getPendidikanStats();
        $pekerjaanStats = $this->laporanService->getPekerjaanStats();

        return view('admin.laporan.index', compact(
            'stats',
            'angkatanStats',
            'pendidikanStats',
            'pekerjaanStats'
        ));
    }

    /**
     * Laporan mendetail per angkatan tertentu
     */
    public function angkatan(Request $request, Angkatan $angkatan)
    {
        $alumniQuery = $this->laporanService->getLaporanAlumniQuery($angkatan, $request->status);
        $alumni = $alumniQuery->orderBy('nama_lengkap')->get();

        // Format alumni dengan data pendidikan & pekerjaan yang readable
        $alumniFormatted = $this->laporanService->formatAlumniLaporan($alumni);

        // Statistik angkatan
        $stats = [
            'total'    => $alumni->count(),
            'verified' => $alumni->where('status_verifikasi', AlumniStatus::VERIFIED->value)->count(),
            'pending'  => $alumni->where('status_verifikasi', AlumniStatus::PENDING->value)->count(),
            'rejected' => $alumni->where('status_verifikasi', AlumniStatus::REJECTED->value)->count(),
            'lengkap'  => $alumni->where('is_profile_complete', true)->count(),
            'belum_lengkap' => $alumni->where('is_profile_complete', false)->count(),
        ];

        return view('admin.laporan.angkatan', compact('angkatan', 'alumniFormatted', 'stats'));
    }

    /**
     * Export laporan alumni ke PDF
     */
    public function exportPdf(Request $request)
    {
        $angkatan = null;
        if ($request->filled('angkatan_id')) {
            $angkatan = Angkatan::find($request->angkatan_id);
        }

        $alumniQuery = $this->laporanService->getLaporanAlumniQuery($angkatan, $request->status);
        
        // Eager load angkatan for PDF
        $alumniQuery->with('angkatan');
        
        $alumniRaw = $alumniQuery->orderBy('angkatan_id', 'asc')->orderBy('nama_lengkap', 'asc')->get();

        $alumni = $this->laporanService->formatAlumniLaporan($alumniRaw);

        $data = [
            'alumni'         => $alumni,
            'angkatan'       => $angkatan,
            'filter_status'  => $request->status ?? null,
            'tanggal_cetak'  => now()->locale('id')->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Serif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false);

        $filename = 'laporan-alumni-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
