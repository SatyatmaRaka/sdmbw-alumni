@extends('layouts.landing')

@section('title', $forum->name . ' - Forum Alumni')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none" style="color: var(--color-primary);">Forum</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $forum->name }}</li>
        </ol>
    </nav>

    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    {{ $forum->icon }}
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary-dark);">{{ $forum->name }}</h1>
                    <p class="text-muted mb-0 small">{{ $forum->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            @auth
                <a href="{{ route('forum.thread.create') }}?forum_id={{ $forum->id }}" class="btn btn-primary" style="background: var(--color-primary); border-color: var(--color-primary);">
                    <i class="bi bi-pencil-square me-2"></i> Buat Thread
                </a>
            @endauth
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: var(--radius-md);">
        <div class="card-body p-0">
            <div class="list-group list-group-flush rounded" style="border-radius: var(--radius-md);">
                @forelse($threads as $thread)
                    <a href="{{ route('forum.thread.show', $thread->slug) }}" class="list-group-item list-group-item-action p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    @if($thread->is_pinned)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill me-1"></i>PINNED</span>
                                    @endif
                                    @if($thread->is_locked)
                                        <span class="badge bg-secondary"><i class="bi bi-lock-fill me-1"></i>TERKUNCI</span>
                                    @endif
                                    <h5 class="mb-0 fw-bold" style="color: var(--color-primary-dark); font-size: 1.1rem;">
                                        {{ $thread->title }}
                                    </h5>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-person-circle me-1"></i> {{ $thread->user->username }} &bull; 
                                    <i class="bi bi-clock me-1"></i> {{ $thread->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex justify-content-md-end gap-4 text-muted small">
                                    <div class="text-center">
                                        <div class="fw-bold fs-6">{{ $thread->replies_count }}</div>
                                        <div>Balasan</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold fs-6">{{ $thread->views_count }}</div>
                                        <div>Dilihat</div>
                                    </div>
                                </div>
                                @if($thread->replies->isNotEmpty())
                                    <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                        Balasan terakhir: {{ $thread->replies->first()->created_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-chat-square-text fs-1 opacity-50 mb-3 d-block"></i>
                        <h5>Belum ada thread di kategori ini.</h5>
                        <p>Jadilah yang pertama memulai diskusi!</p>
                        @auth
                            <a href="{{ route('forum.thread.create') }}?forum_id={{ $forum->id }}" class="btn btn-outline-primary mt-2">Buat Thread</a>
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $threads->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
