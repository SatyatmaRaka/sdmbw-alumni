<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $testimonis = Testimoni::with(['alumni.angkatan'])
            ->when($search, function($query, $search) {
                return $query->whereHas('alumni', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                })->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil data alumni diurutkan per angkatan untuk mempermudah pemilihan di modal
        $alumnis = Alumni::with('angkatan')
            ->orderBy('angkatan_id', 'asc')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('admin.testimonis.index', compact('testimonis', 'alumnis', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'content' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);

        if(!isset($validated['is_featured'])) $validated['is_featured'] = false;
        if(!isset($validated['is_active'])) $validated['is_active'] = false;

        Testimoni::create($validated);
        Cache::forget('landing_testimonis');
        return back()->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $validated = $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'content' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);

        if(!isset($validated['is_featured'])) $validated['is_featured'] = false;
        if(!isset($validated['is_active'])) $validated['is_active'] = false;

        $testimoni->update($validated);
        Cache::forget('landing_testimonis');
        return back()->with('success', 'Testimoni berhasil diperbarui');
    }

    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();
        Cache::forget('landing_testimonis');
        return back()->with('success', 'Testimoni berhasil dihapus');
    }
}
