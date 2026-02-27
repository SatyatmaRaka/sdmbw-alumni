@extends('layouts.alumni')

@section('title', 'Profil ' . $alumni->nama_lengkap)

@section('content')

<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --bg:            #F7F5F0;
        --success:       #16a34a;
        --radius:        16px;
        --transition:    all 0.26s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 8px 28px rgba(27,58,82,0.09);
    }

    /* ─────────────────────────────────────────
        BACK BAR
    ───────────────────────────────────────── */
    .back-bar {
        background: var(--primary-dark);
        padding: 0.9rem 0;
        border-bottom: 2px solid rgba(232,200,122,0.2);
        position: relative;
        overflow: hidden;
    }

    .back-bar::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 24px 24px;
        pointer-events: none;
    }

    .back-link {
        position: relative; z-index: 1;
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .back-link:hover { color: var(--accent); gap: 11px; }

    /* ─────────────────────────────────────────
       PROFILE HEADER
    ───────────────────────────────────────── */
    .profile-hero {
        background: var(--primary-dark);
        padding: 3rem 0 4rem;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    .profile-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    .profile-hero::after {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.55) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-hero .container { position: relative; z-index: 1; }

    .hero-avatar {
        width: 80px; height: 80px;
        border-radius: 20px;
        background: var(--primary-light);
        border: 3px solid rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .hero-avatar i { font-size: 2.5rem; color: rgba(255,255,255,0.2); }

    .hero-name {
        font-family: 'DM Serif Display', serif;
        font-weight: 400;
        font-size: clamp(1.6rem, 4vw, 2.6rem);
        color: white;
        letter-spacing: -0.3px;
        line-height: 1.15;
        margin-bottom: 0.75rem;
    }

    .profile-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.35rem 0.9rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }

    .pill-angkatan {
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: var(--accent);
    }

    .pill-verified {
        background: rgba(22,163,74,0.12);
        border: 1px solid rgba(22,163,74,0.25);
        color: #4ade80;
    }

    /* bottom pull-down card overlap */
    .hero-spacer { height: 2.5rem; }

    /* ─────────────────────────────────────────
       CONTENT AREA
    ───────────────────────────────────────── */
    .content-area {
        background: var(--bg);
        padding: 0 0 5rem;
    }

    .overlap-container {
        margin-top: -2.5rem;
        position: relative;
        z-index: 10;
    }

    /* ─────────────────────────────────────────
       CARDS
    ───────────────────────────────────────── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .card-section:hover { box-shadow: 0 2px 0 rgba(255,255,255,0.8) inset, 0 16px 48px rgba(27,58,82,0.12); }

    .card-header-section {
        background: var(--primary);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    .card-header-section::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .card-header-section i { opacity: 0.8; }

    .card-body-section { padding: 1.75rem; }

    /* ─────────────────────────────────────────
       DATA GRID
    ───────────────────────────────────────── */
    .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .data-item {
        border-left: 3px solid rgba(232,200,122,0.45);
        padding-left: 1rem;
    }

    .data-label {
        display: block;
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 1.3px;
        margin-bottom: 0.35rem;
    }

    .data-value {
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
    }

    /* status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-complete {
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.2);
        color: var(--success);
    }

    .status-incomplete {
        background: rgba(245,158,11,0.1);
        border: 1px solid rgba(245,158,11,0.2);
        color: #d97706;
    }

    /* ─────────────────────────────────────────
       KARIR & PENDIDIKAN items
    ───────────────────────────────────────── */
    .karir-item {
        padding: 1.1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .karir-item:first-child { padding-top: 0; }
    .karir-item:last-child { border-bottom: none; padding-bottom: 0; }

    .karir-item-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.3px;
        color: #94a3b8;
        margin-bottom: 0.3rem;
    }

    .karir-item-value {
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .karir-item-note {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* ─────────────────────────────────────────
       HARAPAN / QUOTE (sidebar)
    ───────────────────────────────────────── */
    .harapan-card {
        background: var(--primary-dark);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid rgba(232,200,122,0.15);
        box-shadow: var(--shadow-card);
        margin-bottom: 1.5rem;
        position: relative;
    }

    /* dot grid */
    .harapan-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 20px 20px;
        pointer-events: none;
    }

    .harapan-card-header {
        padding: 1rem 1.5rem 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--accent);
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .harapan-body {
        padding: 0.75rem 1.5rem 1.5rem 1.5rem;
        position: relative;
        z-index: 1;
    }

    .quote-mark {
        font-family: 'DM Serif Display', serif;
        font-size: 4.5rem;
        line-height: 0.8;
        color: var(--accent);
        opacity: 0.35;
        display: block;
        margin-bottom: -0.5rem;
    }

    .harapan-text {
        color: rgba(255,255,255,0.75);
        font-style: italic;
        font-size: 0.95rem;
        line-height: 1.85;
        margin: 0;
    }

    .harapan-empty {
        color: rgba(255,255,255,0.35);
        font-size: 0.88rem;
        font-style: italic;
        margin: 0;
    }

    /* ─────────────────────────────────────────
       KONTAK CARD (sidebar)
    ───────────────────────────────────────── */
    .kontak-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(226,232,240,0.8);
        margin-bottom: 1.5rem;
    }

    .kontak-body { padding: 1.5rem; }

    .kontak-title {
        font-weight: 800;
        color: var(--primary);
        font-size: 0.95rem;
        margin-bottom: 0.35rem;
    }

    .kontak-desc {
        color: #94a3b8;
        font-size: 0.82rem;
        margin-bottom: 1.25rem;
        line-height: 1.5;
    }

    .btn-contact {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 0.8rem 1.25rem;
        background: var(--primary);
        color: white;
        font-weight: 700;
        font-size: 0.88rem;
        border-radius: 10px;
        border: none;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-contact:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
        color: white;
    }

    .kontak-locked {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.9rem 1rem;
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 10px;
        color: #94a3b8;
        font-size: 0.82rem;
        font-weight: 500;
    }

    /* ─────────────────────────────────────────
       RESPONSIVE
    ───────────────────────────────────────── */
    @media (max-width: 768px) {
        .hero-avatar { width: 64px; height: 64px; border-radius: 14px; }
        .hero-avatar i { font-size: 2rem; }
        .data-grid { grid-template-columns: 1fr 1fr; }
        .profile-hero { padding: 2.5rem 0 3.5rem; }
    }

    @media (max-width: 480px) {
        .data-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- ── BACK BAR ─────────────────────────────────────────────────── --}}
<div class="back-bar">
    <div class="container">
        <a class="back-link" href="{{ route('landing.direktori') }}">
            <i class="bi bi-arrow-left"></i> Direktori Alumni
        </a>
    </div>
</div>

{{-- ── PROFILE HERO ─────────────────────────────────────────────── --}}
<div class="profile-hero">
    <div class="container">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="hero-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <h1 class="hero-name">{{ $alumni->nama_lengkap }}</h1>
                <div class="d-flex flex-wrap gap-2">
                    <span class="profile-pill pill-angkatan">
                        <i class="bi bi-mortarboard-fill"></i>
                        {{ $alumni->angkatan->nama_angkatan ?? 'Tanpa Angkatan' }}
                    </span>
                    @if($alumni->status_verifikasi === 'verified')
                        <span class="profile-pill pill-verified">
                            <i class="bi bi-patch-check-fill"></i> Terverifikasi
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── CONTENT ──────────────────────────────────────────────────── --}}
<div class="content-area">
    <div class="container">
        <div class="overlap-container">
            <div class="row g-4">

                {{-- ── MAIN COLUMN ─────────────────────────────── --}}
                <div class="col-lg-8">

                    {{-- Identitas Alumni --}}
                    <div class="card-section">
                        <div class="card-header-section">
                            <i class="bi bi-person-vcard"></i> Identitas Alumni
                        </div>
                        <div class="card-body-section">
                            <div class="data-grid">
                                <div class="data-item">
                                    <span class="data-label">NISN</span>
                                    <p class="data-value">{{ $alumni->nisn ?? '-' }}</p>
                                </div>
                                <div class="data-item">
                                    <span class="data-label">Tahun Ajaran</span>
                                    <p class="data-value">{{ $alumni->angkatan->tahun_ajaran ?? '-' }}</p>
                                </div>
                                <div class="data-item">
                                    <span class="data-label">Tahun Lulus</span>
                                    <p class="data-value">{{ $alumni->tahun_lulus }}</p>
                                </div>
                                <div class="data-item">
                                    <span class="data-label">Status Profil</span>
                                    @if($alumni->is_profile_complete)
                                        <span class="status-badge status-complete">
                                            <i class="bi bi-check-circle-fill"></i> Lengkap
                                        </span>
                                    @else
                                        <span class="status-badge status-incomplete">
                                            <i class="bi bi-exclamation-circle-fill"></i> Belum Lengkap
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Karir & Pendidikan --}}
                    <div class="card-section">
                        <div class="card-header-section">
                            <i class="bi bi-briefcase"></i> Karir &amp; Pendidikan
                        </div>
                        <div class="card-body-section">

                            <div class="karir-item">
                                <div class="karir-item-label">Pendidikan Lanjutan</div>
                                <p class="karir-item-value mb-1">
                                    {{ $alumni->pendidikan_lanjutan ?? 'Tidak mencantumkan pendidikan lanjutan' }}
                                </p>
                                <p class="karir-item-note mb-0">Instansi atau Universitas setelah lulus dari SDMBW.</p>
                            </div>

                            <div class="karir-item">
                                <div class="karir-item-label">Kesibukan Saat Ini</div>
                                <p class="karir-item-value mb-1">
                                    {{ $alumni->pekerjaan ?? 'Belum bekerja / Mencari Pekerjaan' }}
                                </p>
                                <p class="karir-item-note mb-0">Bidang pekerjaan atau profesi yang sedang ditekuni.</p>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- ── SIDEBAR ──────────────────────────────────── --}}
                <div class="col-lg-4">

                    {{-- Harapan & Pesan --}}
                    <div class="harapan-card">
                        <div class="harapan-card-header">
                            <i class="bi bi-chat-left-quote-fill"></i> Harapan &amp; Pesan
                        </div>
                        <div class="harapan-body">
                            @php $isiHarapan = trim($alumni->harapan); @endphp
                            @if(!empty($isiHarapan))
                                <span class="quote-mark">"</span>
                                <p class="harapan-text">{{ $isiHarapan }}</p>
                            @else
                                <p class="harapan-empty mt-2">Alumni ini belum menuliskan pesan atau harapan untuk sekolah.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Hubungi Alumni --}}
                    <div class="kontak-card">
                        <div class="kontak-body">
                            <p class="kontak-title">Hubungi Alumni</p>
                            <p class="kontak-desc">Ingin menjalin silaturahmi atau kerjasama profesional?</p>

                            @if($alumni->email)
                                <a href="mailto:{{ $alumni->email }}" class="btn-contact">
                                    <i class="bi bi-envelope-paper-fill"></i> Kirim Email
                                </a>
                            @else
                                <div class="kontak-locked">
                                    <i class="bi bi-lock-fill"></i>
                                    Informasi kontak tidak tersedia secara publik.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
