@extends('layouts.landing')

@section('title', 'Profil ' . $alumni->nama_lengkap)

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --success:       #16a34a;
        --info:          #0891b2;
        --bg:            #F7F5F0;
        --radius:        16px;
        --transition:    all 0.26s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 8px 28px rgba(27,58,82,0.09);
    }

    /* ─────────────────────────────────────────
       BACK BAR
    ───────────────────────────────────────── */
    .back-bar {
        background: var(--primary-dark);
        padding: 1rem 0;
        border-bottom: 2px solid rgba(232,200,122,0.25);
        position: relative;
        overflow: hidden;
    }

    /* dot grid */
    .back-bar::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 24px 24px;
        pointer-events: none;
    }

    .back-link {
        position: relative;
        z-index: 1;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        letter-spacing: 0.2px;
    }

    .back-link:hover {
        color: var(--accent);
        gap: 10px;
    }

    .back-link i { font-size: 1rem; }

    /* ─────────────────────────────────────────
       PROFILE HEADER CARD
    ───────────────────────────────────────── */
    .profile-header {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        margin-bottom: 1.75rem;
        border: 1px solid rgba(226,232,240,0.8);
    }

    .profile-header-bg {
        height: 170px;
        background: var(--primary-dark);
        position: relative;
        overflow: hidden;
    }

    /* dot grid on bg */
    .profile-header-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 24px 24px;
    }

    /* decorative glow */
    .profile-header-bg::after {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.6) 0%, transparent 70%);
    }

    /* accent stripe bottom */
    .profile-header-bg-stripe {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(to right, var(--accent), transparent);
    }

    .profile-header-content {
        padding: 0 2rem 2.25rem;
        text-align: center;
    }

    .profile-avatar {
        width: 150px; height: 150px;
        margin: -75px auto 1.4rem;
        border-radius: 20px;
        border: 5px solid white;
        box-shadow: 0 12px 32px rgba(27,58,82,0.22);
        overflow: hidden;
        background: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 10;
    }

    .profile-avatar img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .profile-avatar:hover img { transform: scale(1.05); }

    .profile-avatar-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(145deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .profile-avatar-placeholder i {
        font-size: 4.5rem;
        color: rgba(255,255,255,0.2);
    }

    .profile-name {
        font-family: 'DM Serif Display', serif;
        font-weight: 400;
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        color: var(--primary);
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .profile-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.38rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .profile-pill-angkatan {
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
    }

    .profile-pill-verified {
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.25);
        color: var(--success);
    }

    /* ─────────────────────────────────────────
       INFO SECTION CARD
    ───────────────────────────────────────── */
    .info-section {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        margin-bottom: 1.75rem;
        border: 1px solid rgba(226,232,240,0.8);
    }

    .info-section-header {
        background: var(--primary);
        color: white;
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    /* accent line left */
    .info-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .info-section-header i { font-size: 1.05rem; opacity: 0.85; }

    .info-section-body { padding: 1.75rem; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.75rem;
    }

    .info-item {
        border-left: 3px solid rgba(232,200,122,0.5);
        padding-left: 1.1rem;
    }

    .info-label {
        display: block;
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.4rem;
    }

    .info-value {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.05rem;
        margin: 0;
    }

    .info-value.small { font-size: 0.92rem; }

    .info-value a {
        color: var(--primary);
        text-decoration: none;
        border-bottom: 1.5px solid var(--accent);
        transition: var(--transition);
        word-break: break-all;
    }

    .info-value a:hover {
        color: var(--primary-light);
        border-color: var(--primary);
    }

    /* ─────────────────────────────────────────
       CONTACT SECTION (sidebar)
    ───────────────────────────────────────── */
    .contact-section {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        margin-bottom: 1.75rem;
        border: 1px solid rgba(226,232,240,0.8);
    }

    .contact-section-header {
        background: var(--primary);
        color: white;
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    .contact-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .contact-item {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .contact-item:last-child { border-bottom: none; }
    .contact-item:hover { background: #fafbfc; }

    .contact-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .contact-details { flex-grow: 1; min-width: 0; }

    .contact-details h6 {
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 0.2rem;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .contact-details p,
    .contact-details a {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.88rem;
        word-break: break-all;
        text-decoration: none;
        transition: var(--transition);
    }

    .contact-details a:hover { color: var(--primary-light); }

    /* ─────────────────────────────────────────
       TIMELINE
    ───────────────────────────────────────── */
    .timeline {
        position: relative;
        padding-left: 2.5rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item:last-child { padding-bottom: 0; }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -2.05rem;
        top: 1.1rem;
        height: calc(100% - 1.1rem);
        width: 1.5px;
        background: #e2e8f0;
    }

    .timeline-marker {
        position: absolute;
        left: -2.45rem;
        top: 0.15rem;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--accent);
        border: 3px solid white;
        box-shadow: 0 0 0 2px rgba(232,200,122,0.4);
    }

    .timeline-content h6 {
        color: var(--primary);
        font-weight: 800;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .timeline-content p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .timeline-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .timeline-tag-ongoing {
        background: rgba(8,145,178,0.1);
        border: 1px solid rgba(8,145,178,0.2);
        color: var(--info);
    }

    .timeline-tag-done {
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
    }

    .timeline-tag-work {
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.2);
        color: var(--success);
    }

    /* ─────────────────────────────────────────
       HARAPAN / QUOTE
    ───────────────────────────────────────── */
    .quote-body {
        position: relative;
        padding: 1.5rem 1.75rem 1.5rem 2.5rem;
    }

    .quote-body::before {
        content: '"';
        position: absolute;
        left: 1.25rem;
        top: 0.75rem;
        font-size: 4rem;
        line-height: 1;
        color: var(--accent);
        font-family: 'DM Serif Display', serif;
        opacity: 0.6;
    }

    .quote-body p {
        color: #475569;
        line-height: 1.85;
        font-size: 0.97rem;
        font-style: italic;
        margin: 0;
    }

    /* ─────────────────────────────────────────
       RESPONSIVE
    ───────────────────────────────────────── */
    @media (max-width: 768px) {
        .profile-avatar { width: 130px; height: 130px; margin: -65px auto 1.25rem; }
        .profile-meta { flex-direction: column; gap: 0.5rem; }
        .profile-meta .profile-pill { width: 100%; justify-content: center; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- ── BACK BAR ─────────────────────────────────────────────────── --}}
<div class="back-bar">
    <div class="container">
        <a class="back-link" href="{{ route('public.direktori') }}">
            <i class="bi bi-arrow-left"></i> Kembali ke Direktori
        </a>
    </div>
</div>

<div class="container py-4">

    {{-- ── PROFILE HEADER ──────────────────────────────────────── --}}
    <div class="profile-header">
        <div class="profile-header-bg">
            <div class="profile-header-bg-stripe"></div>
        </div>

        <div class="profile-header-content">
            {{-- Avatar --}}
            <div class="profile-avatar">
                @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp

                @if($fotoUtama)
                    <img src="{{ asset('storage/' . $fotoUtama->path_file) }}" alt="Foto {{ $alumni->nama_lengkap }}">
                @else
                    <div class="profile-avatar-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
            </div>

            {{-- Name & Badges --}}
            <h1 class="profile-name">{{ $alumni->nama_lengkap }}</h1>

            <div class="profile-meta">
                <span class="profile-pill profile-pill-angkatan">
                    <i class="bi bi-mortarboard-fill"></i>
                    {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                </span>
                <span class="profile-pill profile-pill-verified">
                    <i class="bi bi-patch-check-fill"></i>
                    Terverifikasi
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── MAIN COLUMN ─────────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Informasi Pribadi --}}
            <div class="info-section">
                <div class="info-section-header">
                    <i class="bi bi-person-vcard"></i> Informasi Pribadi
                </div>
                <div class="info-section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="bi bi-calendar-event me-1"></i> Tahun Lulus</span>
                            <p class="info-value">{{ $alumni->tahun_lulus }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pendidikan Lanjutan --}}
            @if($alumni->pendidikan->count() > 0)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-mortarboard"></i> Pendidikan Lanjutan
                    </div>
                    <div class="info-section-body">
                        <div class="timeline">
                            @foreach($alumni->pendidikan as $edu)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>{{ $edu->jenjang }}</h6>
                                        <p><strong>{{ $edu->nama_instansi }}</strong></p>
                                        @if($edu->is_ongoing)
                                            <span class="timeline-tag timeline-tag-ongoing">
                                                <i class="bi bi-hourglass-split"></i> Aktif
                                            </span>
                                        @else
                                            <span class="timeline-tag timeline-tag-done">
                                                <i class="bi bi-check-circle"></i> Lulus {{ $edu->tahun_lulus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Pekerjaan --}}
            @if($alumni->pekerjaan->count() > 0)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-briefcase"></i> Pengalaman Pekerjaan
                    </div>
                    <div class="info-section-body">
                        <div class="timeline">
                            @foreach($alumni->pekerjaan as $job)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>{{ $job->jabatan }}</h6>
                                        <p><strong>{{ $job->nama_perusahaan }}</strong></p>
                                        <span class="timeline-tag timeline-tag-work">
                                            <i class="bi bi-briefcase-fill"></i> Aktif Bekerja
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Harapan --}}
            @if($alumni->harapan)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-heart"></i> Harapan untuk Sekolah
                    </div>
                    <div class="quote-body">
                        <p>{{ $alumni->harapan }}</p>
                    </div>
                </div>
            @endif

        </div>

        {{-- ── SIDEBAR ──────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Kontak --}}
            @if($alumni->email || ($alumni->show_no_hp && $alumni->no_hp) || ($alumni->show_no_wa && $alumni->no_wa))
                <div class="contact-section">
                    <div class="contact-section-header">
                        <i class="bi bi-send"></i> Kontak
                    </div>

                    @if($alumni->email)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Email</h6>
                                <a href="mailto:{{ $alumni->email }}" target="_blank">{{ $alumni->email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($alumni->show_no_hp && $alumni->no_hp)
                        <div class="contact-item">
                            <div class="contact-icon" style="background:#1d4ed8;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Nomor HP</h6>
                                <a href="tel:{{ $alumni->no_hp }}" target="_blank">{{ $alumni->no_hp }}</a>
                            </div>
                        </div>
                    @endif

                    @if($alumni->show_no_wa && $alumni->no_wa)
                        <div class="contact-item">
                            <div class="contact-icon" style="background:#16a34a;">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div class="contact-details">
                                <h6>WhatsApp</h6>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_wa) }}" target="_blank">
                                    {{ $alumni->no_wa }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Informasi Akun --}}
            <div class="info-section">
                <div class="info-section-header">
                    <i class="bi bi-info-circle"></i> Informasi Akun
                </div>
                <div class="info-section-body">
                    <div class="info-item mb-4">
                        <span class="info-label"><i class="bi bi-calendar-plus me-1"></i> Terdaftar</span>
                        <p class="info-value small">{{ $alumni->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-clock-history me-1"></i> Update Terakhir</span>
                        <p class="info-value small">{{ $alumni->updated_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
