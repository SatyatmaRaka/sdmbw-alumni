@extends('layouts.alumni')

@section('title', 'Direktori Alumni')

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── PAGE HEADER ─── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .page-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.6rem;
        color: var(--primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 1em;
        background: var(--accent);
        border-radius: 2px;
        vertical-align: middle;
    }

    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary);
        color: white;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    /* ─── FILTER CARD ─── */
    .filter-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.75rem;
    }

    .filter-card-header {
        background: var(--primary);
        padding: 0.85rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.3px;
        position: relative;
    }

    .filter-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .filter-card-body { padding: 1.25rem 1.5rem; }

    .filter-label {
        display: block;
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.4rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 0.875rem;
        color: var(--primary);
        background: #f8fafc;
        transition: var(--transition);
    }

    .filter-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
        outline: none;
    }

    .filter-input::placeholder { color: #b0bec5; }

    .btn-filter {
        width: 100%;
        padding: 0.68rem 1rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .btn-filter:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
    }

    /* ─── ALUMNI CARD ─── */
    .alumni-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        height: 100%;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .alumni-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 2px 0 rgba(255,255,255,0.8) inset, 0 20px 48px rgba(27,58,82,0.13);
        border-color: rgba(232,200,122,0.3);
    }

    .alumni-card-top {
        background: var(--primary-dark);
        height: 52px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .alumni-card-top::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 14px 14px;
    }

    .alumni-card-top-stripe {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(to right, var(--accent), transparent);
        transition: var(--transition);
    }

    .alumni-card:hover .alumni-card-top-stripe { opacity: 0; }

    .alumni-card-body {
        padding: 0 1.25rem 1.5rem;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* avatar */
    .alumni-avatar {
        width: 80px; height: 80px;
        border-radius: 20px;
        border: 3px solid white;
        box-shadow: 0 6px 18px rgba(27,58,82,0.15);
        overflow: hidden;
        margin: -40px auto 1rem;
        position: relative;
        z-index: 10;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
        transition: var(--transition);
    }

    .alumni-card:hover .alumni-avatar { transform: scale(1.06); }

    .alumni-avatar img {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    .avatar-initial {
        font-size: 1.75rem;
        font-weight: 800;
        color: rgba(255,255,255,0.22);
    }

    .alumni-name {
        font-weight: 800;
        font-size: 0.92rem;
        color: var(--primary);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .alumni-angkatan {
        font-size: 0.77rem;
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .btn-profil {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 0.55rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        color: var(--primary);
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        transition: var(--transition);
        background: white;
        margin-top: auto;
    }

    .btn-profil:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    /* ─── EMPTY STATE ─── */
    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }

    .empty-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.1rem;
        font-size: 1.75rem;
        color: #94a3b8;
    }

    .empty-state h6 { color: var(--primary); font-weight: 700; margin-bottom: 0.4rem; }
    .empty-state p  { color: #94a3b8; font-size: 0.85rem; margin-bottom: 1rem; }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.55rem 1.25rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        color: var(--primary);
        font-weight: 700;
        font-size: 0.83rem;
        text-decoration: none;
        transition: var(--transition);
        background: white;
    }

    .btn-reset:hover { background: var(--primary); color: white; border-color: var(--primary); }

    /* ─── PAGINATION ─── */
    .pagination-wrap { margin-top: 2.5rem; display: flex; justify-content: center; }

    .pagination .page-link {
        color: var(--primary);
        border-color: #e2e8f0;
        font-weight: 600;
        font-size: 0.85rem;
        border-radius: 8px !important;
        margin: 0 2px;
        padding: 0.45rem 0.85rem;
        transition: var(--transition);
    }

    .pagination .page-link:hover { background: var(--primary); color: white; border-color: var(--primary); }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(27,58,82,0.25);
    }

    .pagination .page-item.disabled .page-link { color: #cbd5e1; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 576px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .filter-card-body .row > div { margin-bottom: 0.5rem; }
    }
</style>

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <h4 class="page-title">Direktori Alumni</h4>
    <span class="total-badge">
        <i class="bi bi-people-fill"></i> {{ $alumni->total() }} Alumni Terdaftar
    </span>
</div>

{{-- ── FILTER ── --}}
<div class="filter-card">
    <div class="filter-card-header">
        <i class="bi bi-funnel-fill"></i> Filter &amp; Pencarian
    </div>
    <div class="filter-card-body">
        <form action="{{ route('alumni.direktori.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="filter-label">Cari Nama</label>
                    <input type="text"
                           name="search"
                           class="filter-input"
                           placeholder="Masukkan nama alumni..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="filter-label">Pilih Angkatan</label>
                    <select name="angkatan" class="filter-input">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatan as $a)
                            <option value="{{ $a->id }}" {{ request('angkatan') == $a->id ? 'selected' : '' }}>
                                {{ $a->nama_angkatan }} ({{ $a->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel"></i> Filter Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── ALUMNI GRID ── --}}
<div class="row g-4">
    @forelse($alumni as $item)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            @php $foto = $item->fotos->where('is_main', true)->first(); @endphp
            <div class="alumni-card">
                <div class="alumni-card-top">
                    <div class="alumni-card-top-stripe"></div>
                </div>
                <div class="alumni-card-body">
                    <div class="alumni-avatar">
                        @if($foto)
                            <img src="{{ asset('storage/' . $foto->path_file) }}"
                                 alt="{{ $item->nama_lengkap }}">
                        @else
                            <span class="avatar-initial">
                                {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                            </span>
                        @endif
                    </div>

                    <p class="alumni-name">{{ $item->nama_lengkap }}</p>
                    <p class="alumni-angkatan">{{ $item->angkatan->nama_angkatan ?? 'Tanpa Angkatan' }}</p>

                    <a href="{{ route('alumni.direktori.show', $item->id) }}" class="btn-profil">
                        <i class="bi bi-person-fill"></i> Lihat Profil
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h6>Tidak Ada Hasil</h6>
                <p>Alumni tidak ditemukan dengan filter yang dipilih.</p>
                <a href="{{ route('alumni.direktori.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                </a>
            </div>
        </div>
    @endforelse
</div>

{{-- ── PAGINATION ── --}}
<div class="pagination-wrap">
    {{ $alumni->appends(request()->query())->links() }}
</div>

@endsection
