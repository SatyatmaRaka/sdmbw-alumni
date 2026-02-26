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
        --color-primary: #213448;
        --color-primary-light: #2d4a65;
        --color-accent: #EAE0CF;
        --color-accent-hover: #d8cdb8;
    }

    /* ============================================================
       HERO
    ============================================================ */
    .hero {
        min-height: 100svh;
        padding: 120px 0 160px;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        background-color: #213448;
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
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg,
            rgba(21,34,48,0.88) 0%,
            rgba(33,52,72,0.80) 50%,
            rgba(45,74,101,0.72) 100%);
        z-index: 1;
        pointer-events: none;
    }

    .hero-overlay::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 28px 28px;
    }

    .hero-overlay::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 130px;
        background: linear-gradient(to bottom, transparent, rgba(252,252,252,0.14));
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
        background: rgba(234,224,207,0.15);
        border: 1px solid rgba(234,224,207,0.3);
        backdrop-filter: blur(10px);
        color: var(--color-accent);
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 0.45rem 1.1rem;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }

    .hero h1 {
        font-size: clamp(2rem, 5vw, 3.8rem);
        font-weight: 800;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1.25rem;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 20px rgba(0,0,0,0.35);
        line-height: 1.15;
    }

    .hero-subtitle {
        font-size: clamp(0.95rem, 2vw, 1.2rem);
        color: rgba(255,255,255,0.88);
        max-width: 600px;
        margin: 0 auto 2.5rem;
        line-height: 1.8;
        font-weight: 300;
        text-shadow: 0 1px 8px rgba(0,0,0,0.2);
    }

    /* ============================================================
       STATS
    ============================================================ */
    .section-stats {
        background-color: #fcfcfc;
        padding-bottom: 80px;
        position: relative;
    }

    .stats-container {
        margin-top: -80px;
        position: relative;
        z-index: 10;
    }

    .card-stat-wrapper {
        padding: 12px;
    }

    .card-stat {
        border: none;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 40px -12px rgba(0,0,0,0.09);
        transform: translateY(0) translateZ(0);
        transition:
            transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275),
            box-shadow 0.4s ease;
        padding: 2.8rem 1.5rem;
        contain: layout style;
        will-change: transform, box-shadow;
        height: 100%;
    }

    .card-stat:hover {
        transform: translateY(-10px) translateZ(0);
        box-shadow: 0 36px 70px -15px rgba(33,52,72,0.14);
    }

    .stat-icon-circle {
        width: 80px;
        height: 80px;
        background: #f0f4f8;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--color-primary);
        transform: rotate(-5deg) translateZ(0);
        transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
        will-change: transform;
    }

    .card-stat:hover .stat-icon-circle {
        transform: rotate(0deg) scale(1.08) translateZ(0);
        background: var(--color-primary);
        color: #ffffff;
    }

    .stat-number {
        font-size: clamp(2.4rem, 4vw, 3.6rem);
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.4rem;
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }

    .stat-label {
        color: #8a949d;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
    }

    /* ============================================================
       CTA
    ============================================================ */
    .cta-section {
        padding: 5rem 0 6rem;
        background-color: #ffffff;
    }

    .cta-card {
        background: var(--color-primary);
        background-image: linear-gradient(45deg,
            rgba(0,0,0,0.08) 25%, transparent 25%,
            transparent 50%, rgba(0,0,0,0.08) 50%,
            rgba(0,0,0,0.08) 75%, transparent 75%, transparent);
        background-size: 80px 80px;
        border: none;
        border-radius: 32px;
        padding: 4rem 2rem;
        box-shadow: 0 24px 50px rgba(33,52,72,0.22);
        contain: layout style;
    }

    .cta-title {
        font-size: clamp(1.6rem, 3.5vw, 2.6rem);
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1.2rem;
        line-height: 1.2;
    }

    .cta-description {
        color: rgba(255,255,255,0.78);
        font-size: clamp(0.95rem, 1.8vw, 1.15rem);
        max-width: 600px;
        margin: 0 auto 2.5rem;
        line-height: 1.75;
    }

    /* ============================================================
       BUTTONS
    ============================================================ */
    .btn-custom {
        background-color: var(--color-accent);
        color: var(--color-primary);
        font-weight: 700;
        padding: 16px 44px;
        border-radius: 100px;
        border: none;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.88rem;
        letter-spacing: 1px;
        transform: translateY(0) translateZ(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        will-change: transform;
        white-space: nowrap;
    }

    .btn-custom:hover {
        background-color: var(--color-accent-hover);
        transform: translateY(-4px) translateZ(0);
        box-shadow: 0 14px 28px rgba(0,0,0,0.18);
        color: var(--color-primary);
    }

    .welcome-badge {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        padding: 1rem 2rem;
        border-radius: 100px;
        display: inline-block;
        border: 1px solid rgba(255,255,255,0.2);
        color: #ffffff;
        font-size: clamp(0.9rem, 1.5vw, 1.1rem);
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 1199px) {
        .hero { min-height: 90svh; }
    }

    @media (max-width: 991px) {
        .hero            { min-height: 85svh; padding: 110px 0 150px; }
        .stats-container { margin-top: -70px; }
        .section-stats   { padding-bottom: 70px; }
    }

    @media (max-width: 767px) {
        .hero            { min-height: 80svh; padding: 90px 0 130px; }
        .stats-container { margin-top: -60px; }
        .card-stat       { padding: 2.2rem 1.2rem; will-change: auto; }
        .stat-icon-circle{ width: 68px; height: 68px; border-radius: 16px; }
        .cta-card        { padding: 3rem 1.5rem; border-radius: 24px; }
        .btn-custom      { will-change: auto; }
        .hero-badge      { font-size: 0.75rem; }
    }

    @media (max-width: 480px) {
        .hero            { min-height: 75svh; padding: 80px 0 120px; }
        .hero-badge      { display: none; }
        .stats-container { margin-top: -50px; }
        .cta-card        { padding: 2.5rem 1.2rem; border-radius: 20px; }
        .section-stats   { padding-bottom: 60px; }
        .cta-section     { padding: 4rem 0 5rem; }
        .btn-custom      { display: block; width: 100%; text-align: center; }
        .welcome-badge   { padding: 0.9rem 1.4rem; border-radius: 16px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .card-stat, .stat-icon-circle, .btn-custom {
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
            Selamat Datang di<br class="d-none d-md-block"> Sistem Alumni
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
            <div class="animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('register') }}" class="btn-custom shadow">
                    <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
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
                            <i class="bi bi-people-fill" style="font-size:2.4rem;" aria-hidden="true"></i>
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
                            <i class="bi bi-mortarboard-fill" style="font-size:2.4rem;" aria-hidden="true"></i>
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
</section>

@endsection
