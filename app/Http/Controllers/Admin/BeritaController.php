<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('berita')) {
                Storage::disk('public')->makeDirectory('berita');
            }

            $filename = 'berita_' . time() . '_' . uniqid() . '.webp';
            $path = 'berita/' . $filename;

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image')->getPathname());
            $image->scale(width: 1000);
            $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80))->save(storage_path('app/public/' . $path));

            $validated['image'] = $path;
        }

        Berita::create($validated);
        Cache::forget('landing_beritas');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan!',
                'redirect' => route('admin.beritas.index')
            ]);
        }

        return back()->with('success', 'Berita berhasil ditambahkan');
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($berita->image && Storage::disk('public')->exists($berita->image)) {
                Storage::disk('public')->delete($berita->image);
            }

            if (!Storage::disk('public')->exists('berita')) {
                Storage::disk('public')->makeDirectory('berita');
            }

            $filename = 'berita_' . time() . '_' . uniqid() . '.webp';
            $path = 'berita/' . $filename;

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image')->getPathname());
            $image->scale(width: 1000);
            $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80))->save(storage_path('app/public/' . $path));

            $validated['image'] = $path;
        }

        $berita->update($validated);
        Cache::forget('landing_beritas');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui!',
                'redirect' => route('admin.beritas.index')
            ]);
        }

        return back()->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(Berita $berita)
    {
        // Hapus file gambar
        if ($berita->image && Storage::disk('public')->exists($berita->image)) {
            Storage::disk('public')->delete($berita->image);
        }

        $berita->delete();
        Cache::forget('landing_beritas');

        return back()->with('success', 'Berita berhasil dihapus');
    }
}
