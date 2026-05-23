<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Forum;

class ForumController extends Controller
{
    /**
     * Tampilkan semua kategori forum.
     */
    public function index()
    {
        $forums = Forum::withCount(['threads', 'threads as replies_count' => function ($query) {
            $query->join('forum_replies', 'forum_threads.id', '=', 'forum_replies.forum_thread_id');
        }])
        ->with(['threads' => function ($query) {
            $query->latest()->limit(1)->with('user');
        }])
        ->orderBy('order')
        ->get();

        return view('forum.index', compact('forums'));
    }

    /**
     * Tampilkan daftar thread dalam kategori forum tertentu.
     */
    public function show(Forum $forum)
    {
        $threads = $forum->threads()
            ->with(['user', 'replies' => function($q) { $q->latest()->limit(1); }])
            ->withCount('replies')
            ->orderByDesc('is_pinned')
            ->latest()
            ->paginate(15);

        return view('forum.show', compact('forum', 'threads'));
    }
}
