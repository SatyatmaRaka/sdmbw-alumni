@extends('layouts.admin')

@section('title', 'Reset Password Alumni')
@section('page-title', 'Reset Password Alumni by NISN')

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
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

    .card-header-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.15rem;
        color: white;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .card-header-title i { font-size: 1rem; opacity: 0.8; font-family: inherit; }

    .card-header-sub {
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
        margin-bottom: 1.4rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .error-alert i { color: var(--danger); font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
    .error-alert strong { color: #7f1d1d; font-size: 0.85rem; display: block; margin-bottom: 5px; }

    .error-list {
        list-style: none;
        padding: 0; margin: 0;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .error-list li {
        font-size: 0.81rem;
        color: #991b1b;
        display: flex;
        align-items: flex-start;
        gap: 5px;
    }

    .error-list li::before {
        content: '•';
        color: var(--danger);
        flex-shrink: 0;
        font-weight: 800;
    }

    /* ─── FORM ─── */
    .form-group { margin-bottom: 1.35rem; }

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

    /* input wrap (icon prefix) */
    .input-wrap {
        display: flex;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
        transition: var(--transition);
    }

    .input-wrap:focus-within {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
    }

    .input-wrap.is-invalid {
        border-color: var(--danger);
        background: #fff5f5;
    }

    .input-wrap.is-invalid:focus-within {
        box-shadow: 0 0 0 3px rgba(229,62,62,0.1);
    }

    .input-icon {
        display: flex;
        align-items: center;
        padding: 0 13px;
        color: #94a3b8;
        font-size: 0.9rem;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .input-wrap:focus-within .input-icon { color: var(--primary); }

    .input-field {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        padding: 0.72rem 0.5rem;
        font-size: 0.9rem;
        color: var(--primary);
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        min-width: 0;
        width: 100%;
    }

    .input-field::placeholder { color: #b0bec5; }

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
        font-size: 0.77rem;
        color: #94a3b8;
        margin-top: 5px;
        display: flex;
        align-items: flex-start;
        gap: 5px;
        line-height: 1.5;
    }

    .form-hint i { font-size: 0.7rem; margin-top: 2px; flex-shrink: 0; }

    /* ─── INFO BOX ─── */
    .info-box {
        background: rgba(8,145,178,0.05);
        border: 1px solid rgba(8,145,178,0.18);
        border-left: 3px solid var(--info);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.83rem;
        color: #164e63;
        margin-bottom: 1.4rem;
        display: flex;
        align-items: flex-start;
        gap: 9px;
    }

    .info-box i { color: var(--info); flex-shrink: 0; margin-top: 1px; }

    /* ─── FORM DIVIDER ─── */
    .form-divider { height: 1px; background: #f1f5f9; margin: 1.4rem 0; }

    /* ─── BUTTONS ─── */
    .btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.75rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(27,58,82,0.18);
        margin-bottom: 0.5rem;
    }

    .btn-submit:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,58,82,0.22);
    }

    .btn-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 0.72rem;
        background: white;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-back:hover { background: #f1f5f9; color: var(--primary); border-color: #cbd5e1; }

    /* ─── HELP CARD ─── */
    .help-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .help-card-header {
        background: var(--primary);
        padding: 0.85rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.82rem;
        position: relative;
    }

    .help-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .help-card-header i { opacity: 0.8; }
    .help-card-body { padding: 1.25rem 1.5rem; }

    .help-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.85rem;
    }

    .help-steps {
        list-style: none;
        padding: 0; margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .help-step {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.82rem;
        color: #475569;
        line-height: 1.5;
    }

    .step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px; height: 22px;
        border-radius: 50%;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.3);
        color: #7a5c1e;
        font-size: 0.68rem;
        font-weight: 800;
        flex-shrink: 0;
        margin-top: 1px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        {{-- ── FORM CARD ── --}}
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-header-title">
                    <i class="bi bi-key-fill"></i> Reset Password Alumni
                </div>
                <p class="card-header-sub">Cari alumni berdasarkan NISN dan reset password mereka</p>
            </div>
            <div class="card-section-body">

                {{-- Error Alert --}}
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

                <form action="{{ route('admin.alumni.resetPasswordByNisn') }}" method="POST">
                    @csrf

                    {{-- NISN --}}
                    <div class="form-group">
                        <label class="form-label-custom">
                            NISN Alumni <span class="req">*</span>
                        </label>
                        <div class="input-wrap @error('nisn') is-invalid @enderror">
                            <span class="input-icon"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   class="input-field"
                                   name="nisn"
                                   placeholder="Contoh: 0051069834"
                                   value="{{ old('nisn') }}"
                                   required>
                        </div>
                        @error('nisn')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Masukkan NISN alumni yang password-nya ingin direset
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="form-group">
                        <label class="form-label-custom">
                            Password Baru <span class="req">*</span>
                        </label>
                        <div class="input-wrap @error('password') is-invalid @enderror">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password"
                                   class="input-field"
                                   name="password"
                                   placeholder="Minimal 6 karakter"
                                   required>
                        </div>
                        @error('password')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Password minimal 6 karakter
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="form-group">
                        <label class="form-label-custom">
                            Konfirmasi Password <span class="req">*</span>
                        </label>
                        <div class="input-wrap @error('password_confirmation') is-invalid @enderror">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password"
                                   class="input-field"
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   required>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info Box --}}
                    <div class="info-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <span><strong>Catatan:</strong> Password akan langsung berubah setelah form ini disubmit. Alumni dapat login dengan password baru ini.</span>
                    </div>

                    <div class="form-divider"></div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle-fill"></i> Reset Password
                    </button>
                    <a href="{{ route('admin.alumni.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                </form>
            </div>
        </div>

        {{-- ── HELP CARD ── --}}
        <div class="help-card">
            <div class="help-card-header">
                <i class="bi bi-question-circle-fill"></i> Panduan Penggunaan
            </div>
            <div class="help-card-body">
                <p class="help-title">Bagaimana cara menggunakan fitur ini?</p>
                <ol class="help-steps">
                    <li class="help-step">
                        <span class="step-num">1</span>
                        Masukkan NISN alumni yang ingin direset passwordnya
                    </li>
                    <li class="help-step">
                        <span class="step-num">2</span>
                        Masukkan password baru (minimal 6 karakter)
                    </li>
                    <li class="help-step">
                        <span class="step-num">3</span>
                        Konfirmasi password yang sama persis
                    </li>
                    <li class="help-step">
                        <span class="step-num">4</span>
                        Klik tombol <strong>Reset Password</strong> untuk menyimpan
                    </li>
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
