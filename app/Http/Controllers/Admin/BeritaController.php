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
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $beritas = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.berita.index', compact('beritas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'excerpt' => 'nullable|string|max:300',
            'is_featured' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('berita')) {
                Storage::disk('public')->makeDirectory('berita');
            }

            $filename = 'berita_' . time() . '_' . uniqid() . '.webp';
            $path = 'berita/' . $filename;

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image')->getPathname());
            $image->scale(width: 1000);
            $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80))->save(Storage::disk('public')->path($path));

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'excerpt' => 'nullable|string|max:300',
            'is_featured' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

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
            $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80))->save(Storage::disk('public')->path($path));

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

    public function toggleFeatured(Request $request, Berita $berita)
    {
        $berita->is_featured = !$berita->is_featured;
        $berita->save();

        Cache::forget('landing_beritas');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_featured' => $berita->is_featured,
                'message' => $berita->is_featured ? 'Berita berhasil disematkan sebagai unggulan!' : 'Berita dihapus dari unggulan.'
            ]);
        }

        return back()->with('success', 'Status unggulan berhasil diperbarui');
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
