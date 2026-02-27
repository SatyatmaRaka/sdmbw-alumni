@extends('layouts.admin')

@section('title', 'Detail Alumni')
@section('page-title', 'Detail Alumni')

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
        --info:          #0891b2;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── CARD ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .card-section-header {
        background: var(--primary);
        padding: 0.9rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .card-section-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: white;
        font-weight: 700;
        font-size: 0.82rem;
    }

    .card-section-title i { opacity: 0.8; }
    .card-section-body { padding: 1.4rem 1.5rem; }

    /* ─── BIO ROWS ─── */
    .bio-row {
        display: flex;
        padding: 0.65rem 0;
        border-bottom: 1px solid #f8fafc;
        gap: 1rem;
        align-items: flex-start;
    }

    .bio-row:last-child { border-bottom: none; padding-bottom: 0; }
    .bio-row:first-child { padding-top: 0; }

    .bio-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        min-width: 130px;
        width: 130px;
        flex-shrink: 0;
        padding-top: 1px;
    }

    .bio-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--primary);
        flex: 1;
        min-width: 0;
        word-break: break-word;
    }

    .bio-value.normal { font-weight: 400; color: #334155; }
    .bio-value.muted  { font-weight: 400; color: #94a3b8; font-style: italic; }

    .bio-angkatan-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        padding: 0.18rem 0.6rem;
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .bio-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 0.25rem 0;
    }

    .public-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.55rem;
        border-radius: 5px;
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.22);
        color: var(--success);
        font-size: 0.7rem;
        font-weight: 700;
        margin-left: 7px;
    }

    /* ─── TIMELINE ─── */
    .timeline-item {
        display: flex;
        gap: 11px;
        padding: 0.9rem 1rem;
        background: #fafbfc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: 0.65rem;
        transition: var(--transition);
    }

    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item:hover { background: white; border-color: rgba(232,200,122,0.3); box-shadow: 0 4px 12px rgba(27,58,82,0.06); }

    .timeline-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.88rem;
        flex-shrink: 0;
    }

    .icon-edu  { background: rgba(27,58,82,0.08); color: var(--primary); }
    .icon-work { background: rgba(22,163,74,0.08); color: var(--success); }
    .icon-work-current { background: rgba(8,145,178,0.1); color: var(--info); }

    .timeline-content h6 { font-weight: 800; color: var(--primary); margin-bottom: 2px; font-size: 0.88rem; }
    .timeline-content p  { color: #64748b; font-size: 0.8rem; margin-bottom: 4px; }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.55rem;
        border-radius: 5px;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .tag-ongoing { background: rgba(8,145,178,0.1); border: 1px solid rgba(8,145,178,0.2); color: var(--info); }
    .tag-done    { background: var(--accent-soft);  border: 1px solid rgba(232,200,122,0.3); color: #7a5c1e; }
    .tag-current { background: rgba(8,145,178,0.1); border: 1px solid rgba(8,145,178,0.2); color: var(--info); }

    /* ─── SIDEBAR FOTO ─── */
    .foto-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .foto-card-header {
        background: var(--primary);
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 7px;
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        position: relative;
    }

    .foto-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .foto-card-header i { opacity: 0.8; }
    .foto-card-body { padding: 1.25rem; }

    .foto-wrap {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }

    .foto-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .foto-wrap:hover img { transform: scale(1.04); }

    .foto-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 2.5rem 1rem;
        color: #94a3b8;
    }

    .foto-empty i { font-size: 2.5rem; opacity: 0.3; }
    .foto-empty p { font-size: 0.82rem; font-weight: 600; margin: 0; }

    .foto-meta {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 0.65rem;
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
    }

    /* ─── STATUS CARD ─── */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.82rem;
    }

    .pill-verified   { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .pill-pending    { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .pill-rejected   { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }
    .pill-complete   { background: var(--accent-soft);   border: 1px solid rgba(232,200,122,0.3);  color: #7a5c1e; }
    .pill-incomplete { background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; }
    .pill-active     { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .pill-inactive   { background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; }

    .status-sublabel {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #94a3b8;
        display: block;
        margin-bottom: 6px;
    }

    .status-info-box {
        background: #f8fafc;
        border-radius: 9px;
        border: 1px solid #f1f5f9;
        padding: 0.75rem 1rem;
        font-size: 0.82rem;
        color: #475569;
        margin-top: 1rem;
    }

    .status-info-box strong { color: var(--primary); }

    /* ─── AKSI BUTTONS ─── */
    .aksi-section { display: flex; flex-direction: column; gap: 0.5rem; }

    .btn-aksi {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.65rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        border: none;
    }

    .btn-aksi-success {
        background: rgba(22,163,74,0.1);
        border: 1.5px solid rgba(22,163,74,0.22);
        color: var(--success);
    }
    .btn-aksi-success:hover { background: var(--success); color: white; border-color: var(--success); }

    .btn-aksi-danger {
        background: rgba(229,62,62,0.1);
        border: 1.5px solid rgba(229,62,62,0.22);
        color: var(--danger);
    }
    .btn-aksi-danger:hover { background: var(--danger); color: white; border-color: var(--danger); }

    .btn-aksi-warning {
        background: rgba(217,119,6,0.1);
        border: 1.5px solid rgba(217,119,6,0.22);
        color: var(--warning);
    }
    .btn-aksi-warning:hover { background: var(--warning); color: white; border-color: var(--warning); }

    .btn-aksi-primary {
        background: var(--primary);
        border: 1.5px solid var(--primary);
        color: white;
        box-shadow: 0 4px 14px rgba(27,58,82,0.15);
    }
    .btn-aksi-primary:hover { background: var(--primary-light); border-color: var(--primary-light); transform: translateY(-1px); }

    .btn-aksi-secondary {
        background: white;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
    }
    .btn-aksi-secondary:hover { background: #f1f5f9; }

    .btn-aksi-outline-danger {
        background: transparent;
        border: 1.5px solid rgba(229,62,62,0.3);
        color: var(--danger);
    }
    .btn-aksi-outline-danger:hover { background: rgba(229,62,62,0.06); border-color: var(--danger); }

    .status-done-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 9px;
        padding: 0.75rem;
        text-align: center;
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 600;
    }

    .aksi-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 0.25rem 0;
    }

    /* ─── MODAL ─── */
    .modal-content {
        border: none;
        border-radius: var(--radius);
        box-shadow: 0 24px 60px rgba(0,0,0,0.2);
        overflow: hidden;
    }

    .modal-header-danger {
        background: var(--danger);
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-danger h6 {
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-content {
        padding: 1.75rem 1.5rem 1.25rem;
        text-align: center;
    }

    .modal-danger-icon {
        width: 68px; height: 68px;
        border-radius: 50%;
        background: rgba(229,62,62,0.1);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.75rem;
        color: var(--danger);
    }

    .modal-body-content h6 { font-weight: 800; color: var(--primary); margin-bottom: 4px; }
    .modal-body-content .alumni-target { color: #64748b; font-size: 0.9rem; margin-bottom: 1rem; }

    .delete-list {
        background: #fef2f2;
        border: 1px solid rgba(229,62,62,0.15);
        border-radius: 10px;
        padding: 0.9rem 1.1rem;
        text-align: left;
    }

    .delete-list-title {
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--danger);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .delete-list ul {
        margin: 0; padding-left: 1.2rem;
        font-size: 0.81rem;
        color: #7f1d1d;
    }

    .delete-list ul li { margin-bottom: 3px; }

    .delete-warning {
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--danger);
        margin-top: 0.65rem;
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
    }

    .modal-footer-content {
        padding: 1rem 1.5rem;
        display: flex;
        gap: 0.65rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-modal-cancel {
        flex: 1;
        padding: 0.65rem;
        background: #f1f5f9;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        color: #64748b;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-modal-cancel:hover { background: #e2e8f0; }

    .btn-modal-confirm {
        flex: 1;
        padding: 0.65rem;
        background: var(--danger);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(229,62,62,0.28);
    }

    .btn-modal-confirm:hover { background: #c53030; transform: translateY(-1px); }
</style>

<div class="row g-4">

    {{-- ── LEFT: DATA ── --}}
    <div class="col-lg-8">

        {{-- Data Pribadi --}}
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-person-vcard-fill"></i> Data Pribadi
                </div>
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

                <div class="bio-divider" style="margin:0.5rem 0;"></div>

                <div class="bio-row">
                    <span class="bio-label">Alamat</span>
                    <span class="bio-value {{ !$alumni->alamat ? 'muted' : 'normal' }}">{{ $alumni->alamat ?? '-' }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">No. HP / WA</span>
                    <span class="bio-value normal">
                        {{ \App\Helpers\FormatHelper::phone($alumni->no_hp) }}
                        @if($alumni->no_hp && $alumni->show_no_hp)
                            <span class="public-chip"><i class="bi bi-eye-fill"></i> Publik</span>
                        @endif
                    </span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Email</span>
                    <span class="bio-value normal">{{ $alumni->email ?? ($alumni->user->email ?? '-') }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Harapan &amp; Pesan</span>
                    <span class="bio-value fw-normal fst-italic" style="color:#475569;">
                        {{ $alumni->harapan ? '"'.$alumni->harapan.'"' : '-' }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Riwayat Pendidikan --}}
        @if($alumni->pendidikan->count() > 0)
            <div class="card-section">
                <div class="card-section-header">
                    <div class="card-section-title">
                        <i class="bi bi-mortarboard-fill"></i> Riwayat Pendidikan
                    </div>
                </div>
                <div class="card-section-body">
                    @foreach($alumni->pendidikan as $edu)
                        <div class="timeline-item">
                            <div class="timeline-icon icon-edu"><i class="bi bi-mortarboard-fill"></i></div>
                            <div class="timeline-content">
                                <h6>{{ $edu->jenjang }}: {{ $edu->nama_instansi }}</h6>
                                @if($edu->program_studi && $edu->jenjang === 'Perguruan Tinggi')
                                    <p>Prodi: {{ $edu->program_studi }}</p>
                                @endif
                                <p style="margin-bottom:5px;">
                                    <i class="bi bi-calendar3" style="font-size:0.72rem;"></i>
                                    @if($edu->is_ongoing)
                                        Masuk {{ $edu->tahun_masuk ?? '-' }}
                                    @else
                                        {{ $edu->tahun_masuk ?? '-' }} — {{ $edu->tahun_lulus ?? '-' }}
                                    @endif
                                </p>
                                @if($edu->is_ongoing)
                                    <span class="tag tag-ongoing"><i class="bi bi-hourglass-split"></i> Aktif</span>
                                @else
                                    <span class="tag tag-done"><i class="bi bi-check-circle"></i> Lulus</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Riwayat Pekerjaan --}}
        @if($alumni->pekerjaan->count() > 0)
            <div class="card-section">
                <div class="card-section-header">
                    <div class="card-section-title">
                        <i class="bi bi-briefcase-fill"></i> Riwayat Pekerjaan
                    </div>
                </div>
                <div class="card-section-body">
                    @foreach($alumni->pekerjaan as $job)
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $job->is_current ? 'icon-work-current' : 'icon-work' }}">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>{{ $job->nama_perusahaan }}</h6>
                                <p>{{ $job->jabatan }}</p>
                                @if($job->is_current)
                                    <span class="tag tag-current"><i class="bi bi-star-fill"></i> Sekarang</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Informasi Akun --}}
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-shield-lock-fill"></i> Informasi Akun
                </div>
            </div>
            <div class="card-section-body">

                <div class="bio-row">
                    <span class="bio-label">Username</span>
                    <span class="bio-value">{{ $alumni->user->username ?? '-' }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Role</span>
                    <span class="bio-value">
                        <span class="bio-angkatan-tag">{{ $alumni->user->role ?? '-' }}</span>
                    </span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Status Akun</span>
                    <span class="bio-value">
                        @if($alumni->user->is_active)
                            <span class="status-pill pill-active"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                        @else
                            <span class="status-pill pill-inactive"><i class="bi bi-x-circle-fill"></i> Non-aktif</span>
                        @endif
                    </span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Terdaftar</span>
                    <span class="bio-value normal">{{ $alumni->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="bio-row">
                    <span class="bio-label">Update Terakhir</span>
                    <span class="bio-value normal">{{ $alumni->updated_at->format('d M Y H:i') }}</span>
                </div>
                @if($alumni->user->last_login_at)
                    <div class="bio-row">
                        <span class="bio-label">Login Terakhir</span>
                        <span class="bio-value normal">{{ $alumni->user->last_login_at->format('d M Y H:i') }}</span>
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- ── RIGHT: SIDEBAR ── --}}
    <div class="col-lg-4">

        {{-- Foto Profil --}}
        <div class="foto-card">
            <div class="foto-card-header">
                <i class="bi bi-image-fill"></i> Foto Profil
            </div>
            <div class="foto-card-body">
                @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp
                <div class="foto-wrap">
                    @if($fotoUtama)
                        <img src="{{ asset('storage/' . $fotoUtama->path_file) }}"
                             alt="Foto Profil {{ $alumni->nama_lengkap }}">
                    @else
                        <div class="foto-empty">
                            <i class="bi bi-person-bounding-box"></i>
                            <p>Belum ada foto profil</p>
                        </div>
                    @endif
                </div>
                @if($fotoUtama)
                    <div class="foto-meta">
                        <i class="bi bi-calendar3"></i> {{ $fotoUtama->created_at->format('d M Y') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Status --}}
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-info-circle-fill"></i> Status Alumni
                </div>
            </div>
            <div class="card-section-body">

                <div class="mb-3">
                    <span class="status-sublabel">Verifikasi</span>
                    @if($alumni->status_verifikasi === 'verified')
                        <span class="status-pill pill-verified"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
                    @elseif($alumni->status_verifikasi === 'pending')
                        <span class="status-pill pill-pending"><i class="bi bi-clock-fill"></i> Menunggu Verifikasi</span>
                    @else
                        <span class="status-pill pill-rejected"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                    @endif
                </div>

                <div>
                    <span class="status-sublabel">Kelengkapan Profil</span>
                    @if($alumni->is_profile_complete)
                        <span class="status-pill pill-complete"><i class="bi bi-check-all"></i> Lengkap</span>
                    @else
                        <span class="status-pill pill-incomplete"><i class="bi bi-exclamation-circle-fill"></i> Belum Lengkap</span>
                    @endif
                </div>

                <div class="status-info-box">
                    @if($alumni->status_verifikasi === 'pending')
                        <strong>Pending:</strong> Menunggu keputusan admin.
                    @elseif($alumni->status_verifikasi === 'verified')
                        <strong>Terverifikasi:</strong> Alumni aktif dan dapat login.
                    @else
                        <strong>Ditolak:</strong> Alumni tidak dapat mengakses akun.
                    @endif
                </div>

            </div>
        </div>

        {{-- Aksi --}}
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-gear-fill"></i> Aksi
                </div>
            </div>
            <div class="card-section-body">
                <div class="aksi-section">

                    @if($alumni->status_verifikasi === 'pending')
                        <form action="{{ route('admin.alumni.verify', $alumni) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="verified">
                            <button type="submit" class="btn-aksi btn-aksi-success"
                                    onclick="return confirm('Verifikasi alumni ini?')">
                                <i class="bi bi-check-circle-fill"></i> Setujui Alumni
                            </button>
                        </form>

                        <form action="{{ route('admin.alumni.verify', $alumni) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn-aksi btn-aksi-danger"
                                    onclick="return confirm('Tolak alumni ini?')">
                                <i class="bi bi-x-circle-fill"></i> Tolak Alumni
                            </button>
                        </form>
                    @else
                        <div class="status-done-box">
                            <i class="bi bi-info-circle me-1"></i>
                            @if($alumni->status_verifikasi === 'verified')
                                Alumni sudah diverifikasi
                            @else
                                Alumni sudah ditolak
                            @endif
                        </div>
                    @endif

                    <div class="aksi-divider"></div>

                    <form action="{{ route('admin.alumni.resetPassword', $alumni) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-aksi btn-aksi-warning"
                                onclick="return confirm('Reset password ke NISN?')">
                            <i class="bi bi-key-fill"></i> Reset Password
                        </button>
                    </form>

                    <a href="{{ route('admin.alumni.edit', $alumni) }}" class="btn-aksi btn-aksi-primary">
                        <i class="bi bi-pencil-fill"></i> Edit Data
                    </a>

                    <button type="button" class="btn-aksi btn-aksi-outline-danger"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash3-fill"></i> Hapus Alumni
                    </button>

                    <div class="aksi-divider"></div>

                    <a href="{{ route('admin.alumni.index') }}" class="btn-aksi btn-aksi-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── MODAL HAPUS ── --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header-danger">
                <h6><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-content">
                <div class="modal-danger-icon">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h6>Hapus data alumni ini?</h6>
                <p class="alumni-target">{{ $alumni->nama_lengkap }}</p>

                <div class="delete-list">
                    <div class="delete-list-title">
                        <i class="bi bi-exclamation-circle-fill"></i> Data yang akan dihapus:
                    </div>
                    <ul>
                        <li>Data profil &amp; akun alumni</li>
                        <li>Riwayat pendidikan</li>
                        <li>Riwayat pekerjaan</li>
                        <li>Foto profil</li>
                    </ul>
                </div>
                <div class="delete-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Tindakan ini TIDAK DAPAT dibatalkan!
                </div>
            </div>
            <div class="modal-footer-content">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <form action="{{ route('admin.alumni.destroy', $alumni) }}" method="POST" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modal-confirm" style="width:100%;">
                        <i class="bi bi-trash3 me-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
