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
        --success:       #16a34a;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── BACK ─── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
        padding: 0.52rem 1.1rem;
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
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .card-section-header i { opacity: 0.8; }
    .card-section-body { padding: 1.5rem; }

    /* ─── SIDEBAR PROFILE ─── */
    .profile-sidebar-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .profile-sidebar-bg {
        height: 70px;
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
        top: -40px; right: -40px;
        width: 130px; height: 130px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,83,120,0.55) 0%, transparent 70%);
    }

    .profile-sidebar-stripe {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(to right, var(--accent), transparent);
        z-index: 2;
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
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
    }

    .profile-avatar img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .profile-avatar:hover img { transform: scale(1.05); }

    .avatar-initial {
        font-size: 2.5rem;
        font-weight: 800;
        color: rgba(255,255,255,0.25);
    }

    .profile-name {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.25rem;
        color: var(--primary);
        margin-bottom: 0.65rem;
        line-height: 1.25;
    }

    .pill-angkatan {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.9rem;
        border-radius: 50px;
        font-size: 0.77rem;
        font-weight: 700;
        box-shadow: 0 3px 10px rgba(27,58,82,0.2);
    }

    /* ─── INFO GRID ─── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }

    .info-item {
        background: #fafbfc;
        padding: 0.9rem 1rem;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
        transition: var(--transition);
    }

    .info-item:hover {
        background: white;
        border-color: rgba(232,200,122,0.3);
        box-shadow: 0 4px 12px rgba(27,58,82,0.06);
    }

    .info-item.full { grid-column: 1 / -1; }

    .info-label {
        display: block;
        font-size: 0.67rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.35rem;
    }

    .info-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
        line-height: 1.4;
    }

    .info-value.muted { color: #94a3b8; font-weight: 400; font-style: italic; }

    /* status badge inside info */
    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.65rem;
        border-radius: 5px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .tag-success { background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.2); color: var(--success); }
    .tag-warn    { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.2);  color: #d97706; }

    /* ─── KONTAK ROW ─── */
    .kontak-section {
        padding-top: 1rem;
        margin-top: 0.25rem;
        border-top: 1px solid #f1f5f9;
    }

    .kontak-sublabel {
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.65rem;
    }

    .kontak-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.42rem 1rem;
        border-radius: 8px;
        font-size: 0.83rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        margin-right: 8px;
        margin-bottom: 6px;
    }

    .kontak-email {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
    }

    .kontak-email:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .kontak-wa {
        background: rgba(22,163,74,0.08);
        border: 1.5px solid rgba(22,163,74,0.25);
        color: var(--success);
    }

    .kontak-wa:hover {
        background: var(--success);
        color: white;
        border-color: var(--success);
    }

    .kontak-empty {
        font-size: 0.83rem;
        color: #94a3b8;
        font-style: italic;
    }

    /* ─── TIMELINE ─── */
    .timeline-item {
        display: flex;
        gap: 11px;
        padding: 0.85rem 1rem;
        background: #fafbfc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: 0.65rem;
        transition: var(--transition);
    }

    .timeline-item:last-child { margin-bottom: 0; }

    .timeline-item:hover {
        background: white;
        border-color: rgba(232,200,122,0.3);
        box-shadow: 0 4px 12px rgba(27,58,82,0.06);
    }

    .timeline-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.88rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .icon-edu  { background: rgba(27,58,82,0.08);  color: var(--primary); }
    .icon-work { background: rgba(22,163,74,0.08); color: var(--success); }

    .timeline-content h6 { font-weight: 800; color: var(--primary); margin-bottom: 2px; font-size: 0.88rem; }
    .timeline-content p  { color: #64748b; font-size: 0.8rem; margin-bottom: 5px; }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.6rem;
        border-radius: 5px;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .tag-ongoing { background: rgba(8,145,178,0.1); border: 1px solid rgba(8,145,178,0.2); color: #0891b2; }
    .tag-done    { background: var(--accent-soft);  border: 1px solid rgba(232,200,122,0.3); color: #7a5c1e; }
    .tag-work    { background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.2);  color: var(--success); }

    /* ─── HARAPAN CARD ─── */
    .harapan-card {
        background: var(--primary-dark);
        border-radius: var(--radius);
        border: 1px solid rgba(232,200,122,0.15);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        position: relative;
        margin-bottom: 1.5rem;
    }

    .harapan-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 20px 20px;
        pointer-events: none;
    }

    .harapan-card-header {
        padding: 0.95rem 1.5rem 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--accent);
    }

    .harapan-card-body {
        padding: 0.5rem 1.5rem 1.5rem;
        position: relative;
        z-index: 1;
    }

    .quote-mark {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 4.5rem;
        line-height: 0.75;
        color: var(--accent);
        opacity: 0.3;
        display: block;
        margin-bottom: -0.5rem;
    }

    .harapan-text {
        font-style: italic;
        color: rgba(255,255,255,0.72);
        font-size: 0.95rem;
        line-height: 1.85;
        margin: 0;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 576px) {
        .info-grid { grid-template-columns: 1fr; }
        .info-item.full { grid-column: auto; }
        .profile-avatar { width: 90px; height: 90px; border-radius: 22px; margin-top: -45px; }
        .avatar-initial { font-size: 2rem; }
    }
</style>

{{-- ── BACK ── --}}
<div class="mb-4">
    <a href="{{ route('alumni.direktori.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Direktori
    </a>
</div>

<div class="row g-4">

    {{-- ── SIDEBAR ── --}}
    <div class="col-lg-4">
        <div class="profile-sidebar-card">
            <div class="profile-sidebar-bg">
                <div class="profile-sidebar-stripe"></div>
            </div>
            <div class="profile-sidebar-content">
                @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp
                <div class="profile-avatar">
                    @if($fotoUtama)
                        <img src="{{ asset('storage/' . $fotoUtama->path_file) }}"
                             alt="Foto {{ $alumni->nama_lengkap }}">
                    @else
                        <span class="avatar-initial">
                            {{ strtoupper(substr($alumni->nama_lengkap, 0, 1)) }}
                        </span>
                    @endif
                </div>

                <h4 class="profile-name">{{ $alumni->nama_lengkap }}</h4>
                <span class="pill-angkatan">
                    <i class="bi bi-mortarboard-fill"></i>
                    {{ $alumni->angkatan->nama_angkatan ?? 'Alumni' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="col-lg-8">

        {{-- Informasi Lengkap --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-person-vcard-fill"></i> Informasi Lengkap
            </div>
            <div class="card-section-body">

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Lengkap</span>
                        <p class="info-value">{{ $alumni->nama_lengkap }}</p>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Angkatan</span>
                        <p class="info-value">{{ $alumni->angkatan->nama_angkatan ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tahun Ajaran</span>
                        <p class="info-value">{{ $alumni->angkatan->tahun_ajaran ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Kelulusan</span>
                        <p class="info-value">
                            @php $status = $alumni->angkatan->status ?? '-'; @endphp
                            @if($status === 'LULUS')
                                <span class="status-tag tag-success"><i class="bi bi-check-circle-fill"></i> {{ $status }}</span>
                            @else
                                <span class="status-tag tag-warn"><i class="bi bi-hourglass-split"></i> {{ $status }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="kontak-section">
                    <span class="kontak-sublabel">Kontak</span>

                    @php
                        $displayEmail = $alumni->email ?? ($alumni->user->username ?? null);
                        $showWa = $alumni->show_no_hp && !empty($alumni->no_hp);
                    @endphp

                    @if($displayEmail)
                        <a href="mailto:{{ $displayEmail }}" class="kontak-link kontak-email">
                            <i class="bi bi-envelope-at"></i> {{ $displayEmail }}
                        </a>
                    @endif

                    @if($showWa)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_hp) }}"
                           target="_blank" class="kontak-link kontak-wa">
                            <i class="bi bi-whatsapp"></i> {{ \App\Helpers\FormatHelper::phone($alumni->no_hp) }}
                        </a>
                    @endif

                    @if(!$displayEmail && !$showWa)
                        <span class="kontak-empty">Informasi kontak tidak tersedia.</span>
                    @endif
                </div>

            </div>
        </div>

        {{-- Pendidikan Lanjutan --}}
        @if($alumni->pendidikan->count() > 0)
            <div class="card-section">
                <div class="card-section-header">
                    <i class="bi bi-mortarboard-fill"></i> Pendidikan Lanjutan
                </div>
                <div class="card-section-body">
                    @foreach($alumni->pendidikan as $edu)
                        <div class="timeline-item">
                            <div class="timeline-icon icon-edu">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>{{ $edu->nama_instansi }}</h6>
                                <p>{{ $edu->jenjang }}</p>
                                @if($edu->is_ongoing)
                                    <span class="tag tag-ongoing"><i class="bi bi-hourglass-split"></i> Masih Belajar (Aktif)</span>
                                @else
                                    <span class="tag tag-done"><i class="bi bi-check-circle"></i> Lulus {{ $edu->tahun_lulus ?? '-' }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Pekerjaan --}}
        @if($alumni->pekerjaan->count() > 0)
            <div class="card-section">
                <div class="card-section-header">
                    <i class="bi bi-briefcase-fill"></i> Riwayat Pekerjaan
                </div>
                <div class="card-section-body">
                    @foreach($alumni->pekerjaan as $job)
                        <div class="timeline-item">
                            <div class="timeline-icon icon-work">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>{{ $job->nama_perusahaan }}</h6>
                                <p>{{ $job->jabatan }}</p>
                                <span class="tag tag-work"><i class="bi bi-circle-fill" style="font-size:0.35rem;"></i> Aktif</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Harapan --}}
        @if($alumni->harapan)
            <div class="harapan-card">
                <div class="harapan-card-header">
                    <i class="bi bi-chat-left-quote-fill"></i> Harapan &amp; Pesan
                </div>
                <div class="harapan-card-body">
                    <span class="quote-mark">"</span>
                    <p class="harapan-text">{{ $alumni->harapan }}</p>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
