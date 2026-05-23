@extends('layouts.landing')

@section('title', 'Forum Alumni')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold" style="font-family: 'DM Serif Display', serif; color: var(--color-primary-dark);">
                Forum Alumni SD Muhammadiyah Birrul Walidain
            </h1>
            <p class="text-muted mt-3" style="max-width: 600px; margin: 0 auto;">
                Wadah diskusi, berbagi pengalaman, dan menjalin kembali komunikasi antar alumni. Pilih kategori diskusi di bawah ini untuk mulai berinteraksi.
            </p>
            @auth
                <div class="mt-4">
                    <a href="{{ route('forum.thread.create') }}" class="btn btn-primary" style="background: var(--color-primary); border-color: var(--color-primary);">
                        <i class="bi bi-pencil-square me-2"></i> Buat Thread Baru
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <div class="row g-4">
        @foreach($forums as $forum)
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0" style="border-radius: var(--radius-md); transition: var(--transition);">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 2rem;">
                                {{ $forum->icon }}
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold" style="color: var(--color-primary-dark);">
                                    <a href="{{ route('forum.show', $forum->slug) }}" class="text-decoration-none text-inherit stretched-link" style="color: inherit;">
                                        {{ $forum->name }}
                                    </a>
                                </h4>
                                <div class="text-muted small">
                                    <span class="me-3"><i class="bi bi-file-text me-1"></i> {{ $forum->threads_count }} Topik</span>
                                    <span><i class="bi bi-chat-dots me-1"></i> {{ $forum->replies_count }} Balasan</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted flex-grow-1">
                            {{ $forum->description }}
                        </p>
                        <hr class="my-3 opacity-25">
                        <div class="small">
                            @if($forum->threads->isNotEmpty())
                                @php $latest = $forum->threads->first(); @endphp
                                <div class="text-truncate">
                                    <span class="fw-semibold">Terbaru:</span> 
                                    <a href="{{ route('forum.thread.show', $latest->slug) }}" class="text-decoration-none position-relative z-1" style="color: var(--color-primary);">{{ $latest->title }}</a>
                                </div>
                                <div class="text-muted mt-1" style="font-size: 0.8rem;">
                                    Oleh {{ $latest->user->username }} &bull; {{ $latest->created_at->diffForHumans() }}
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum ada diskusi di kategori ini.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
@endsection
