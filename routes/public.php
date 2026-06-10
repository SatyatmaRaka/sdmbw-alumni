<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Public\AlumniPublicController;
use App\Http\Controllers\Public\BeritaPublicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\ForumReplyController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/direktori-alumni', [AlumniPublicController::class, 'direktori'])->name('public.direktori');
Route::get('/direktori-alumni/{alumni}', [AlumniPublicController::class, 'show'])->name('public.profil');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('throttle:10,1');
Route::get('/berita', [BeritaPublicController::class, 'index'])->name('public.berita.index');
Route::get('/berita/{slug}', [BeritaPublicController::class, 'show'])->name('public.berita.show');

Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/{forum:slug}', [ForumController::class, 'show'])->name('show');
    Route::get('/thread/{thread:slug}', [ForumThreadController::class, 'show'])->name('thread.show');
});

Route::middleware(['forum.auth'])->group(function () {
    Route::get('/forum-create-thread', [ForumThreadController::class, 'create'])->name('forum.thread.create');
    Route::post('/forum-thread', [ForumThreadController::class, 'store'])->name('forum.thread.store');
    Route::delete('/forum-thread/{thread}', [ForumThreadController::class, 'destroy'])->name('forum.thread.destroy');
    Route::post('/forum-thread/{thread}/reply', [ForumReplyController::class, 'store'])->name('forum.reply.store');
    Route::delete('/forum-reply/{reply}', [ForumReplyController::class, 'destroy'])->name('forum.reply.destroy');
});
