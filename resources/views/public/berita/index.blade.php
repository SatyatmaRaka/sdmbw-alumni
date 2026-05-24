@extends('layouts.landing')

@section('title', 'Berita & Informasi')

@section('content')
@push('styles')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #E8C87A;
        --accent-soft:   rgba(232,200,122,0.12);
        --bg:            #F7F5F0;
        --radius:        14px;
        --transition:    all 0.26s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.7) inset, 0 8px 28px rgba(27,58,82,0.09);
        --shadow-hover:  0 2px 0 rgba(255,255,255,0.7) inset, 0 24px 56px rgba(27,58,82,0.16);
    }

    /* ── HERO ── */
    .hero-berita {
        background: var(--primary-dark);
        padding: 4.5rem 0 5rem;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    .hero-berita::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    .hero-berita::after {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.55) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-berita .container { position: relative; z-index: 1; }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(232,200,122,0.12);
        border: 1px solid rgba(232,200,122,0.3);
        color: var(--accent);
        padding: 0.45rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        margin-bottom: 1.4rem;
    }

    .hero-berita h1 {
        color: white;
        font-family: 'DM Serif Display', serif;
        font-weight: 400;
        font-size: clamp(2rem, 5vw, 3.5rem);
        letter-spacing: -0.5px;
        line-height: 1.1;
        margin-bottom: 0.9rem;
    }

    .hero-berita p {
        color: rgba(255,255,255,0.6);
        font-size: 1.05rem;
        max-width: 520px;
        line-height: 1.7;
    }

    /* ── FILTER / SEARCH CARD ── */
    .filter-wrapper {
        margin-top: -2.5rem;
        position: relative;
        z-index: 10;
        margin-bottom: 3rem;
    }

    .filter-section {
        background: white;
        padding: 1.75rem 2rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(232,200,122,0.2);
    }

    .form-control-search {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        color: var(--primary);
        transition: var(--transition);
        background: #fafbfc;
    }

    .form-control-search:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(27,58,82,0.08);
        background: white;
        outline: none;
    }

    .btn-search {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        transition: var(--transition);
        letter-spacing: 0.3px;
    }

    .btn-search:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
        color: white;
    }

    /* ── GRID BERITA ── */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .berita-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: var(--transition);
        border: 1px solid rgba(226,232,240,0.8);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .berita-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(232,200,122,0.4);
    }

    /* featured border highlight */
    .berita-card.featured-card {
        border: 1.5px solid rgba(232,200,122,0.6);
        background: linear-gradient(to bottom, #fff 0%, #fffbf2 100%);
    }

    .berita-card-image {
        position: relative;
        height: 220px;
        background: var(--primary-dark);
        overflow: hidden;
    }

    .berita-card-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,37,52,0.4) 0%, transparent 60%);
        pointer-events: none;
    }

    .berita-card-image img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .berita-card:hover .berita-card-image img { transform: scale(1.06); }

    .featured-badge {
        position: absolute;
        top: 14px; left: 14px;
        z-index: 5;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 50px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(217,119,6,0.3);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .berita-card-body {
        padding: 1.5rem 1.6rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .berita-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 0.8rem;
        font-weight: 500;
    }

    .berita-meta i {
        font-size: 0.85rem;
    }

    .berita-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.4;
        margin-bottom: 0.8rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        /* Line clamp at 2 lines */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3.2em;
    }

    .berita-excerpt {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
        /* Line clamp at 3 lines */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-card-footer {
        padding-top: 1.1rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-read {
        color: var(--primary-light);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
    }

    .btn-read:hover {
        color: var(--primary);
        transform: translateX(4px);
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: var(--radius);
        border: 1.5px dashed #cbd5e1;
        box-shadow: var(--shadow-card);
    }

    .empty-state-icon {
        width: 80px; height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon i {
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .empty-state h3 {
        color: var(--primary);
        font-weight: 800;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }

    .empty-state p { color: #94a3b8; font-size: 0.95rem; }

    /* ── PAGINATION ── */
    .pagination { gap: 4px; }
    .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #e2e8f0 !important;
        color: var(--primary) !important;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.5rem 0.9rem;
        transition: var(--transition);
    }
    .page-link:hover { background: var(--accent-soft) !important; border-color: var(--accent) !important; }
    .page-item.active .page-link {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    @media (max-width: 767px) {
        .hero-berita h1 { font-size: 2rem; }
        .hero-berita { padding: 3.5rem 0 4rem; }
        .filter-wrapper { margin-top: -1.75rem; }
        .berita-grid { grid-template-columns: 1fr; }
        .filter-section { padding: 1.25rem; }
    }
</style>
@endpush

{{-- Hero Section --}}
<div class="hero-berita">
    <div class="container text-center text-md-start">
        <div class="hero-eyebrow">
            <i class="bi bi-newspaper"></i> Kabar Almamater
        </div>
        <h1>Berita & Informasi</h1>
        <p>Temukan kabar terbaru, pengumuman resmi, dan dokumentasi kegiatan dari almamater tercinta.</p>
    </div>
</div>

<div class="container">
    {{-- Search Form --}}
    <div class="filter-wrapper">
        <div class="filter-section">
            <form action="{{ route('public.berita.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-9 col-sm-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control form-control-search border-0 bg-light" 
                                placeholder="Cari judul berita atau topik..." 
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 d-grid">
                        <button type="submit" class="btn-search fw-bold">Cari Berita</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Content --}}
    @if($beritas->count() > 0)
        <div class="berita-grid">
            @foreach($beritas as $berita)
                <div class="berita-card {{ $berita->is_featured ? 'featured-card' : '' }}">
                    @if($berita->is_featured)
                        <div class="featured-badge">
                            <i class="bi bi-star-fill"></i> Unggulan
                        </div>
                    @endif

                    {{-- Image --}}
                    <div class="berita-card-image">
                        @if($berita->image)
                            <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
                                <i class="bi bi-newspaper fs-1 text-white opacity-25"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="berita-card-body">
                        <div class="berita-meta">
                            <span><i class="bi bi-calendar3 me-1"></i> {{ $berita->created_at->format('d M Y') }}</span>
                            <span><i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count) }} dibaca</span>
                        </div>

                        <h5 class="berita-title">
                            <a href="{{ route('public.berita.show', $berita->slug) }}" class="text-decoration-none text-primary-dark">
                                {{ $berita->title }}
                            </a>
                        </h5>

                        <p class="berita-excerpt">
                            {{ $berita->excerpt ?? Str::limit(strip_tags($berita->content), 120, '...') }}
                        </p>

                        <div class="berita-card-footer">
                            <a href="{{ route('public.berita.show', $berita->slug) }}" class="btn-read">
                                Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($beritas->hasPages())
            <div class="d-flex justify-content-center py-4">
                {{ $beritas->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @else
        <div class="empty-state mb-5">
            <div class="empty-state-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <h3>Tidak Ada Berita</h3>
            <p>Berita yang Anda cari tidak ditemukan.<br>Silakan bersihkan kata kunci pencarian untuk kembali melihat semua berita.</p>
            @if(request('search'))
                <a href="{{ route('public.berita.index') }}" class="btn btn-navbar-accent text-decoration-none px-4 py-2 mt-2">
                    <i class="bi bi-arrow-counterclockwise"></i> Lihat Semua Berita
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
