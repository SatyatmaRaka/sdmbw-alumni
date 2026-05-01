@extends('layouts.admin')

@section('title', 'Tambah Angkatan')
@section('page-title', 'Tambah Angkatan Baru')

@section('content')
@push('styles')
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
        padding: 0.95rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 9px;
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
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.83rem;
    }

    .card-section-title i { opacity: 0.8; }
    .card-section-body { padding: 1.75rem; }

    /* ─── FORM ─── */
    .form-group { margin-bottom: 1.4rem; }

    .form-label-custom {
        display: block;
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.45rem;
    }

    .form-label-custom .req { color: var(--danger); margin-left: 2px; }

    .form-input {
        width: 100%;
        padding: 0.72rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 0.9rem;
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

    .form-input[readonly] {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
        border-style: dashed;
    }

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

    .form-hint {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 5px;
        display: flex;
        align-items: flex-start;
        gap: 5px;
        line-height: 1.5;
    }

    .form-hint i { font-size: 0.72rem; margin-top: 2px; flex-shrink: 0; }

    /* auto-generated badge */
    .auto-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.65rem;
        border-radius: 5px;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        font-size: 0.72rem;
        font-weight: 700;
        margin-left: 6px;
    }

    .form-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 1.5rem 0;
    }

    /* ─── ACTIONS ─── */
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

    /* ─── SIDEBAR GUIDE ─── */
    .guide-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        border-left: 4px solid var(--info);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .guide-card-header {
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

    .guide-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .guide-card-header i { opacity: 0.8; }

    .guide-card-body { padding: 1.1rem 1.25rem; }

    .guide-list {
        list-style: none;
        padding: 0; margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .guide-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.81rem;
        color: #475569;
        line-height: 1.55;
    }

    .guide-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        font-size: 0.65rem;
        font-weight: 800;
        flex-shrink: 0;
        margin-top: 1px;
    }
</style>
@endpush

<div class="row g-4">

    {{-- ── FORM ── --}}
    <div class="col-lg-8">
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-plus-circle-fill"></i> Form Tambah Angkatan
                </div>
            </div>
            <div class="card-section-body">

                <form action="{{ route('admin.angkatan.store') }}" method="POST">
                    @csrf

                    {{-- Nama Angkatan (readonly, auto-generated) --}}
                    <div class="form-group">
                        <label for="nama_angkatan" class="form-label-custom">
                            Nama Angkatan <span class="req">*</span>
                            <span class="auto-tag"><i class="bi bi-magic"></i> Otomatis</span>
                        </label>
                        <input type="text"
                                id="nama_angkatan"
                                name="nama_angkatan"
                                class="form-input @error('nama_angkatan') is-invalid @enderror"
                                value="{{ old('nama_angkatan', 'Angkatan ' . $nextNumber) }}"
                                placeholder="Angkatan {{ $nextNumber }}"
                                readonly
                                required>
                        @error('nama_angkatan')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Nama angkatan dihasilkan otomatis oleh sistem: <strong>Angkatan {{ $nextNumber }}</strong>
                        </div>
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="form-group">
                        <label for="tahun_ajaran" class="form-label-custom">
                            Tahun Ajaran <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="tahun_ajaran"
                               name="tahun_ajaran"
                               class="form-input @error('tahun_ajaran') is-invalid @enderror"
                               value="{{ old('tahun_ajaran') }}"
                               placeholder="Contoh: 2026-2027"
                               required>
                        @error('tahun_ajaran')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Format yang disarankan: <strong>YYYY-YYYY</strong> (contoh: 2026-2027)
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label for="status" class="form-label-custom">
                            Status <span class="req">*</span>
                        </label>
                        <select id="status"
                                name="status"
                                class="form-input @error('status') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Status --</option>
                            <option value="AKTIF" {{ old('status') === 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                            <option value="LULUS" {{ old('status') === 'LULUS' ? 'selected' : '' }}>LULUS</option>
                        </select>
                        @error('status')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Pilih <strong>AKTIF</strong> untuk angkatan yang masih sekolah, atau <strong>LULUS</strong> untuk yang sudah tamat.
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-actions">
                        <a href="{{ route('admin.angkatan.index') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-floppy-fill"></i> Simpan Angkatan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- ── SIDEBAR ── --}}
    <div class="col-lg-4">
        <div class="guide-card">
            <div class="guide-card-header">
                <i class="bi bi-lightbulb-fill"></i> Panduan Pengisian
            </div>
            <div class="guide-card-body">
                <ul class="guide-list">
                    <li>
                        <span class="guide-num">1</span>
                        Sistem menetapkan <strong>Nama Angkatan</strong> secara berurutan untuk menjaga konsistensi data.
                    </li>
                    <li>
                        <span class="guide-num">2</span>
                        Pastikan <strong>Tahun Ajaran</strong> diinput dengan benar untuk keperluan filter laporan nantinya.
                    </li>
                    <li>
                        <span class="guide-num">3</span>
                        Hanya angkatan dengan status <strong>LULUS</strong> yang dapat mengakses fitur Tracer Study secara penuh.
                    </li>
                    <li>
                        <span class="guide-num">4</span>
                        Status angkatan dapat diperbarui kapan saja melalui menu edit setelah siswa dinyatakan lulus.
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
