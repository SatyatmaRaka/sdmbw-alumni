<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ForumThread;
use App\Models\Forum;

class ForumThreadController extends Controller
{
    /**
     * Tampilkan detail thread beserta reply.
     */
    public function show(ForumThread $thread)
    {
        // Increment views_count safely
        $thread->increment('views_count');

        $replies = $thread->replies()->with('user')->oldest()->paginate(20);

        return view('forum.thread.show', compact('thread', 'replies'));
    }

    /**
     * Tampilkan form pembuatan thread baru.
     */
    public function create()
    {
        $forums = Forum::orderBy('order')->get();
        return view('forum.thread.create', compact('forums'));
    }

    /**
     * Simpan thread baru.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'forum_id' => 'required|exists:forums,id',
            'title'    => 'required|string|max:255',
            'body'     => 'required|string|min:10',
        ]);

        $thread = ForumThread::create([
            'forum_id' => $validated['forum_id'],
            'user_id'  => auth()->id(),
            'title'    => $validated['title'],
            'body'     => $validated['body'],
        ]);

        return redirect()->route('forum.thread.show', $thread->slug)
                         ->with('success', 'Thread berhasil dibuat!');
    }

    /**
     * Hapus thread.
     */
    public function destroy(ForumThread $thread)
    {
        $user = auth()->user();

        // Hanya pemilik atau admin yang bisa hapus
        if ($thread->user_id !== $user->id && !$user->isAdmin() && !$user->isKepalaSekolah()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus thread ini.');
        }

        $thread->delete();

        return redirect()->route('forum.show', $thread->forum->slug)
                         ->with('success', 'Thread berhasil dihapus.');
    }
}
