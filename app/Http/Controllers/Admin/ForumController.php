<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = ForumThread::with(['forum', 'user'])->withCount('replies')->latest();

        if ($request->filled('forum_id')) {
            $query->where('forum_id', $request->forum_id);
        }

        $threads = $query->paginate(15);
        $forums = Forum::orderBy('order')->get();

        return view('admin.forum.index', compact('threads', 'forums'));
    }

    public function pin(ForumThread $thread)
    {
        $thread->update(['is_pinned' => !$thread->is_pinned]);
        $status = $thread->is_pinned ? 'dipin' : 'di-unpin';
        return redirect()->back()->with('success', "Thread berhasil $status.");
    }

    public function lock(ForumThread $thread)
    {
        $thread->update(['is_locked' => !$thread->is_locked]);
        $status = $thread->is_locked ? 'dikunci' : 'dibuka kuncinya';
        return redirect()->back()->with('success', "Thread berhasil $status.");
    }

    public function destroyThread(ForumThread $thread)
    {
        $thread->forceDelete();
        return redirect()->back()->with('success', 'Thread berhasil dihapus permanen.');
    }

    public function destroyReply(ForumReply $reply)
    {
        $reply->forceDelete();
        return redirect()->back()->with('success', 'Balasan berhasil dihapus permanen.');
    }
}
