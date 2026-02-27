@extends('layouts.alumni')

@section('title', 'Dashboard Alumni')

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --success:       #16a34a;
        --warning:       #d97706;
        --danger:        #e53e3e;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── CARD BASE ─── */
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

    /* ─── STATUS PILLS ─── */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.78rem;
    }

    .pill-verified   { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .pill-pending    { background: rgba(100,116,139,0.1); border: 1px solid rgba(100,116,139,0.2); color: #64748b; }
    .pill-rejected   { background: rgba(229,62,62,0.1);   border: 1px solid rgba(229,62,62,0.2);   color: var(--danger); }
    .pill-complete   { background: var(--accent-soft);    border: 1px solid rgba(232,200,122,0.3);  color: #7a5c1e; }
    .pill-incomplete { background: rgba(217,119,6,0.1);   border: 1px solid rgba(217,119,6,0.2);   color: var(--warning); }

    .status-sublabel {
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        color: #94a3b8;
        display: block;
        margin-bottom: 5px;
    }

    /* ─── ALERTS ─── */
    .alert-custom {
        border: none;
        border-radius: 10px;
        padding: 0.85rem 1.1rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 1rem;
        margin-bottom: 0;
    }

    .alert-info-custom    { background: #eff6ff; color: #1e40af; border-left: 3px solid #3b82f6; }
    .alert-warning-custom { background: #fffbeb; color: #92400e; border-left: 3px solid #f59e0b; }
    .alert-custom i { font-size: 1rem; flex-shrink: 0; margin-top: 2px; }

    .alert-action {
        color: inherit;
        font-weight: 800;
        text-decoration: none;
        border-bottom: 1.5px solid currentColor;
        padding-bottom: 1px;
        margin-left: 4px;
    }

    .alert-action:hover { opacity: 0.7; }

    /* ─── PROGRESS ─── */
    .progress-wrap {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #f1f5f9;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .progress-header small { font-weight: 700; font-size: 0.75rem; color: #64748b; }

    .progress-track {
        background: #f1f5f9;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        margin-bottom: 6px;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
    }

    .fill-success { background: linear-gradient(to right, #16a34a, #22c55e); }
    .fill-warning { background: linear-gradient(to right, #d97706, #fbbf24); }
    .fill-danger  { background: linear-gradient(to right, #e53e3e, #f87171); }

    .progress-message { font-size: 0.8rem; font-weight: 700; margin-bottom: 0.85rem; }

    .progress-items {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3px 8px;
    }

    .progress-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.79rem;
        font-weight: 500;
        padding: 2px 0;
    }

    .progress-item.done   { color: var(--success); }
    .progress-item.undone { color: #94a3b8; }

    .btn-complete {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.7rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition);
        margin-top: 1rem;
    }

    .btn-complete:hover {
        background: var(--primary-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
    }

    /* ─── BIODATA ROWS ─── */
    .bio-row {
        display: flex;
        padding: 0.72rem 0;
        border-bottom: 1px solid #f1f5f9;
        gap: 1rem;
        align-items: flex-start;
    }

    .bio-row:last-child { border-bottom: none; padding-bottom: 0; }
    .bio-row:first-child { padding-top: 0; }

    .bio-label {
        font-size: 0.76rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        min-width: 140px;
        width: 140px;
        flex-shrink: 0;
        padding-top: 2px;
    }

    .bio-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
        flex: 1;
        min-width: 0;
        word-break: break-word;
    }

    .bio-value.muted { color: #94a3b8; font-weight: 400; font-style: italic; }

    .bio-angkatan-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        padding: 0.2rem 0.65rem;
        border-radius: 5px;
        font-size: 0.77rem;
        font-weight: 700;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.65rem 1.5rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(27,58,82,0.18);
    }

    .btn-edit:hover {
        background: var(--primary-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
    }

    /* ─── TIMELINE ─── */
    .timeline-item {
        display: flex;
        gap: 10px;
        padding: 0.8rem 1rem;
        background: #fafbfc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: 0.6rem;
        transition: var(--transition);
    }

    .timeline-item:last-child { margin-bottom: 0; }

    .timeline-item:hover {
        background: white;
        border-color: rgba(232,200,122,0.3);
        box-shadow: 0 4px 12px rgba(27,58,82,0.06);
    }

    .timeline-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.88rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .icon-edu  { background: rgba(27,58,82,0.08); color: var(--primary); }
    .icon-work { background: rgba(22,163,74,0.08); color: var(--success); }

    .timeline-content h6 { font-weight: 800; color: var(--primary); margin-bottom: 2px; font-size: 0.87rem; }
    .timeline-content p  { color: #64748b; font-size: 0.8rem; margin-bottom: 5px; }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.55rem;
        border-radius: 5px;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .tag-ongoing { background: rgba(8,145,178,0.1); border: 1px solid rgba(8,145,178,0.2); color: #0891b2; }
    .tag-done    { background: var(--accent-soft);  border: 1px solid rgba(232,200,122,0.3); color: #7a5c1e; }
    .tag-work    { background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.2);  color: var(--success); }

    /* ─── SIDEBAR PROFILE CARD ─── */
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
        height: 60px;
        background: var(--primary-dark);
        position: relative;
        overflow: hidden;
    }

    .profile-sidebar-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 16px 16px;
    }

    .profile-sidebar-stripe {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(to right, var(--accent), transparent);
    }

    .profile-sidebar-content { padding: 0 1.5rem 1.5rem; }

    .avatar-wrap {
        width: 88px; height: 88px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 6px 18px rgba(27,58,82,0.15);
        overflow: hidden;
        margin: -44px auto 0.9rem;
        position: relative;
        z-index: 10;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
    }

    .avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-initial {
        font-size: 2rem;
        font-weight: 800;
        color: white;
    }

    .sidebar-name {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.05rem;
        color: var(--primary);
        margin-bottom: 3px;
        line-height: 1.3;
    }

    .sidebar-angkatan { font-size: 0.78rem; color: #94a3b8; font-weight: 500; margin-bottom: 7px; }

    .sidebar-email-tag {
        display: inline-block;
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
        word-break: break-all;
        max-width: 100%;
    }

    /* ─── ACCOUNT INFO ─── */
    .account-row {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 0.8rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .account-row:last-child { border-bottom: none; padding-bottom: 0; }
    .account-row:first-child { padding-top: 0; }

    .account-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 0.88rem;
    }

    .account-row small  { font-size: 0.66rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #94a3b8; display: block; }
    .account-row strong { color: var(--primary); font-size: 0.83rem; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 576px) {
        .bio-label { min-width: 110px; width: 110px; font-size: 0.7rem; }
        .progress-items { grid-template-columns: 1fr; }
    }
</style>

<div class="row g-4">

    {{-- ── LEFT MAIN ── --}}
    <div class="col-lg-8">

        {{-- STATUS AKUN --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-shield-check"></i> Status Akun
            </div>
            <div class="card-section-body">

                {{-- Status Pills --}}
                <div class="d-flex flex-wrap gap-4 mb-1">
                    <div>
                        <span class="status-sublabel">Verifikasi</span>
                        @switch($alumni->status_verifikasi)
                            @case('verified')
                                <span class="status-pill pill-verified"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
                                @break
                            @case('pending')
                                <span class="status-pill pill-pending"><i class="bi bi-clock-fill"></i> Menunggu Verifikasi</span>
                                @break
                            @default
                                <span class="status-pill pill-rejected"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                        @endswitch
                    </div>
                    <div>
                        <span class="status-sublabel">Kelengkapan</span>
                        @if($alumni->is_profile_complete)
                            <span class="status-pill pill-complete"><i class="bi bi-check-all"></i> Data Lengkap</span>
                        @else
                            <span class="status-pill pill-incomplete"><i class="bi bi-exclamation-triangle-fill"></i> Belum Lengkap</span>
                        @endif
                    </div>
                </div>

                @if($alumni->status_verifikasi === 'pending')
                    <div class="alert-custom alert-info-custom">
                        <i class="bi bi-info-circle-fill"></i>
                        <div><strong>Info:</strong> Akun Anda sedang ditinjau Admin. Silakan lengkapi biodata.</div>
                    </div>
                @endif

                @if(!$alumni->is_profile_complete)
                    <div class="alert-custom alert-warning-custom">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Perhatian:</strong> Profil Anda belum lengkap.
                            <a href="{{ route('alumni.profile.edit') }}" class="alert-action">
                                Lengkapi Sekarang <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Progress --}}
                @php
                    $score = 0; $items = [];
                    if (!empty($alumni->alamat))  { $score += 10; $items['Alamat'] = true;  } else { $items['Alamat'] = false; }
                    if (!empty($alumni->no_hp))   { $score += 10; $items['No HP'] = true;   } else { $items['No HP'] = false; }
                    if (!empty($alumni->email))   { $score += 10; $items['Email'] = true;   } else { $items['Email'] = false; }
                    if (!empty($alumni->harapan)) { $score += 10; $items['Harapan'] = true; } else { $items['Harapan'] = false; }
                    $hasFoto = $alumni->fotos->where('is_main', true)->first();
                    if ($hasFoto) { $score += 15; $items['Foto Profil'] = true; } else { $items['Foto Profil'] = false; }
                    if ($alumni->pendidikan->count() > 0) { $score += 30; $items['Riwayat Pendidikan'] = true; } else { $items['Riwayat Pendidikan'] = false; }
                    if ($alumni->pekerjaan->count() > 0)  { $score += 15; $items['Riwayat Pekerjaan'] = true;  } else { $items['Riwayat Pekerjaan'] = false; }

                    if ($score >= 80) {
                        $barClass = 'fill-success'; $msgStyle = 'color:var(--success)';
                        $message = '🎉 Profil Anda sudah sangat lengkap!';
                    } elseif ($score >= 50) {
                        $barClass = 'fill-warning'; $msgStyle = 'color:var(--warning)';
                        $message = '💪 Hampir lengkap! Tambahkan beberapa data lagi.';
                    } else {
                        $barClass = 'fill-danger'; $msgStyle = 'color:var(--danger)';
                        $message = '📝 Profil belum lengkap. Segera lengkapi data Anda.';
                    }
                @endphp

                <div class="progress-wrap">
                    <div class="progress-header">
                        <small>Kelengkapan Profil</small>
                        <small style="{{ $msgStyle }}; font-weight:800;">{{ $score }}%</small>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $barClass }}" style="width:{{ $score }}%"
                             role="progressbar" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="progress-message" style="{{ $msgStyle }}">{{ $message }}</p>

                    <div class="progress-items">
                        @foreach($items as $label => $done)
                            <div class="progress-item {{ $done ? 'done' : 'undone' }}">
                                <i class="bi {{ $done ? 'bi-check-circle-fill' : 'bi-circle' }}" style="font-size:0.7rem;"></i>
                                {{ $label }}
                            </div>
                        @endforeach
                    </div>

                    @if($score < 100)
                        <a href="{{ route('alumni.profile.edit') }}" class="btn-complete">
                            <i class="bi bi-pencil-square"></i> Lengkapi Profil Sekarang
                        </a>
                    @endif
                </div>

            </div>
        </div>

        {{-- BIODATA --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-person-lines-fill"></i> Biodata Diri
            </div>
            <div class="card-section-body">

                <div class="bio-row">
                    <span class="bio-label">NISN</span>
                    <span class="bio-value">{{ $alumni->nisn }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Nama Lengkap</span>
                    <span class="bio-value">{{ $alumni->nama_lengkap }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Angkatan</span>
                    <span class="bio-value">
                        <span class="bio-angkatan-tag">{{ $alumni->angkatan->nama_angkatan ?? '-' }}</span>
                        <span class="text-muted fw-normal ms-1" style="font-size:0.8rem;">({{ $alumni->angkatan->tahun_ajaran ?? '-' }})</span>
                    </span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Tahun Lulus</span>
                    <span class="bio-value">{{ $alumni->tahun_lulus }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Alamat</span>
                    <span class="bio-value {{ !$alumni->alamat ? 'muted' : '' }}">{{ $alumni->alamat ?? '-' }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">No HP</span>
                    <span class="bio-value {{ !$alumni->no_hp ? 'muted' : '' }}">{{ \App\Helpers\FormatHelper::phone($alumni->no_hp) }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Email</span>
                    <span class="bio-value {{ !$alumni->email ? 'muted' : '' }}">{{ $alumni->email ?? ($alumni->user->username ?? '-') }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Harapan</span>
                    <span class="bio-value fw-normal fst-italic" style="color:#475569;">
                        {{ $alumni->harapan ? '"'.$alumni->harapan.'"' : '-' }}
                    </span>
                </div>

                {{-- Pendidikan --}}
                <div class="bio-row" style="align-items:flex-start;">
                    <span class="bio-label" style="padding-top:3px;">Pendidikan</span>
                    <div style="flex:1; min-width:0;">
                        @forelse($alumni->pendidikan as $edu)
                            <div class="timeline-item">
                                <div class="timeline-icon icon-edu"><i class="bi bi-mortarboard-fill"></i></div>
                                <div class="timeline-content">
                                    <h6>{{ $edu->jenjang }}: {{ $edu->nama_instansi }}</h6>
                                    @if($edu->jenjang === 'Perguruan Tinggi' && $edu->program_studi)
                                        <p>Prodi: {{ $edu->program_studi }}</p>
                                    @endif
                                    @if($edu->is_ongoing)
                                        <span class="tag tag-ongoing"><i class="bi bi-hourglass-split"></i> Aktif — Masuk {{ $edu->tahun_masuk }}</span>
                                    @else
                                        <span class="tag tag-done"><i class="bi bi-check-circle"></i> Lulus {{ $edu->tahun_lulus }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <span class="text-muted small fst-italic">-</span>
                        @endforelse
                    </div>
                </div>

                {{-- Pekerjaan --}}
                <div class="bio-row" style="align-items:flex-start; border-bottom:none; padding-bottom:0;">
                    <span class="bio-label" style="padding-top:3px;">Pekerjaan</span>
                    <div style="flex:1; min-width:0;">
                        @forelse($alumni->pekerjaan as $job)
                            <div class="timeline-item">
                                <div class="timeline-icon icon-work"><i class="bi bi-briefcase-fill"></i></div>
                                <div class="timeline-content">
                                    <h6>{{ $job->nama_perusahaan }}</h6>
                                    <p>{{ $job->jabatan }}</p>
                                    <span class="tag tag-work"><i class="bi bi-circle-fill" style="font-size:0.35rem;"></i> Aktif</span>
                                </div>
                            </div>
                        @empty
                            <span class="text-muted small fst-italic">-</span>
                        @endforelse
                    </div>
                </div>

                <div class="text-end mt-4 pt-3 border-top">
                    <a href="{{ route('alumni.profile.edit') }}" class="btn-edit">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                </div>

            </div>
        </div>

    </div>

    {{-- ── RIGHT SIDEBAR ── --}}
    <div class="col-lg-4">

        {{-- Profile Card --}}
        <div class="profile-sidebar-card">
            <div class="profile-sidebar-bg">
                <div class="profile-sidebar-stripe"></div>
            </div>
            <div class="profile-sidebar-content">
                @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp

                <div class="avatar-wrap">
                    @if($fotoUtama && file_exists(public_path('storage/' . $fotoUtama->path_file)))
                        <img src="{{ asset('storage/' . $fotoUtama->path_file) }}"
                             alt="Foto Profil"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <span class="avatar-initial" style="display:none;">
                            {{ strtoupper(substr($alumni->nama_lengkap, 0, 1)) }}
                        </span>
                    @else
                        <span class="avatar-initial">
                            {{ strtoupper(substr($alumni->nama_lengkap, 0, 1)) }}
                        </span>
                    @endif
                </div>

                <h5 class="sidebar-name">{{ $alumni->nama_lengkap }}</h5>
                <p class="sidebar-angkatan">{{ $alumni->angkatan->nama_angkatan ?? 'Alumni' }}</p>
                <span class="sidebar-email-tag">{{ $alumni->email ?? (Auth::user()->username ?? 'User') }}</span>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="card-section">
            <div class="card-section-header">
                <i class="bi bi-shield-lock"></i> Informasi Akun
            </div>
            <div class="card-section-body">

                <div class="account-row">
                    <div class="account-icon"><i class="bi bi-calendar-check text-success"></i></div>
                    <div>
                        <small>Tanggal Registrasi</small>
                        <strong>{{ optional($alumni->created_at)->format('d M Y') }}</strong>
                    </div>
                </div>

                <div class="account-row">
                    <div class="account-icon"><i class="bi bi-arrow-repeat text-primary"></i></div>
                    <div>
                        <small>Update Terakhir</small>
                        <strong>{{ optional($alumni->updated_at)->format('d M Y H:i') }}</strong>
                    </div>
                </div>

                @if(Auth::user()->last_login_at)
                    <div class="account-row">
                        <div class="account-icon"><i class="bi bi-box-arrow-in-right" style="color:var(--warning);"></i></div>
                        <div>
                            <small>Login Terakhir</small>
                            <strong>{{ \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y H:i') }}</strong>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
