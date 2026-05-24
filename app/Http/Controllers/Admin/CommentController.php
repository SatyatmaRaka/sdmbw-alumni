<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    /**
     * Tampilkan daftar komentar anonim dengan pagination.
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Hapus komentar anonim dari database.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        // Hapus cache komentar agar tampilan di halaman utama terupdate
        Cache::forget('landing_comments');
        
        return back()->with('success', 'Komentar anonim berhasil dihapus.');
    }
}
