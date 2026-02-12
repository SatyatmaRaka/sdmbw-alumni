@extends('layouts.landing')

@section('title', 'Beranda')

@push('styles')
<style>
    :root {
        --color-primary: #213448;
        --color-primary-light: #2d4a65;
        --color-accent: #EAE0CF;
        --color-accent-hover: #d8cdb8;
    }

    /* Hero Section */
    .hero {
        padding: 140px 0 180px 0;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
        position: relative;
        overflow: hidden;
    }

    /* Pattern Overlay untuk tekstur premium */
    .hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.4;
    }

    .hero h1 {
        font-size: 3.8rem;
        font-weight: 800;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 700px;
        margin: 0 auto 3rem auto;
        line-height: 1.8;
        font-weight: 300;
    }

    /* Stats Section */
    .section-stats {
        background-color: #fcfcfc;
        padding-bottom: 100px;
        position: relative;
    }

    .stats-container {
        margin-top: -100px;
        position: relative;
        z-index: 10;
    }

    .card-stat {
        border: none;
        border-radius: 30px;
        background: #ffffff;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        padding: 3.5rem 2rem;
    }

    .card-stat:hover {
        transform: translateY(-15px);
        box-shadow: 0 40px 80px -15px rgba(33, 52, 72, 0.15);
    }

    .stat-icon-circle {
        width: 90px;
        height: 90px;
        background: #f8fafc;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.8rem auto;
        color: var(--color-primary);
        transform: rotate(-5deg);
        transition: transform 0.3s ease;
    }

    .card-stat:hover .stat-icon-circle {
        transform: rotate(0deg) scale(1.1);
        background: var(--color-primary);
        color: #ffffff;
    }

    .stat-number {
        font-size: 3.8rem;
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        color: #8a949d;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.8rem;
    }

    /* CTA Section */
    .cta-section {
        padding: 6rem 0;
        background-color: #ffffff;
    }

    .cta-card {
        background: var(--color-primary);
        background-image: linear-gradient(45deg, rgba(0,0,0,0.1) 25%, transparent 25%, transparent 50%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.1) 75%, transparent 75%, transparent);
        background-size: 100px 100px;
        border: none;
        border-radius: 50px;
        padding: 5rem 3rem;
        box-shadow: 0 30px 60px rgba(33, 52, 72, 0.25);
    }

    .cta-title {
        font-size: 2.8rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1.5rem;
    }

    .cta-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        max-width: 650px;
        margin: 0 auto 3rem auto;
    }

    /* Buttons & Badges */
    .btn-custom {
        background-color: var(--color-accent);
        color: var(--color-primary);
        font-weight: 700;
        padding: 18px 50px;
        border-radius: 100px;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .btn-custom:hover {
        background-color: var(--color-accent-hover);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        color: var(--color-primary);
    }

    .welcome-badge {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        padding: 1.2rem 2.5rem;
        border-radius: 100px;
        display: inline-block;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .hero h1 { font-size: 3rem; }
        .stat-number { font-size: 3rem; }
    }

    @media (max-width: 767px) {
        .hero { padding: 100px 0 140px 0; }
        .hero h1 { font-size: 2.4rem; }
        .stats-container { margin-top: -70px; }
        .cta-card { padding: 3.5rem 1.5rem; border-radius: 30px; }
        .cta-title { font-size: 2rem; }
    }
</style>
@endpush

@section('content')
<section class="hero text-center">
    <div class="container position-relative">
        <h1 class="animate__animated animate__fadeInDown">Selamat Datang di Sistem Alumni</h1>
        <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
            Wadah resmi komunikasi dan informasi alumni SD Muhammadiyah Birrul Walidain Kudus. Jalin kembali komunikasi dengan teman lama.
        </p>

        @auth
            <div class="animate__animated animate__zoomIn animate__delay-2s">
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('alumni.dashboard') }}"
                   class="btn-custom shadow">
                    <i class="bi bi-grid-fill me-2"></i> Ke Dashboard Saya
                </a>
            </div>
        @endauth
    </div>
</section>

<section class="section-stats">
    <div class="container stats-container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-stat text-center">
                    <div class="stat-icon-circle shadow-sm">
                        <i class="bi bi-people-fill" style="font-size: 2.8rem;"></i>
                    </div>
                    <h2 class="stat-number">{{ $stats['total_alumni'] ?? '0' }}</h2>
                    <p class="stat-label mb-0">Alumni Terverifikasi</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-stat text-center">
                    <div class="stat-icon-circle shadow-sm">
                        <i class="bi bi-mortarboard-fill" style="font-size: 2.8rem;"></i>
                    </div>
                    <h2 class="stat-number">{{ $stats['total_angkatan'] ?? '0' }}</h2>
                    <p class="stat-label mb-0">Total Angkatan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card text-center">
            <h2 class="cta-title">Mari Jalin Silaturahmi!</h2>
            <p class="cta-description">
                Daftarkan diri Anda untuk bergabung ke dalam jaringan alumni dan dapatkan informasi terbaru seputar perkembangan sekolah.
            </p>

            @guest
                <a href="{{ route('register') }}" class="btn-custom shadow-lg">
                    Daftar Sebagai Alumni Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            @else
                <div class="welcome-badge">
                    <span>
                        <i class="bi bi-person-circle me-2 text-info"></i>
                        Halo, <strong>{{ Auth::user()->username }}</strong>. Senang melihat Anda kembali!
                    </span>
                </div>
            @endguest
        </div>
    </div>
</section>
@endsection
