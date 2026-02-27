@extends('layouts.alumni')

@section('title', 'Direktori Alumni')

@section('content')

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
        --shadow-card:   0 2px 0 rgba(255,255,255,0.9) inset, 0 4px 20px rgba(27,58,82,0.07);
        --shadow-hover:  0 2px 0 rgba(255,255,255,0.9) inset, 0 16px 40px rgba(27,58,82,0.14);
    }

    /* ─────────────────────────────────────────
        PAGE HEADER
    ───────────────────────────────────────── */
    .page-heading { margin-bottom: 1.75rem; }

    .page-heading h3 {
        font-family: 'DM Serif Display', serif;
        font-weight: 400;
        font-size: 1.9rem;
        color: var(--primary);
        letter-spacing: -0.3px;
        margin-bottom: 0.3rem;
    }

    .page-heading p {
        color: #64748b;
        font-size: 0.92rem;
        margin: 0;
    }

    /* ─────────────────────────────────────────
       FILTER CARD
    ───────────────────────────────────────── */
    .filter-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .filter-card-header {
        background: var(--primary);
        padding: 0.85rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }

    .filter-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .filter-card-body { padding: 1.5rem; }

    .filter-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.3px;
        color: #94a3b8;
        margin-bottom: 0.45rem;
        display: block;
    }

    .custom-input {
        border: 1.5px solid #e2e8f0 !important;
        padding: 0.72rem 1rem !important;
        background-color: #fafbfc !important;
        border-radius: 10px !important;
        font-size: 0.88rem !important;
        color: var(--primary) !important;
        transition: var(--transition);
    }

    .custom-input::placeholder { color: #b0bec5 !important; }

    .custom-input:focus {
        background-color: #fff !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.08) !important;
        outline: none;
    }

    /* input-group fix */
    .input-group .custom-input.form-control {
        border-left: none !important;
        border-radius: 0 10px 10px 0 !important;
    }

    .input-group .input-group-text.custom-input {
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        padding-right: 0 !important;
    }

    .btn-search {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.72rem 1.5rem;
        font-weight: 700;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: var(--transition);
        width: 100%;
        letter-spacing: 0.2px;
    }

    .btn-search:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.2);
        color: white;
    }

    /* ─────────────────────────────────────────
       RESULTS BAR
    ───────────────────────────────────────── */
    .results-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .results-count {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .results-count strong { color: var(--primary); }

    /* ─────────────────────────────────────────
       ALUMNI CARDS
    ───────────────────────────────────────── */
    .alumni-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .alumni-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(232,200,122,0.3);
    }

    /* top accent bar */
    .alumni-card::before {
        content: '';
        display: block;
        height: 3px;
        background: linear-gradient(to right, var(--accent), transparent);
        flex-shrink: 0;
    }

    .alumni-card-body {
        padding: 1.4rem 1.5rem 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    /* avatar */
    .avatar-wrap {
        width: 60px;
        min-width: 60px;
        height: 60px;
        border-radius: 16px;
        background: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    /* subtle gradient shimmer */
    .avatar-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(145deg, rgba(255,255,255,0.07) 0%, transparent 60%);
    }

    .avatar-wrap i {
        font-size: 1.9rem;
        color: rgba(255,255,255,0.2);
    }

    .alumni-name {
        font-weight: 800;
        font-size: 1rem;
        color: var(--primary);
        margin-bottom: 0.35rem;
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .alumni-angkatan-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        padding: 0.25rem 0.7rem;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .divider { height: 1px; background: #f1f5f9; margin: 1rem 0; }

    /* info row */
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
    }

    .info-row:last-of-type { margin-bottom: 0; }

    .info-icon-box {
        width: 32px;
        min-width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .info-icon-edu  { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .info-icon-work { background: rgba(22,163,74,0.1);  color: #16a34a; }

    .info-label-small {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.15rem;
    }

    .info-value-text {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary);
        line-height: 1.35;
    }

    .info-value-empty {
        font-size: 0.82rem;
        color: #cbd5e1;
        font-style: italic;
    }

    /* action button */
    .btn-profile {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.7rem 1rem;
        background: white;
        color: var(--primary);
        font-weight: 700;
        font-size: 0.83rem;
        border-radius: 9px;
        border: 1.5px solid #e2e8f0;
        text-decoration: none;
        transition: var(--transition);
        margin-top: auto;
    }

    .btn-profile:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 6px 16px rgba(27,58,82,0.18);
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
        font-size: 0.85rem;
        padding: 0.45rem 0.85rem;
        background: white !important;
        transition: var(--transition);
    }

    .page-link:hover {
        background: var(--accent-soft) !important;
        border-color: var(--accent) !important;
    }

    .page-item.active .page-link {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    /* ─────────────────────────────────────────
       EMPTY STATE
    ───────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 4.5rem 2rem;
        background: white;
        border-radius: var(--radius);
        border: 1.5px dashed #cbd5e1;
        box-shadow: var(--shadow-card);
    }

    .empty-icon-wrap {
        width: 80px; height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon-wrap i { font-size: 2.4rem; color: #94a3b8; }

    .empty-state h4 {
        color: var(--primary);
        font-weight: 800;
        font-size: 1.15rem;
        margin-bottom: 0.4rem;
    }

    .empty-state p { color: #94a3b8; font-size: 0.9rem; }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 1.4rem;
        padding: 0.7rem 1.75rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-reset:hover {
        background: var(--primary-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.2);
    }
</style>

{{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
<div class="page-heading">
    <h3>Direktori Alumni</h3>
    <p>Temukan dan terhubung dengan rekan alumni lintas angkatan.</p>
</div>

{{-- ── FILTER CARD ──────────────────────────────────────────────── --}}
<div class="filter-card">
    <div class="filter-card-header">
        <i class="bi bi-sliders"></i> Filter Pencarian
    </div>
    <div class="filter-card-body">
        <form action="{{ route('landing.direktori') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="filter-label">Angkatan</label>
                    <select name="angkatan_id" class="form-select custom-input">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->id }}" {{ request('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                                {{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="filter-label">Cari Nama / NISN</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 custom-input">
                            <i class="bi bi-search text-muted" style="font-size:0.85rem;"></i>
                        </span>
                        <input type="text" name="search"
                                class="form-control border-start-0 custom-input"
                                placeholder="Masukkan nama atau NISN..."
                                value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn-search">
                        <i class="bi bi-search"></i> Cari Alumni
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── CONTENT ──────────────────────────────────────────────────── --}}
@if($alumnis->count() > 0)

    <div class="results-bar">
        <p class="results-count mb-0">
            Menampilkan <strong>{{ $alumnis->count() }}</strong> dari
            <strong>{{ $alumnis->total() }}</strong> alumni
        </p>
    </div>

    <div class="row g-3 mb-5">
        @foreach($alumnis as $alumni)
            <div class="col-md-6 col-lg-4">
                <div class="alumni-card">
                    <div class="alumni-card-body">

                        {{-- Header --}}
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <div class="avatar-wrap">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="min-w-0" style="min-width:0;">
                                <p class="alumni-name">{{ $alumni->nama_lengkap }}</p>
                                <span class="alumni-angkatan-badge">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Info --}}
                        <div class="mb-3">
                            <div class="info-row">
                                <div class="info-icon-box info-icon-edu">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <span class="info-label-small">Pendidikan</span>
                                    @if($alumni->pendidikan_lanjutan)
                                        <span class="info-value-text">{{ $alumni->pendidikan_lanjutan }}</span>
                                    @else
                                        <span class="info-value-empty">Belum diperbarui</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-icon-box info-icon-work">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div>
                                    <span class="info-label-small">Pekerjaan</span>
                                    @if($alumni->pekerjaan)
                                        <span class="info-value-text">{{ $alumni->pekerjaan }}</span>
                                    @else
                                        <span class="info-value-empty">Belum diperbarui</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        <a href="{{ route('landing.profil', $alumni->id) }}" class="btn-profile">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center pb-4">
        {{ $alumnis->links() }}
    </div>

@else

    <div class="empty-state">
        <div class="empty-icon-wrap">
            <i class="bi bi-person-slash"></i>
        </div>
        <h4>Data Tidak Ditemukan</h4>
        <p>Kami tidak menemukan alumni dengan kriteria pencarian tersebut.</p>
        <a href="{{ route('landing.direktori') }}" class="btn-reset">
            <i class="bi bi-arrow-counterclockwise"></i> Reset Pencarian
        </a>
    </div>

@endif

@endsection
