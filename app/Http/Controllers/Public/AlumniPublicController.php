<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use DB;

class AlumniPublicController extends Controller
{
    /**
     * Menampilkan direktori alumni publik dengan filter dinamis
     */
    public function direktori(Request $request)
    {
        $query = Alumni::where('status_verifikasi', 'verified');

        // Search berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        // Search berdasarkan NISN
        if ($request->filled('nisn')) {
            $query->where('nisn', 'like', '%' . $request->nisn . '%');
        }

        // Filter by angkatan (berdasarkan angkatan_id)
        if ($request->filled('angkatan')) {
            $query->where('angkatan_id', $request->angkatan);
        }

        // Sorting (opsional: urutkan berdasarkan nama)
        $alumni = $query->with('fotos', 'angkatan')
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(12);

        // Ambil semua angkatan untuk dropdown filter
        // Urutkan berdasarkan nomor angkatan (extract dari nama_angkatan)
        // Contoh: "Angkatan 1" -> 1, "Angkatan 10" -> 10
        $angkatanList = Angkatan::orderByRaw("CAST(REGEXP_SUBSTR(nama_angkatan, '[0-9]+') AS UNSIGNED) ASC")->get();

        return view('public.direktori-alumni', compact('alumni', 'angkatanList'));
    }

    /**
     * Menampilkan detail profil alumni publik
     */
    public function show(Alumni $alumni)
    {
        // Hanya tampilkan alumni yang sudah diverifikasi
        if ($alumni->status_verifikasi !== 'verified') {
            abort(404, 'Alumni tidak ditemukan');
        }

        // Load relasi
        $alumni->load('fotos', 'angkatan', 'pendidikan', 'pekerjaan');

        return view('public.profil-alumni', compact('alumni'));
    }
}
