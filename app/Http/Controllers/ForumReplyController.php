<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ForumThread;
use App\Models\ForumReply;

class ForumReplyController extends Controller
{
    /**
     * Simpan balasan baru.
     */
    public function store(\Illuminate\Http\Request $request, ForumThread $thread)
    {
        if ($thread->is_locked) {
            return redirect()->back()->with('error', 'Thread ini telah dikunci, tidak bisa dibalas.');
        }

        $validated = $request->validate([
            'body' => 'required|string|min:5',
        ]);

        $thread->replies()->create([
            'user_id' => auth()->id(),
            'body'    => $validated['body'],
        ]);

        return redirect()->route('forum.thread.show', $thread->slug)
                         ->with('success', 'Balasan berhasil ditambahkan!');
    }

    /**
     * Hapus balasan.
     */
    public function destroy(ForumReply $reply)
    {
        $user = auth()->user();

        // Hanya pemilik atau admin yang bisa hapus
        if ($reply->user_id !== $user->id && !$user->isAdmin() && !$user->isKepalaSekolah()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus balasan ini.');
        }

        $reply->delete();

        return redirect()->back()->with('success', 'Balasan berhasil dihapus.');
    }
}
