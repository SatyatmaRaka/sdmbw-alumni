<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Alumni SDMBW" />
    <link rel="manifest" href="/site.webmanifest" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi Alumni - Sistem Alumni SDMBW</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" crossorigin="anonymous">

    <style>
        :root {
            --primary:      #1B3A52;
            --primary-light:#2a5378;
            --primary-dark: #112534;
            --accent:       #E8C87A;
            --accent-hover: #d9b75e;
            --bg-from:      #1B3A52;
            --bg-to:        #2a5378;
            --radius:       14px;
            --transition:   all 0.26s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding: 56px 0;
            display: flex;
            align-items: center;
            background: var(--primary-dark);
            position: relative;
            overflow-x: hidden;
        }

        /* background mesh */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(42,83,120,0.7) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 80%, rgba(232,200,122,0.08) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* dot grid */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
            z-index: 0;
        }

        .container { position: relative; z-index: 1; }

        /* ─────────────────────────────────────────
           CARD
        ───────────────────────────────────────── */
        .register-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.35);
            overflow: hidden;
            max-width: 620px;
            margin: 0 auto;
            border: none;
        }

        /* ─────────────────────────────────────────
           HEADER
        ───────────────────────────────────────── */
        .register-header {
            background: var(--primary-dark);
            padding: 2.75rem 2rem 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* header dot grid */
        .register-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
        }

        /* header glow */
        .register-header::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(42,83,120,0.6) 0%, transparent 70%);
            pointer-events: none;
        }

        /* accent bottom stripe */
        .header-stripe {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--accent), transparent);
        }

        .btn-back-home {
            position: absolute;
            top: 1.25rem; left: 1.25rem;
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.7);
            padding: 6px 14px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 1px solid rgba(255,255,255,0.12);
            z-index: 1;
            position: absolute;
        }

        .btn-back-home:hover {
            background: rgba(255,255,255,0.13);
            color: white;
            border-color: rgba(255,255,255,0.25);
        }

        .header-icon-wrap {
            width: 64px; height: 64px;
            background: rgba(232,200,122,0.12);
            border: 1px solid rgba(232,200,122,0.25);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.1rem;
            position: relative; z-index: 1;
        }

        .header-icon-wrap i { font-size: 1.75rem; color: var(--accent); }

        .register-header h1 {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
            font-size: 1.6rem;
            color: white;
            margin: 0 0 6px;
            letter-spacing: 0.2px;
            position: relative; z-index: 1;
        }

        .register-header p {
            margin: 0;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            position: relative; z-index: 1;
        }

        /* ─────────────────────────────────────────
           BODY
        ───────────────────────────────────────── */
        .register-body { padding: 2.5rem 2.75rem; }

        /* ─────────────────────────────────────────
           SECTION TITLES
        ───────────────────────────────────────── */
        .section-title {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            font-weight: 700;
            color: var(--accent);
            margin: 2rem 0 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title:first-child { margin-top: 0; }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ─────────────────────────────────────────
           FORM ELEMENTS
        ───────────────────────────────────────── */
        .form-label {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.82rem;
            margin-bottom: 7px;
            letter-spacing: 0.1px;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #94a3b8;
            border-radius: var(--radius) 0 0 var(--radius);
            padding: 0 14px;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            padding: 11px 15px;
            border-radius: var(--radius);
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: var(--transition);
            background: #f8fafc;
            color: var(--primary);
        }

        .form-control::placeholder { color: #b0bec5; }

        .input-group .form-control {
            border-radius: 0;
            border-left: none;
        }

        .input-group .form-control.no-toggle {
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
            outline: none;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .input-group:focus-within .btn-toggle-password {
            border-color: var(--primary);
            background: white;
        }

        /* ─────────────────────────────────────────
           TOGGLE PASSWORD
        ───────────────────────────────────────── */
        .btn-toggle-password {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 var(--radius) var(--radius) 0;
            color: #94a3b8;
            padding: 11px 13px;
            cursor: pointer;
            transition: var(--transition);
            line-height: 1;
        }

        .btn-toggle-password:hover { color: var(--primary); }

        /* ─────────────────────────────────────────
           INFO BOX
        ───────────────────────────────────────── */
        .info-box {
            background: rgba(27,58,82,0.04);
            border: 1px solid rgba(27,58,82,0.1);
            border-left: 3px solid var(--primary);
            padding: 1rem 1.25rem;
            border-radius: var(--radius);
            margin: 1.75rem 0;
        }

        .info-box i { color: var(--primary); opacity: 0.65; }

        /* ─────────────────────────────────────────
           SUBMIT BUTTON
        ───────────────────────────────────────── */
        .btn-register {
            background: var(--primary);
            border: none;
            color: white;
            padding: 14px;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.92rem;
            border-radius: var(--radius);
            margin-top: 0.25rem;
            transition: var(--transition);
            letter-spacing: 0.4px;
            box-shadow: 0 4px 16px rgba(27,58,82,0.2);
        }

        .btn-register:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(27,58,82,0.28);
            color: white;
        }

        /* ─────────────────────────────────────────
           MISC
        ───────────────────────────────────────── */
        .required { color: #e53e3e; }

        .form-text {
            font-size: 0.73rem;
            color: #94a3b8;
            margin-top: 5px;
        }

        .alert {
            border-radius: var(--radius);
            border: none;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            border-left: 4px solid transparent;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left-color: #ef4444;
        }

        .login-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1.5px solid var(--accent);
            transition: var(--transition);
            padding-bottom: 1px;
        }

        .login-link:hover {
            color: var(--primary-light);
            border-color: var(--primary-light);
        }

        /* ─────────────────────────────────────────
           RESPONSIVE
        ───────────────────────────────────────── */
        @media (max-width: 576px) {
            body { padding: 24px 0; }
            .register-body { padding: 1.75rem 1.5rem; }
            .register-header { padding: 2.25rem 1.5rem 2rem; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="register-card">

        {{-- ── HEADER ─────────────────────────────── --}}
        <header class="register-header">
            <a href="{{ route('landing.index') }}" class="btn-back-home">
                <i class="bi bi-arrow-left"></i> Beranda
            </a>

            <div class="header-icon-wrap">
                <i class="bi bi-person-badge-fill"></i>
            </div>

            <h1>Registrasi Alumni</h1>
            <p>SD Muhammadiyah Birrul Walidain Kudus</p>

            <div class="header-stripe"></div>
        </header>

        {{-- ── BODY ───────────────────────────────── --}}
        <div class="register-body">

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                        <strong>Mohon periksa kembali:</strong>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Data Pribadi --}}
                <div class="section-title">Data Pribadi</div>

                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN <span class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                        <input type="text"
                               class="form-control no-toggle @error('nisn') is-invalid @enderror"
                               id="nisn" name="nisn"
                               value="{{ old('nisn') }}"
                               placeholder="Masukkan 10 digit NISN"
                               maxlength="10"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               required>
                    </div>
                    <div class="form-text">Pastikan NISN sesuai dengan data Dapodik sekolah.</div>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                        <input type="text"
                               class="form-control no-toggle @error('nama_lengkap') is-invalid @enderror"
                               id="nama_lengkap" name="nama_lengkap"
                               value="{{ old('nama_lengkap') }}"
                               placeholder="Nama lengkap sesuai ijazah"
                               required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label for="angkatan_id" class="form-label">Angkatan <span class="required">*</span></label>
                        <select class="form-select @error('angkatan_id') is-invalid @enderror"
                                id="angkatan_id" name="angkatan_id" required>
                            <option value="">Pilih Angkatan</option>
                            @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan->id }}" {{ old('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                                    {{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5 mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus <span class="required">*</span></label>
                        <input type="number"
                               class="form-control @error('tahun_lulus') is-invalid @enderror"
                               id="tahun_lulus" name="tahun_lulus"
                               value="{{ old('tahun_lulus', date('Y')) }}"
                               min="2010"
                               max="{{ date('Y') + 1 }}"
                               required>
                    </div>
                </div>

                {{-- Kredensial Akun --}}
                <div class="section-title">Kredensial Akun</div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                        <input type="text"
                               class="form-control no-toggle @error('username') is-invalid @enderror"
                               id="username" name="username"
                               value="{{ old('username') }}"
                               placeholder="Buat username (unik, tanpa spasi)"
                               required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Min. 6 karakter"
                                   required>
                            <button class="btn-toggle-password" type="button"
                                    id="togglePassword" title="Lihat/Sembunyikan Password">
                                <i class="bi bi-eye-fill" id="toggleIconPassword"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password"
                                   required>
                            <button class="btn-toggle-password" type="button"
                                    id="toggleConfirm" title="Lihat/Sembunyikan Password">
                                <i class="bi bi-eye-fill" id="toggleIconConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info box --}}
                <div class="info-box">
                    <div class="d-flex gap-3 align-items-start">
                        <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
                        <div class="small text-muted">
                            Setelah mendaftar, akun Anda akan berstatus <strong>Pending</strong>.
                            Harap tunggu admin melakukan verifikasi ijazah/data siswa sebelum profil Anda aktif.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-register w-100 mb-4">
                    Selesaikan Registrasi <i class="bi bi-arrow-right-short ms-1"></i>
                </button>
            </form>

            <div class="text-center pt-1">
                <p class="text-muted small mb-0">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="login-link ms-1">Masuk Sekarang</a>
                </p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function togglePasswordVisibility(inputId, iconId, btnId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const btn   = document.getElementById(btnId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            btn.title = 'Sembunyikan Password';
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            btn.title = 'Lihat Password';
        }
    }

    document.getElementById('togglePassword').addEventListener('click', function() {
        togglePasswordVisibility('password', 'toggleIconPassword', 'togglePassword');
    });

    document.getElementById('toggleConfirm').addEventListener('click', function() {
        togglePasswordVisibility('password_confirmation', 'toggleIconConfirm', 'toggleConfirm');
    });
</script>
</body>
</html>
