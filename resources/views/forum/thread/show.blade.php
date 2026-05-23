@extends('layouts.landing')

@section('title', $thread->title . ' - Forum Alumni')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none" style="color: var(--color-primary);">Forum</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum.show', $thread->forum->slug) }}" class="text-decoration-none" style="color: var(--color-primary);">{{ $thread->forum->name }}</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;" aria-current="page">{{ $thread->title }}</li>
        </ol>
    </nav>

    <!-- Main Thread -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-md);">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-wrap gap-2 mb-3">
                @if($thread->is_pinned)
                    <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill me-1"></i>PINNED</span>
                @endif
                @if($thread->is_locked)
                    <span class="badge bg-secondary"><i class="bi bi-lock-fill me-1"></i>TERKUNCI</span>
                @endif
                <span class="badge bg-light text-dark border"><i class="bi bi-eye-fill me-1"></i> {{ $thread->views_count }} views</span>
            </div>

            <h1 class="h2 fw-bold mb-4" style="color: var(--color-primary-dark);">{{ $thread->title }}</h1>
            
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3 text-muted fw-bold" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    {{ strtoupper(substr($thread->user->username, 0, 1)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold" style="color: var(--color-primary-dark);">{{ $thread->user->username }}</div>
                    <div class="text-muted small">{{ $thread->created_at->translatedFormat('d F Y \p\u\k\u\l H:i') }}</div>
                </div>
                @auth
                    @if(auth()->id() === $thread->user_id || auth()->user()->isAdmin() || auth()->user()->isKepalaSekolah())
                        <form action="{{ route('forum.thread.destroy', $thread->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus thread ini? Semua balasan juga akan terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <div class="thread-body lh-lg" style="font-size: 1.05rem; color: #334155;">
                {!! nl2br(e($thread->body)) !!}
            </div>
        </div>
    </div>

    <!-- Replies Section -->
    <h4 class="mb-4 fw-bold" style="color: var(--color-primary-dark);">{{ $replies->total() }} Balasan</h4>

    <div class="d-flex flex-column gap-3 mb-5">
        @forelse($replies as $reply)
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-sm);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3 text-muted fw-bold" style="width: 40px; height: 40px;">
                            {{ strtoupper(substr($reply->user->username, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="color: var(--color-primary-dark);">{{ $reply->user->username }}</div>
                            <div class="text-muted" style="font-size: 0.8rem;">{{ $reply->created_at->diffForHumans() }}</div>
                        </div>
                        @auth
                            @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin() || auth()->user()->isKepalaSekolah())
                                <form action="{{ route('forum.reply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="reply-body" style="color: #475569;">
                        {!! nl2br(e($reply->body)) !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-5 bg-white shadow-sm border-0 rounded">
                <i class="bi bi-chat-dots fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada balasan.</h5>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mb-5">
        {{ $replies->links('pagination::bootstrap-5') }}
    </div>

    <!-- Reply Form -->
    <div class="card shadow-sm border-0" style="border-radius: var(--radius-md);" id="reply-form">
        <div class="card-body p-4 p-md-5">
            @if($thread->is_locked)
                <div class="alert alert-secondary mb-0 text-center">
                    <i class="bi bi-lock-fill fs-4 d-block mb-2"></i>
                    <strong>Thread Terkunci</strong><br>
                    Thread ini telah dikunci oleh moderator dan tidak dapat dibalas lagi.
                </div>
            @else
                @auth
                    <h5 class="fw-bold mb-3" style="color: var(--color-primary-dark);">Tambahkan Balasan</h5>
                    <form action="{{ route('forum.reply.store', $thread->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="body" rows="5" class="form-control @error('body') is-invalid @enderror" placeholder="Tulis balasan Anda di sini..." required minlength="5">{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary fw-bold" style="background: var(--color-primary); border-color: var(--color-primary);">
                                <i class="bi bi-send-fill me-1"></i> Kirim Balasan
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-4">
                        <p class="mb-3 text-muted">Anda harus masuk (login) untuk menambahkan balasan.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 fw-bold">Masuk Sekarang</a>
                    </div>
                @endauth
            @endif
        </div>
    </div>
</div>
@endsection
