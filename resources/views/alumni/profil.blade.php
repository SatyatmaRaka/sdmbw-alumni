@extends('layouts.alumni')

@section('title', 'Profil Alumni')

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
        --radius:        14px;
        --transition:    all 0.25s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── BACK BUTTON ─── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
        padding: 0.55rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: var(--transition);
        background: white;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .btn-back:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateX(-2px);
    }

    /* ─── CARD ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .card-section-header {
        background: var(--primary);
        padding: 0.95rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 9px;
        color: white;
        font-weight: 700;
        font-size: 0.83rem;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .card-section-header i { opacity: 0.8; font-size: 1rem; }

    .card-section-body { padding: 1.5rem; }

    /* ─── SIDEBAR PROFILE CARD ─── */
    .profile-sidebar-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }

    .profile-sidebar-bg {
        height: 72px;
        background: var(--primary-dark);
        position: relative;
        overflow: hidden;
    }

    .profile-sidebar-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 18px 18px;
    }

    .profile-sidebar-bg::after {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.6) 0%, transparent 70%);
    }

    /* accent bottom stripe */
    .profile-sidebar-stripe {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(to right, var(--accent), transparent);
    }

    .profile-sidebar-content { padding: 0 1.5rem 1.75rem; }

    .profile-avatar {
        width: 110px; height: 110px;
        border-radius: 28px;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(27,58,82,0.18);
        overflow: hidden;
        margin: -55px auto 1.1rem;
        position: relative;
        z-index: 10;
        background: var(--primary-dark);
        display: flex; align-items: center; justify-content: center;
    }

    .profile-avatar img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }

    .profile-avatar:hover img { transform: scale(1.05); }

    .profile-avatar-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(145deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .profile-avatar-placeholder i { font-size: 3.5rem; color: rgba(255,255,255,0.2); }

    .profile-name {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.35rem;
        color: var(--primary);
        margin-bottom: 0.75rem;
        letter-spacing: -0.2px;
        line-height: 1.25;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3rem 0.85rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .pill-angkatan {
        background: var(--primary);
        color: white;
        box-shadow: 0 3px 10px rgba(27,58,82,0.2);
    }

    .pill-verified {
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.22);
        color: #16a34a;
    }

    .sidebar-lulus {
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
        margin-top: 1rem;
    }

    .sidebar-lulus small { font-size: 0.68rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: #94a3b8; }
    .sidebar-lulus strong { color: var(--primary); font-size: 1.15rem; display: block; margin-top: 2px; }

    /* ─── STATUS CARD ─── */
    .status-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-row:last-child { border-bottom: none; padding-bottom: 0; }
    .status-row:first-child { padding-top: 0; }

    .status-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .status-row small { font-size: 0.66rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: #94a3b8; display: block; }
    .status-row strong { color: var(--primary); font-size: 0.85rem; }

    /* ─── INFO ITEMS ─── */
    .info-item {
        background: #fafbfc;
        padding: 1rem 1.1rem;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
        height: 100%;
        transition: var(--transition);
    }

    .info-item:hover {
        background: white;
        border-color: rgba(232,200,122,0.35);
        box-shadow: 0 4px 12px rgba(27,58,82,0.06);
        transform: translateY(-2px);
    }

    .info-item.accent-left {
        border-left: 3px solid rgba(232,200,122,0.55);
    }

    .info-label {
        display: block;
        font-weight: 700;
        color: #94a3b8;
        font-size: 0.67rem;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .info-value {
        margin: 0;
        color: var(--primary);
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
    }

    .info-value a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .info-value a:hover { color: var(--primary-light); }

    /* ─── TIMELINE (pendidikan/pekerjaan) ─── */
    .timeline-item {
        display: flex;
        gap: 12px;
        padding: 1rem 1.1rem;
        background: #fafbfc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: 0.75rem;
        transition: var(--transition);
    }

    .timeline-item:last-child { margin-bottom: 0; }

    .timeline-item:hover {
        background: white;
        border-color: rgba(232,200,122,0.3);
        box-shadow: 0 4px 12px rgba(27,58,82,0.06);
    }

    .timeline-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .timeline-icon-edu  { background: rgba(27,58,82,0.08); color: var(--primary); }
    .timeline-icon-work { background: rgba(22,163,74,0.08); color: #16a34a; }

    .timeline-content h6 { font-weight: 800; color: var(--primary); margin-bottom: 2px; font-size: 0.92rem; }
    .timeline-content p  { color: #64748b; font-size: 0.82rem; margin-bottom: 5px; }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.22rem 0.65rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .tag-ongoing { background: rgba(8,145,178,0.1); border: 1px solid rgba(8,145,178,0.2); color: #0891b2; }
    .tag-done    { background: var(--accent-soft); border: 1px solid rgba(232,200,122,0.3); color: #7a5c1e; }
    .tag-work    { background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.2); color: #16a34a; }

    .section-sublabel {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 0.85rem;
        display: block;
    }
</style>
@endpush

{{-- ── BACK ── --}}
<div class="mb-4">
    <a href="{{ route('alumni.direktori') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Direktori
    </a>
</div>

<div class="row g-4">

    {{-- ── SIDEBAR ── --}}
    <div class="col-lg-4">

        {{-- Profile Card --}}
        <div class="profile-sidebar-card">
            <div class="profile-sidebar-bg">
                <div class="profile-sidebar-stripe"></div>
            </div>
            <div class="profile-sidebar-content">
                <div class="profile-avatar">
                    @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp
                    @if($fotoUtama)
                        <img src="{{ asset('storage/' . $fotoUtama->path_file) }}" alt="Foto Profil">
                    @else
                        <div class="profile-avatar-placeholder">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                </div>

                <h4 class="profile-name">{{ $alumni->nama_lengkap }}</h4>

                <div class="d-flex flex-wrap justify-content-center gap-2 mb-1">
                    <span class="pill pill-angkatan">
                        <i class="bi bi-mortarboard-fill"></i>
                        {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                    </span>
                    @if($alumni->status_verifikasi === 'verified')
                        <span class="pill pill-verified">
                            <i class="bi bi-patch-check-fill"></i> Terverifikasi
                        </span>
                    @endif
                </div>

                <div class="sidebar-lulus">
                    <small>Tahun Kelulusan</small>
                    <strong>{{ $alumni->tahun_lulus }}</strong>
                </div>
            </div>
        </div>

        {{-- Status Akun --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-shield-check"></i> Status Akun
            </div>
            <div class="card-section-body">
                <div class="status-row">
                    <div class="status-icon"><i class="bi bi-calendar-event text-primary"></i></div>
                    <div>
                        <small>Terdaftar</small>
                        <strong>{{ $alumni->created_at->format('d M Y') }}</strong>
                    </div>
                </div>
                <div class="status-row">
                    <div class="status-icon"><i class="bi bi-arrow-repeat text-success"></i></div>
                    <div>
                        <small>Pembaruan Terakhir</small>
                        <strong>{{ $alumni->updated_at->format('d M Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="col-lg-8">

        {{-- Data Identitas --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-person-vcard-fill"></i> Data Identitas
            </div>
            <div class="card-section-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">NISN</label>
                            <p class="info-value">{{ $alumni->nisn }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">Nama Lengkap</label>
                            <p class="info-value">{{ $alumni->nama_lengkap }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">Angkatan &amp; Tahun Ajaran</label>
                            <p class="info-value">
                                {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                                <span class="fw-normal text-muted" style="font-size:0.85rem;">
                                    ({{ $alumni->angkatan->tahun_ajaran ?? '-' }})
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">Tahun Lulus</label>
                            <p class="info-value">{{ $alumni->tahun_lulus }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item accent-left">
                            <label class="info-label">Pesan &amp; Harapan untuk Sekolah</label>
                            <p class="info-value fw-normal fst-italic" style="color:#475569;">
                                "{{ $alumni->harapan ?? 'Tidak ada pesan yang dibagikan.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi Kontak --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-telephone-inbound-fill"></i> Informasi Kontak
            </div>
            <div class="card-section-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="info-label">Alamat Domisili</label>
                            <p class="info-value">{{ $alumni->alamat ?? 'Alamat belum diatur' }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">Nomor WhatsApp</label>
                            <p class="info-value">
                                @if($alumni->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_hp) }}"
                                       class="d-flex align-items-center gap-2" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i> {{ $alumni->no_hp }}
                                    </a>
                                @else
                                    <span class="text-muted fw-normal fst-italic small">Tidak tersedia</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label">Alamat Email</label>
                            <p class="info-value">
                                @if($alumni->email)
                                    <a href="mailto:{{ $alumni->email }}" class="d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope-at text-primary"></i> {{ $alumni->email }}
                                    </a>
                                @else
                                    <span class="text-muted fw-normal fst-italic small">Belum dipublikasikan</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-journal-bookmark-fill"></i> Riwayat Pendidikan &amp; Karir
            </div>
            <div class="card-section-body">

                {{-- Pendidikan --}}
                <span class="section-sublabel">Pendidikan Lanjutan</span>
                @forelse($alumni->pendidikan as $edu)
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-icon-edu">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h6>{{ $edu->nama_instansi }}</h6>
                            <p>{{ $edu->jenjang }}</p>
                            @if($edu->is_ongoing)
                                <span class="tag tag-ongoing"><i class="bi bi-hourglass-split"></i> Sedang Menempuh</span>
                            @else
                                <span class="tag tag-done"><i class="bi bi-check-circle"></i> Lulus {{ $edu->tahun_lulus }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted small fst-italic mb-4">Belum ada data riwayat pendidikan.</p>
                @endforelse

                {{-- Pekerjaan --}}
                <span class="section-sublabel mt-4 d-block">Pekerjaan Saat Ini</span>
                @forelse($alumni->pekerjaan as $job)
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-icon-work">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h6>{{ $job->nama_perusahaan }}</h6>
                            <p>{{ $job->jabatan }}</p>
                            <span class="tag tag-work"><i class="bi bi-circle-fill" style="font-size:0.4rem;"></i> Aktif</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small fst-italic">Belum ada data riwayat pekerjaan.</p>
                @endforelse

            </div>
        </div>

    </div>
</div>
@endsection
