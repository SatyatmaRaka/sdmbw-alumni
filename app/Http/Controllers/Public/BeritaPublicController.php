<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaPublicController extends Controller
{
    /**
     * Display a listing of active news.
     */
    public function index(Request $request)
    {
        $query = Berita::where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sort: featured first, then latest
        $beritas = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        return view('public.berita.index', compact('beritas'));
    }

    /**
     * Display the specified news article.
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count quietly or without changing updated_at if possible
        $berita->timestamps = false;
        $berita->increment('views_count');
        $berita->timestamps = true;

        // Get related news (latest 3 other news)
        $relatedBeritas = Berita::where('id', '!=', $berita->id)
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('public.berita.show', compact('berita', 'relatedBeritas'));
    }
}
