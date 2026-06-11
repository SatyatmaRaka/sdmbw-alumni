<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Enums\AlumniStatus;
use Illuminate\Http\Request;
use DB;

class AlumniPublicController extends Controller
{
    /**
     * Menampilkan direktori alumni dengan filter dinamis.
     * Dapat diakses oleh publik (guest) maupun alumni yang login.
     */
    public function direktori(Request $request)
    {
        // P1-2 FIX: Hanya tampilkan alumni yang belum ditolak (pending atau verified)
        // Alumni dengan status 'rejected' TIDAK ditampilkan di direktori publik.
        $query = Alumni::with(['fotos', 'angkatan'])
            ->where('status_verifikasi', '!=', AlumniStatus::REJECTED->value);

        // Search berdasarkan Nama atau NISN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Filter by Angkatan
        if ($request->filled('angkatan_id')) {
            $query->where('angkatan_id', $request->angkatan_id);
        }

        // Filter by Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $alumni = $query->orderBy('angkatan_id', 'asc')
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(12)
            ->withQueryString();

        // Ambil daftar angkatan untuk dropdown filter
        // Urutkan berdasarkan urutan angkatan (numeric)
        $angkatanList = Angkatan::get();

        return view('public.direktori-alumni', [
            'alumni' => $alumni,
            'angkatanList' => $angkatanList
        ]);
    }

    /**
     * Menampilkan detail profil alumni (publik)
     */
    public function show(Alumni $alumni)
    {
        // Load semua relasi yang diperlukan
        $alumni->load(['fotos', 'angkatan', 'pendidikan', 'pekerjaan']);

        return view('public.profil-alumni', compact('alumni'));
    }
}
