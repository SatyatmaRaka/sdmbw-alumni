@extends('layouts.admin')

@section('title', 'Edit Alumni')
@section('page-title', 'Edit Data Alumni')

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
        padding: 1rem 1.5rem;
        position: relative;
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .header-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.15rem;
        color: white;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .header-sub {
        font-size: 0.77rem;
        color: rgba(255,255,255,0.45);
        font-weight: 500;
        margin: 0;
    }

    .card-section-body { padding: 1.75rem; }

    /* ─── ERROR ALERT ─── */
    .error-alert {
        background: #fef2f2;
        border: 1px solid rgba(229,62,62,0.2);
        border-left: 4px solid var(--danger);
        border-radius: 10px;
        padding: 0.9rem 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .error-alert i { color: var(--danger); flex-shrink: 0; margin-top: 2px; }
    .error-alert strong { color: #7f1d1d; font-size: 0.85rem; display: block; margin-bottom: 5px; }
    .error-list { list-style: none; padding: 0; margin: 0; }
    .error-list li { font-size: 0.81rem; color: #991b1b; display: flex; align-items: flex-start; gap: 5px; margin-bottom: 3px; }
    .error-list li::before { content: '•'; color: var(--danger); font-weight: 800; flex-shrink: 0; }

    /* ─── SECTION DIVIDER ─── */
    .section-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .section-label-text {
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #94a3b8;
        white-space: nowrap;
    }

    .section-label-line {
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .section-label-icon {
        font-size: 0.75rem;
        color: var(--accent);
        opacity: 0.8;
    }

    /* ─── FORM ─── */
    .form-group { margin-bottom: 1.2rem; }

    .form-label-custom {
        display: block;
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.42rem;
    }

    .form-label-custom .req { color: var(--danger); margin-left: 2px; }

    .form-input {
        width: 100%;
        padding: 0.68rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 0.875rem;
        color: var(--primary);
        background: #f8fafc;
        transition: var(--transition);
        appearance: none;
    }

    .form-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
        outline: none;
    }

    .form-input::placeholder { color: #b0bec5; }

    textarea.form-input { resize: vertical; min-height: 80px; }

    .form-input.is-invalid {
        border-color: var(--danger);
        background: #fff5f5;
    }

    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(229,62,62,0.1);
    }

    .invalid-msg {
        font-size: 0.78rem;
        color: var(--danger);
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-section-gap { height: 1.5rem; }
    .form-divider { height: 1px; background: #f1f5f9; margin: 1.5rem 0; }

    /* ─── BUTTONS ─── */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.25rem;
        background: white;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-back:hover { background: #f1f5f9; color: var(--primary); border-color: #cbd5e1; }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.65rem 1.5rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(27,58,82,0.18);
    }

    .btn-submit:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
    }

    /* ─── SIDEBAR INFO CARD ─── */
    .info-sidebar-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .info-sidebar-header {
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

    .info-sidebar-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .info-sidebar-header i { opacity: 0.8; }
    .info-sidebar-body { padding: 1.1rem 1.25rem; }

    .info-row {
        display: flex;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f8fafc;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row:first-child { padding-top: 0; }

    .info-row-label {
        font-size: 0.67rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        min-width: 95px;
        width: 95px;
        flex-shrink: 0;
        padding-top: 1px;
    }

    .info-row-value {
        font-size: 0.83rem;
        font-weight: 700;
        color: var(--primary);
        flex: 1;
        min-width: 0;
        word-break: break-word;
    }

    .nisn-mono {
        font-family: 'Courier New', monospace;
        font-size: 0.82rem;
        background: #f1f5f9;
        padding: 2px 7px;
        border-radius: 5px;
        display: inline-block;
    }

    .v-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.55rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .v-verified  { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .v-pending   { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .v-rejected  { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }
    .v-complete  { background: var(--accent-soft);   border: 1px solid rgba(232,200,122,0.3);  color: #7a5c1e; }
    .v-incomplete{ background: #f1f5f9;              border: 1px solid #e2e8f0;                color: #64748b; }

    /* ─── NOTE ALERT ─── */
    .note-alert {
        background: rgba(8,145,178,0.04);
        border: 1px solid rgba(8,145,178,0.15);
        border-left: 3px solid var(--info);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.82rem;
        color: #164e63;
        display: flex;
        align-items: flex-start;
        gap: 9px;
    }

    .note-alert i { color: var(--info); flex-shrink: 0; margin-top: 1px; }
</style>

<div class="row g-4">

    {{-- ── FORM ── --}}
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <div class="header-title">
                    <i class="bi bi-pencil-fill" style="font-family:inherit; font-size:0.95rem;"></i>
                    Edit Data Alumni
                </div>
                <p class="header-sub">Update informasi lengkap alumni</p>
            </div>
            <div class="card-section-body">

                @if($errors->any())
                    <div class="error-alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Terjadi Kesalahan!</strong>
                            <ul class="error-list">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.alumni.update', $alumni) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ── DATA IDENTITAS ── --}}
                    <div class="section-label">
                        <i class="bi bi-person-badge-fill section-label-icon"></i>
                        <span class="section-label-text">Data Identitas</span>
                        <div class="section-label-line"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">NISN <span class="req">*</span></label>
                                <input type="text"
                                       name="nisn"
                                       class="form-input @error('nisn') is-invalid @enderror"
                                       value="{{ old('nisn', $alumni->nisn) }}"
                                       required>
                                @error('nisn')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">Nama Lengkap <span class="req">*</span></label>
                                <input type="text"
                                       name="nama_lengkap"
                                       class="form-input @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap', $alumni->nama_lengkap) }}"
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">Angkatan <span class="req">*</span></label>
                                <select name="angkatan_id"
                                        class="form-input @error('angkatan_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Angkatan --</option>
                                    @foreach($angkatans as $angkatan)
                                        <option value="{{ $angkatan->id }}"
                                                {{ old('angkatan_id', $alumni->angkatan_id) == $angkatan->id ? 'selected' : '' }}>
                                            {{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('angkatan_id')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">Tahun Lulus <span class="req">*</span></label>
                                <input type="number"
                                       name="tahun_lulus"
                                       class="form-input @error('tahun_lulus') is-invalid @enderror"
                                       value="{{ old('tahun_lulus', $alumni->tahun_lulus) }}"
                                       min="1950"
                                       max="{{ date('Y') }}"
                                       required>
                                @error('tahun_lulus')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section-gap"></div>

                    {{-- ── DATA KONTAK ── --}}
                    <div class="section-label">
                        <i class="bi bi-telephone-fill section-label-icon"></i>
                        <span class="section-label-text">Data Kontak</span>
                        <div class="section-label-line"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Alamat</label>
                        <textarea name="alamat"
                                  class="form-input @error('alamat') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $alumni->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">No. HP / WhatsApp</label>
                                <input type="text"
                                       name="no_hp"
                                       class="form-input @error('no_hp') is-invalid @enderror"
                                       value="{{ old('no_hp', $alumni->no_hp) }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('no_hp')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $alumni->email) }}"
                                       placeholder="email@example.com">
                                @error('email')
                                    <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section-gap"></div>

                    {{-- ── PESAN & HARAPAN ── --}}
                    <div class="section-label">
                        <i class="bi bi-chat-left-text-fill section-label-icon"></i>
                        <span class="section-label-text">Pesan &amp; Harapan</span>
                        <div class="section-label-line"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Pesan Alumni &amp; Harapan Untuk Sekolah</label>
                        <textarea name="harapan"
                                  class="form-input @error('harapan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Tuliskan harapan atau pesan untuk sekolah">{{ old('harapan', $alumni->harapan) }}</textarea>
                        @error('harapan')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-actions">
                        <a href="{{ route('admin.alumni.show', $alumni) }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-floppy-fill"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ── SIDEBAR ── --}}
    <div class="col-lg-4">

        {{-- Info Card --}}
        <div class="info-sidebar-card">
            <div class="info-sidebar-header">
                <i class="bi bi-person-vcard-fill"></i> Informasi Alumni
            </div>
            <div class="info-sidebar-body">
                <div class="info-row">
                    <span class="info-row-label">Nama</span>
                    <span class="info-row-value">{{ $alumni->nama_lengkap }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">NISN</span>
                    <span class="info-row-value">
                        <span class="nisn-mono">{{ $alumni->nisn }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Verifikasi</span>
                    <span class="info-row-value">
                        @if($alumni->status_verifikasi === 'verified')
                            <span class="v-pill v-verified"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
                        @elseif($alumni->status_verifikasi === 'pending')
                            <span class="v-pill v-pending"><i class="bi bi-clock-fill"></i> Pending</span>
                        @else
                            <span class="v-pill v-rejected"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Profil</span>
                    <span class="info-row-value">
                        @if($alumni->is_profile_complete)
                            <span class="v-pill v-complete"><i class="bi bi-check-all"></i> Lengkap</span>
                        @else
                            <span class="v-pill v-incomplete"><i class="bi bi-exclamation-circle-fill"></i> Belum</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Note --}}
        <div class="note-alert">
            <i class="bi bi-info-circle-fill"></i>
            <span><strong>Catatan:</strong> Form ini hanya untuk data dasar. Data pendidikan dan pekerjaan diupdate oleh alumni melalui profil mereka.</span>
        </div>

    </div>
</div>
@endsection
