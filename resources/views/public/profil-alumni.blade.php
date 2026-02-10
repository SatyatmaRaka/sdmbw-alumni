@extends('layouts.landing')

@section('title', 'Profil ' . $alumni->nama_lengkap)

@section('content')
<style>
    :root {
        --primary: #213448;
        --primary-light: #2d4a65;
        --primary-dark: #152230;
        --accent: #EAE0CF;
        --info: #0dcaf0;
        --success: #198754;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .breadcrumb-custom a:hover {
        color: var(--accent);
        transform: translateX(-3px);
    }

    /* Profile Header Card */
    .profile-header {
        background: white;
        border-radius: 16px;
        overflow: visible;
        box-shadow: 0 8px 24px rgba(33, 52, 72, 0.12);
        margin-bottom: 2rem;
        border: 1px solid rgba(234, 224, 207, 0.3);
        padding-top: 3rem;
    }

    .profile-header-bg {
        height: 180px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        position: relative;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
    }

    .profile-header-bg::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(234, 224, 207, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-header-content {
        padding: 0 2rem 2rem;
        text-align: center;
    }

    .profile-avatar {
        width: 160px;
        height: 160px;
        margin: -80px auto 1.5rem;
        border-radius: 16px;
        border: 5px solid white;
        box-shadow: 0 12px 24px rgba(33, 52, 72, 0.25);
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 10;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-avatar-placeholder i {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.3);
    }

    .profile-name {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .profile-badge {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .profile-status {
        background: linear-gradient(135deg, var(--success) 0%, #28a745 100%);
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Info Sections */
    .info-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(33, 52, 72, 0.08);
        margin-bottom: 2rem;
        border: 1px solid rgba(234, 224, 207, 0.2);
    }

    .info-section-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .info-section-header i {
        font-size: 1.3rem;
    }

    .info-section-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .info-item {
        border-left: 4px solid var(--accent);
        padding-left: 1.5rem;
    }

    .info-label {
        display: block;
        color: #666;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
    }

    .info-value.small {
        font-size: 0.95rem;
    }

    .info-value a {
        color: var(--primary);
        text-decoration: none;
        border-bottom: 2px solid var(--accent);
        transition: all 0.3s ease;
        word-break: break-all;
    }

    .info-value a:hover {
        color: var(--primary-light);
        border-color: var(--primary);
    }

    /* Contact Section */
    .contact-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(33, 52, 72, 0.08);
        margin-bottom: 2rem;
        border: 1px solid rgba(234, 224, 207, 0.2);
    }

    .contact-item {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(33, 52, 72, 0.08);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: all 0.3s ease;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item:hover {
        background: rgba(33, 52, 72, 0.02);
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .contact-details {
        flex-grow: 1;
        min-width: 0;
    }

    .contact-details h6 {
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-details p {
        margin: 0;
        color: #666;
        font-weight: 500;
        word-break: break-all;
    }

    .contact-details a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        word-break: break-all;
    }

    .contact-details a:hover {
        color: var(--primary-light);
    }

    /* Timeline Style */
    .timeline {
        position: relative;
        padding-left: 3rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -2.5rem;
        top: 2rem;
        height: calc(100% - 2rem);
        width: 2px;
        background: rgba(33, 52, 72, 0.1);
    }

    .timeline-marker {
        position: absolute;
        left: -2.9rem;
        top: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(33, 52, 72, 0.2);
    }

    .timeline-content h6 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .timeline-content p {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .timeline-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-name {
            font-size: 1.5rem;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            margin: -70px auto 1.5rem;
        }

        .profile-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .profile-meta .profile-badge,
        .profile-meta .profile-status {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <div class="container">
        <a href="{{ route('public.direktori') }}">
            <i class="bi bi-arrow-left"></i> Kembali ke Direktori
        </a>
    </div>
</div>

<div class="container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-header-bg"></div>

        <div class="profile-header-content">
            <!-- Avatar -->
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

            <!-- Name & Meta -->
            <h1 class="profile-name">{{ $alumni->nama_lengkap }}</h1>

            <div class="profile-meta">
                <span class="profile-badge">
                    <i class="bi bi-mortarboard-fill"></i>
                    {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                </span>
                <span class="profile-status">
                    <i class="bi bi-check-circle-fill"></i>
                    Terverifikasi
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Informasi Pribadi -->
            <div class="info-section">
                <div class="info-section-header">
                    <i class="bi bi-person-vcard"></i>
                    Informasi Pribadi
                </div>
                <div class="info-section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="bi bi-calendar-event"></i> Tahun Lulus</span>
                            <p class="info-value">{{ $alumni->tahun_lulus }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendidikan Lanjutan -->
            @if($alumni->pendidikan->count() > 0)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-mortarboard"></i>
                        Pendidikan Lanjutan
                    </div>
                    <div class="info-section-body">
                        <div class="timeline">
                            @foreach($alumni->pendidikan as $edu)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>{{ $edu->jenjang }}</h6>
                                        <p class="mb-2"><strong>{{ $edu->nama_instansi }}</strong></p>
                                        @if($edu->is_ongoing)
                                            <span class="timeline-badge" style="background: linear-gradient(135deg, var(--info) 0%, #20c997 100%);">
                                                <i class="bi bi-hourglass-split"></i> Aktif
                                            </span>
                                        @else
                                            <span class="timeline-badge">
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

            <!-- Pekerjaan -->
            @if($alumni->pekerjaan->count() > 0)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-briefcase"></i>
                        Pengalaman Pekerjaan
                    </div>
                    <div class="info-section-body">
                        <div class="timeline">
                            @foreach($alumni->pekerjaan as $job)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>{{ $job->jabatan }}</h6>
                                        <p><strong>{{ $job->nama_perusahaan }}</strong></p>
                                        <span class="timeline-badge" style="background: linear-gradient(135deg, var(--success) 0%, #28a745 100%);">
                                            <i class="bi bi-briefcase-fill"></i> Aktif Bekerja
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Harapan & Aspirasi -->
            @if($alumni->harapan)
                <div class="info-section">
                    <div class="info-section-header">
                        <i class="bi bi-heart"></i>
                        Harapan untuk Sekolah
                    </div>
                    <div class="info-section-body">
                        <p style="color: #333; line-height: 1.8; font-size: 1rem;">
                            <em>"{{ $alumni->harapan }}"</em>
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Kontak Section -->
            {{-- Menampilkan Email (selalu jika ada) dan Nomor HP/WhatsApp (berdasarkan toggle) --}}
            @if($alumni->email || ($alumni->show_no_hp && $alumni->no_hp) || ($alumni->show_no_wa && $alumni->no_wa))
                <div class="contact-section">
                    {{-- Email - Selalu tampil jika ada --}}
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

                    {{-- Nomor HP - Tampil hanya jika show_no_hp = 1 --}}
                    @if($alumni->show_no_hp && $alumni->no_hp)
                        <div class="contact-item">
                            <div class="contact-icon" style="background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-details">
                                <h6>Nomor HP</h6>
                                <a href="tel:{{ $alumni->no_hp }}" target="_blank">{{ $alumni->no_hp }}</a>
                            </div>
                        </div>
                    @endif

                    {{-- Nomor WhatsApp - Tampil hanya jika show_no_wa = 1 --}}
                    @if($alumni->show_no_wa && $alumni->no_wa)
                        <div class="contact-item">
                            <div class="contact-icon" style="background: linear-gradient(135deg, #25d366 0%, #20ba61 100%);">
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

            <!-- Quick Info Card -->
            <div class="info-section">
                <div class="info-section-header">
                    <i class="bi bi-info-circle"></i>
                    Informasi Akun
                </div>
                <div class="info-section-body">
                    <div class="info-item mb-3">
                        <span class="info-label"><i class="bi bi-calendar-plus"></i> Terdaftar</span>
                        <p class="info-value small">{{ $alumni->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-clock-history"></i> Update Terakhir</span>
                        <p class="info-value small">{{ $alumni->updated_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
