@extends('layouts.landing')

@section('title', 'Beranda')

@push('styles')
<link rel="preload" as="image"
      href="{{ asset('images/bw-sekolah.webp') }}"
      imagesrcset="{{ asset('images/bw-sekolah-sm.webp') }} 640w, {{ asset('images/bw-sekolah.webp') }} 1200w"
      imagesizes="100vw"
      fetchpriority="high">

<style>
    :root {
        --color-primary:       #1B3A52;
        --color-primary-light: #2a5378;
        --color-primary-dark:  #112534;
        --color-accent:        #EAE0CF;
        --color-accent-hover:  #d9b75e;
        --color-bg:            #F7F5F0;
    }

    /* ============================================================
       HERO
    ============================================================ */
    .hero {
        min-height: 100svh;
        padding: 130px 0 180px;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        background-color: var(--color-primary-dark);
        display: flex;
        align-items: center;
    }

    .hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 45%;
        z-index: 0;
        display: block;
        filter: saturate(0.6) brightness(0.75);
    }

    /* layered gradient overlay */
    .hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
        background:
            linear-gradient(to right,
                rgba(17,37,52,0.92) 0%,
                rgba(17,37,52,0.55) 55%,
                rgba(17,37,52,0.30) 100%),
            linear-gradient(to top,
                rgba(17,37,52,0.85) 0%,
                transparent 50%);
    }

    /* subtle dot grid */
    .hero-overlay::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 32px 32px;
    }

    /* bottom fade */
    .hero-overlay::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 160px;
        background: linear-gradient(to bottom, transparent, rgba(247,245,240,0.18));
    }

    /* decorative vertical accent line */
    .hero-line {
        position: absolute;
        left: 0; top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 80px;
        background: var(--color-accent);
        border-radius: 2px;
        z-index: 3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(232,200,122,0.12);
        border: 1px solid rgba(232,200,122,0.35);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: var(--color-accent);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 1.75rem;
    }

    .hero h1 {
        font-size: clamp(2.2rem, 5.5vw, 4.2rem);
        font-weight: 800;
        color: #ffffff;
        font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        margin-bottom: 1.25rem;
        letter-spacing: -1px;
        line-height: 1.1;
        text-shadow: 0 4px 32px rgba(0,0,0,0.4);
    }

    /* gold underline on last word of h1 */
    .hero h1 .highlight {
        position: relative;
        display: inline-block;
        color: var(--color-accent);
    }

    .hero-subtitle {
        font-size: clamp(0.95rem, 2vw, 1.15rem);
        color: rgba(255,255,255,0.78);
        max-width: 560px;
        margin: 0 auto 2.75rem;
        line-height: 1.85;
        font-weight: 400;
        text-shadow: 0 1px 10px rgba(0,0,0,0.25);
    }

    /* ============================================================
       STATS
    ============================================================ */
    .section-stats {
        background-color: var(--color-bg);
        padding-bottom: 96px;
        position: relative;
    }

    .stats-container {
        margin-top: -88px;
        position: relative;
        z-index: 10;
    }

    .card-stat-wrapper { padding: 12px; }

    .card-stat {
        border: none;
        border-radius: 24px;
        background: #ffffff;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.9) inset,
            0 20px 48px -10px rgba(27,58,82,0.12);
        transform: translateY(0) translateZ(0);
        transition:
            transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275),
            box-shadow 0.4s ease;
        padding: 3rem 1.75rem 2.75rem;
        contain: layout style;
        will-change: transform, box-shadow;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    /* top accent stripe */
    .card-stat::before {
        content: '';
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 48px; height: 3px;
        background: var(--color-accent);
        border-radius: 0 0 4px 4px;
        transition: width 0.3s ease;
    }

    .card-stat:hover::before { width: 80px; }

    .card-stat:hover {
        transform: translateY(-12px) translateZ(0);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.9) inset,
            0 40px 80px -16px rgba(27,58,82,0.18);
    }

    .stat-icon-circle {
        width: 76px; height: 76px;
        background: #EEF2F7;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.75rem;
        color: var(--color-primary);
        transform: rotate(-6deg) translateZ(0);
        transition: transform 0.35s ease, background 0.35s ease, color 0.35s ease;
        will-change: transform;
    }

    .card-stat:hover .stat-icon-circle {
        transform: rotate(0deg) scale(1.1) translateZ(0);
        background: var(--color-primary);
        color: #ffffff;
    }

    .stat-number {
        font-size: clamp(2.6rem, 4.5vw, 4rem);
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        letter-spacing: -1px;
    }

    .stat-label {
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.7rem;
    }

    /* ============================================================
       CTA
    ============================================================ */
    .cta-section {
        padding: 0 0 7rem;
        background-color: var(--color-bg);
        position: relative;
    }

    .cta-card {
        background: var(--color-primary-dark);
        border: none;
        border-radius: 32px;
        padding: 5rem 2.5rem;
        box-shadow: 0 32px 64px rgba(17,37,52,0.28);
        position: relative;
        overflow: hidden;
    }

    /* geometric shapes for depth */
    .cta-card::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: rgba(232,200,122,0.07);
        pointer-events: none;
    }

    .cta-card::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(42,83,120,0.35);
        pointer-events: none;
    }

    .cta-inner { position: relative; z-index: 1; }

    .cta-eyebrow {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--color-accent);
        margin-bottom: 1rem;
        display: block;
    }

    .cta-title {
        font-size: clamp(1.7rem, 4vw, 2.8rem);
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1.2rem;
        line-height: 1.15;
        letter-spacing: -0.5px;
    }

    .cta-description {
        color: rgba(255,255,255,0.65);
        font-size: clamp(0.95rem, 1.8vw, 1.1rem);
        max-width: 560px;
        margin: 0 auto 2.75rem;
        line-height: 1.8;
    }

    /* ============================================================
       BUTTONS
    ============================================================ */
    .btn-custom {
        background-color: var(--color-accent);
        color: var(--color-primary-dark);
        font-weight: 800;
        padding: 16px 48px;
        border-radius: 100px;
        border: none;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.82rem;
        letter-spacing: 1.2px;
        transform: translateY(0) translateZ(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        will-change: transform;
        white-space: nowrap;
        box-shadow: 0 8px 24px rgba(232,200,122,0.35);
    }

    .btn-custom:hover {
        background-color: var(--color-accent-hover);
        transform: translateY(-5px) translateZ(0);
        box-shadow: 0 20px 40px rgba(232,200,122,0.4);
        color: var(--color-primary-dark);
    }

    .btn-custom-ghost {
        background: transparent;
        color: rgba(255,255,255,0.75);
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 100px;
        border: 1px solid rgba(255,255,255,0.2);
        text-decoration: none;
        display: inline-block;
        font-size: 0.88rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-custom-ghost:hover {
        background: rgba(255,255,255,0.07);
        border-color: rgba(255,255,255,0.4);
        color: white;
    }

    .welcome-badge {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding: 1rem 2rem;
        border-radius: 100px;
        display: inline-block;
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.85);
        font-size: clamp(0.9rem, 1.5vw, 1rem);
        font-weight: 500;
    }

    /* ============================================================
       DIVIDER WAVE (stats → cta)
    ============================================================ */
    .wave-divider {
        display: block;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        background: var(--color-bg);
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 1199px) {
        .hero { min-height: 92svh; }
    }

    @media (max-width: 991px) {
        .hero { min-height: 86svh; padding: 110px 0 160px; }
        .stats-container { margin-top: -72px; }
        .section-stats   { padding-bottom: 72px; }
    }

    @media (max-width: 767px) {
        .hero            { min-height: 82svh; padding: 100px 0 140px; }
        .stats-container { margin-top: -60px; }
        .card-stat       { padding: 2.4rem 1.4rem 2rem; will-change: auto; }
        .stat-icon-circle{ width: 64px; height: 64px; border-radius: 14px; }
        .cta-card        { padding: 3.5rem 1.75rem; border-radius: 24px; }
        .btn-custom      { will-change: auto; }
    }

    @media (max-width: 480px) {
        .hero            { min-height: 78svh; padding: 90px 0 128px; }
        .hero-badge      { display: none; }
        .stats-container { margin-top: -52px; }
        .cta-card        { padding: 2.75rem 1.25rem; border-radius: 20px; }
        .section-stats   { padding-bottom: 56px; }
        .cta-section     { padding-bottom: 5rem; }
        .btn-custom      { display: block; width: 100%; text-align: center; padding: 16px 24px; }
        .welcome-badge   { padding: 0.9rem 1.5rem; border-radius: 16px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .card-stat, .stat-icon-circle, .btn-custom, .btn-custom-ghost {
            transition: none !important;
            will-change: auto !important;
        }
    }
</style>
@endpush

@section('content')

{{-- ── HERO ───────────────────────────────────────────────────── --}}
<section class="hero text-center">

    <picture>
        <source type="image/webp"
            srcset="{{ asset('images/bw-sekolah-sm.webp') }} 640w,
                    {{ asset('images/bw-sekolah.webp') }} 1200w"
            sizes="100vw">
        <img class="hero-img"
            src="{{ asset('images/bw-sekolah-sm.webp') }}"
            alt="SD Muhammadiyah Birrul Walidain Kudus"
            fetchpriority="high" loading="eager" decoding="async"
            aria-hidden="true" width="1200" height="1692">
    </picture>

    <div class="hero-overlay" aria-hidden="true"></div>

    <div class="container hero-content">
        <div class="hero-badge">
            <i class="bi bi-mortarboard-fill"></i>
            SD Muhammadiyah Birrul Walidain Kudus
        </div>

        <h1 class="animate__animated animate__fadeInDown">
            Selamat Datang di<br class="d-none d-md-block">
            <span class="highlight">Sistem Alumni</span>
        </h1>

        <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
            Wadah resmi komunikasi dan informasi alumni SD Muhammadiyah Birrul Walidain Kudus.
            Jalin kembali komunikasi dengan teman lama.
        </p>

        @auth
            <div class="animate__animated animate__zoomIn animate__delay-2s">
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('alumni.dashboard') }}"
                    class="btn-custom shadow">
                    <i class="bi bi-grid-fill me-2"></i> Ke Dashboard Saya
                </a>
            </div>
        @else
            <div class="animate__animated animate__fadeInUp animate__delay-2s d-flex align-items-center justify-content-center flex-wrap gap-3">
                <a href="{{ route('register') }}" class="btn-custom shadow">
                    <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn-custom-ghost">
                    Masuk <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        @endauth
    </div>
</section>

{{-- ── STATS ──────────────────────────────────────────────────── --}}
<section class="section-stats">
    <div class="container stats-container">
        <div class="row g-0 justify-content-center">

            <div class="col-6 col-md-5 col-lg-4">
                <div class="card-stat-wrapper">
                    <div class="card-stat text-center">
                        <div class="stat-icon-circle shadow-sm">
                            <i class="bi bi-people-fill" style="font-size:2.2rem;" aria-hidden="true"></i>
                        </div>
                        <h2 class="stat-number">{{ $stats['total_alumni'] ?? '0' }}</h2>
                        <p class="stat-label mb-0">Alumni Terverifikasi</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-5 col-lg-4">
                <div class="card-stat-wrapper">
                    <div class="card-stat text-center">
                        <div class="stat-icon-circle shadow-sm">
                            <i class="bi bi-mortarboard-fill" style="font-size:2.2rem;" aria-hidden="true"></i>
                        </div>
                        <h2 class="stat-number">{{ $stats['total_angkatan'] ?? '0' }}</h2>
                        <p class="stat-label mb-0">Total Angkatan</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── CTA ────────────────────────────────────────────────────── --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-card text-center">
            <div class="cta-inner">
                <span class="cta-eyebrow">Bergabunglah Bersama Kami</span>
                <h2 class="cta-title">Mari Jalin Silaturahmi!</h2>
                <p class="cta-description">
                    Daftarkan diri Anda untuk bergabung ke dalam jaringan alumni dan dapatkan informasi
                    terbaru seputar perkembangan sekolah.
                </p>

                @guest
                    <a href="{{ route('register') }}" class="btn-custom shadow-lg">
                        Daftar Sebagai Alumni <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @else
                    <div class="welcome-badge">
                        <i class="bi bi-person-circle me-2 text-info" aria-hidden="true"></i>
                        Halo, <strong>{{ Auth::user()->username }}</strong>. Senang melihat Anda kembali!
                    </div>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection
