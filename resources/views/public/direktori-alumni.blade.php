@extends('layouts.landing')

@section('title', 'Direktori Alumni')

@section('content')
@push('styles')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --bg:            #F7F5F0;
        --danger:        #e53e3e;
        --radius:        14px;
        --transition:    all 0.26s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.7) inset, 0 8px 28px rgba(27,58,82,0.09);
        --shadow-hover:  0 2px 0 rgba(255,255,255,0.7) inset, 0 24px 56px rgba(27,58,82,0.16);
    }

    /* ─────────────────────────────────────────
       HERO
    ───────────────────────────────────────── */
    .hero-direktori {
        background: var(--primary-dark);
        padding: 4.5rem 0 5rem;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    /* dot grid */
    .hero-direktori::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    /* glow orb */
    .hero-direktori::after {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.55) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-direktori .container { position: relative; z-index: 1; }

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

    .hero-direktori h1 {
        color: white;
        font-family: 'DM Serif Display', serif;
        font-weight: 400;
        font-size: clamp(2rem, 5vw, 3.5rem);
        letter-spacing: -0.5px;
        line-height: 1.1;
        margin-bottom: 0.9rem;
    }

    .hero-direktori p {
        color: rgba(255,255,255,0.6);
        font-size: 1.05rem;
        max-width: 520px;
        line-height: 1.7;
    }

    /* ─────────────────────────────────────────
       FILTER CARD
    ───────────────────────────────────────── */
    .filter-wrapper {
        margin-top: -2.5rem;
        position: relative;
        z-index: 10;
        margin-bottom: 3rem;
    }

    .filter-section {
        background: white;
        padding: 2rem 2.25rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(232,200,122,0.2);
    }

    .filter-title {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-label {
        display: block;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.55rem;
        font-size: 0.85rem;
        letter-spacing: 0.2px;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.72rem 1rem;
        font-size: 0.9rem;
        color: var(--primary);
        transition: var(--transition);
        background: #fafbfc;
    }

    .form-control::placeholder { color: #b0bec5; }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(27,58,82,0.08);
        background: white;
        outline: none;
    }

    .btn-filter {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.72rem 2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        letter-spacing: 0.3px;
    }

    .btn-filter:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
        color: white;
    }

    .btn-reset {
        background: transparent;
        color: var(--danger);
        border: 1.5px solid var(--danger);
        padding: 0.72rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: var(--danger);
        color: white;
    }

    /* ─────────────────────────────────────────
       RESULTS COUNTER
    ───────────────────────────────────────── */
    .results-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .results-counter {
        font-size: 0.88rem;
        color: #64748b;
        font-weight: 500;
    }

    .results-counter strong { color: var(--primary); }

    /* ─────────────────────────────────────────
       ALUMNI GRID
    ───────────────────────────────────────── */
    .alumni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 1.75rem;
        margin-bottom: 3rem;
    }

    .alumni-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: var(--transition);
        border: 1px solid rgba(226,232,240,0.8);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .alumni-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(232,200,122,0.35);
    }

    /* image area */
    .alumni-card-image {
        position: relative;
        height: 200px;
        background: var(--primary-dark);
        overflow: hidden;
    }

    /* subtle gradient sheen on image placeholder */
    .alumni-card-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,37,52,0.55) 0%, transparent 55%);
        pointer-events: none;
    }

    .alumni-card-image img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.55s ease;
    }

    .alumni-card:hover .alumni-card-image img { transform: scale(1.07); }

    .alumni-card-image-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(145deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .alumni-card-image-placeholder i {
        font-size: 4.5rem;
        color: rgba(255,255,255,0.2);
    }

    /* .alumni-card-badge removed as per request to simplify UI */

    /* body */
    .alumni-card-body {
        padding: 1.4rem 1.5rem 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .alumni-card-name {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.3;
    }

    .alumni-card-angkatan {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        padding: 0.28rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin-bottom: 1.1rem;
        width: fit-content;
    }

    .alumni-card-item {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
        margin-bottom: 0.7rem;
        font-size: 0.88rem;
    }

    .alumni-card-item i {
        color: var(--primary);
        opacity: 0.55;
        margin-top: 0.15rem;
        width: 16px;
        flex-shrink: 0;
    }

    .alumni-card-item-label { color: #94a3b8; font-weight: 500; margin-right: 4px; }
    .alumni-card-item-value { color: var(--primary); font-weight: 600; }

    /* footer */
    .alumni-card-footer {
        padding-top: 1.1rem;
        border-top: 1px solid #f1f5f9;
        margin-top: auto;
    }

    .btn-profile {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.72rem 1rem;
        background: var(--primary);
        color: white;
        text-decoration: none;
        border-radius: 9px;
        text-align: center;
        font-weight: 700;
        font-size: 0.85rem;
        transition: var(--transition);
        border: none;
        letter-spacing: 0.2px;
    }

    .btn-profile:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.2);
        color: white;
    }

    /* ─────────────────────────────────────────
       EMPTY STATE
    ───────────────────────────────────────── */
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

    .btn-reset-empty {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 1.5rem;
        padding: 0.72rem 1.75rem;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        color: #64748b;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: var(--transition);
        background: white;
    }

    .btn-reset-empty:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #f8fafc;
    }

    /* ─────────────────────────────────────────
       PAGINATION
    ───────────────────────────────────────── */
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

    /* ─────────────────────────────────────────
       RESPONSIVE
    ───────────────────────────────────────── */
    @media (min-width: 768px) {
        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1.25rem;
            align-items: flex-end;
        }
    }

    @media (max-width: 767px) {
        .hero-direktori h1 { font-size: 2rem; }
        .hero-direktori { padding: 3.5rem 0 4rem; }
        .filter-wrapper { margin-top: -1.75rem; }
        .alumni-grid { grid-template-columns: 1fr; }
        .btn-filter { width: 100%; }
        .filter-section { padding: 1.5rem; }
    }
</style>
@endpush

{{-- ── HERO ───────────────────────────────────────────────────── --}}
<div class="hero-direktori">
    <div class="container text-center text-md-start">
        <div class="hero-eyebrow">
            <i class="bi bi-people-fill"></i> Jelajahi Network
        </div>
        <h1>Direktori Alumni</h1>
        <p>Temukan dan terhubung dengan ribuan alumni SD Muhammadiyah Birrul Walidain Kudus</p>
    </div>
</div>

<div class="container">

    {{-- ── FILTER ─────────────────────────────────────────────── --}}
    <div class="filter-wrapper">
        <div class="filter-section">
            <div class="filter-title">
                <i class="bi bi-sliders"></i> Filter Pencarian
            </div>

            <form action="{{ route('public.direktori') }}" method="GET">
                <div class="filter-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) auto; gap: 1.25rem; align-items: flex-end;">
                    {{-- Nama --}}
                    <div>
                        <label class="filter-label"><i class="bi bi-person me-1"></i> Cari Nama / NISN</label>
                        <input type="text" name="search" class="form-control"
                            placeholder="Masukkan nama..."
                            value="{{ request('search') }}">
                    </div>

                    {{-- Angkatan --}}
                    <div>
                        <label class="filter-label"><i class="bi bi-mortarboard me-1"></i> Angkatan</label>
                        <select name="angkatan_id" class="form-select">
                            <option value="">Semua Angkatan</option>
                            @foreach($angkatanList as $ang)
                                <option value="{{ $ang->id }}" {{ request('angkatan_id') == $ang->id ? 'selected' : '' }}>
                                    {{ $ang->nama_angkatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="filter-label"><i class="bi bi-gender-ambiguous me-1"></i> Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua JK</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-filter">
                            <i class="bi bi-search"></i>
                        </button>

                        @if(request('search') || request('angkatan_id') || request('jenis_kelamin'))
                            <a href="{{ route('public.direktori') }}" class="btn-reset" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── CONTENT ────────────────────────────────────────────── --}}
    @if($alumni->count() > 0)

        <div class="results-bar">
            <p class="results-counter mb-0">
                Menampilkan <strong>{{ $alumni->count() }}</strong> dari
                <strong>{{ $alumni->total() }}</strong> alumni
            </p>
        </div>

        <div class="alumni-grid">
            @foreach($alumni as $item)
                <div class="alumni-card">

                    {{-- Image --}}
                    <div class="alumni-card-image">

                        @php $fotoUtama = $item->fotos->where('is_main', true)->first(); @endphp

                        @if($fotoUtama)
                            <img src="{{ asset('storage/' . $fotoUtama->path_file) }}" alt="{{ $item->nama_lengkap }}">
                        @else
                            <div class="alumni-card-image-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="alumni-card-body">
                        <h5 class="alumni-card-name">{{ $item->nama_lengkap }}</h5>

                        <div class="mb-3">
                            <span class="alumni-card-angkatan">
                                <i class="bi bi-mortarboard-fill me-1"></i>
                                {{ $item->angkatan->nama_angkatan ?? '-' }}
                            </span>
                        </div>

                        {{-- NISN & Gender --}}
                        <div class="d-flex justify-content-between mb-3">
                            <div class="alumni-card-item mb-0">
                                <i class="bi bi-hash"></i>
                                <div>
                                    <span class="alumni-card-item-label">NISN:</span>
                                    <span class="alumni-card-item-value">{{ $item->nisn ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="alumni-card-item mb-0">
                                <i class="bi bi-gender-{{ $item->jenis_kelamin == 'L' ? 'male' : 'female' }}"></i>
                                <span class="alumni-card-item-value">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                        </div>

                        {{-- Tahun Lulus --}}
                        <div class="alumni-card-item mb-3">
                            <i class="bi bi-calendar-check"></i>
                            <div>
                                <span class="alumni-card-item-label">Angkatan Lulus:</span>
                                <span class="alumni-card-item-value">{{ $item->tahun_lulus }}</span>
                            </div>
                        </div>

                        {{-- Email --}}
                        @if($item->email)
                            <div class="alumni-card-item">
                                <i class="bi bi-envelope"></i>
                                <div>
                                    <span class="alumni-card-item-label">Email:</span>
                                    <span class="alumni-card-item-value text-break" style="font-size:0.83rem;">
                                        {{ strlen($item->email) > 20 ? substr($item->email, 0, 20) . '…' : $item->email }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="alumni-card-footer">
                            <a href="{{ route('public.profil', $item) }}" class="btn-profile">
                                <i class="bi bi-eye"></i> Lihat Profil Lengkap
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($alumni->hasPages())
            <div class="d-flex justify-content-center py-4">
                {{ $alumni->links('pagination::bootstrap-5') }}
            </div>
        @endif

    @else

        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3>Tidak Ada Hasil</h3>
            <p>Alumni yang Anda cari tidak ditemukan.<br>Coba ubah kata kunci atau filter pencarian.</p>
            <a href="{{ route('public.direktori') }}" class="btn-reset-empty">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Semua Filter
            </a>
        </div>

    @endif

</div>
@endsection
