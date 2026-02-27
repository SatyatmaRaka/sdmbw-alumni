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

    <title>Login - Sistem Alumni SDMBW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=DM+Serif+Display&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=DM+Serif+Display&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=DM+Serif+Display&display=swap"></noscript>

    <style>
        :root {
            --primary:       #1B3A52;
            --primary-light: #2a5378;
            --primary-dark:  #112534;
            --accent:        #EAE0CF;
            --accent-hover:  #d9b75e;
            --radius:        12px;
            --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        html, body { height: 100%; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
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
                radial-gradient(ellipse at 15% 50%, rgba(42,83,120,0.6) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 15%, rgba(232,200,122,0.07) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 85%, rgba(27,58,82,0.5) 0%, transparent 55%);
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

        /* ── BACK BUTTON ── */
        .btn-back-home {
            position: fixed;
            top: 16px; left: 16px;
            z-index: 100;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            padding: 8px 15px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            border: 1px solid rgba(255,255,255,0.13);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back-home:hover {
            background: rgba(255,255,255,0.14);
            border-color: rgba(255,255,255,0.25);
            color: white;
            transform: translateX(-3px);
        }

        /* ── CARD ── */
        .login-card {
            background: white;
            border-radius: 22px;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.05),
                0 24px 72px rgba(0,0,0,0.4);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            animation: cardIn 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        @keyframes cardIn {
            from { opacity:0; transform: translateY(20px) scale(0.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* ── HEADER ── */
        .login-header {
            background: var(--primary-dark);
            padding: 2.25rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 20px 20px;
            pointer-events: none;
        }

        .login-header::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(42,83,120,0.65) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-header-inner { position: relative; z-index: 1; }

        .logo-wrap {
            width: 60px; height: 60px;
            background: rgba(232,200,122,0.12);
            border: 1px solid rgba(232,200,122,0.28);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px;
        }

        .logo-wrap i { font-size: 1.75rem; color: var(--accent); }

        .login-header h1 {
            font-family: 'DM Serif Display', Georgia, 'Times New Roman', serif;
            font-weight: 400;
            font-size: 1.55rem;
            color: white;
            margin: 0 0 4px;
        }

        .login-header p {
            font-size: 0.77rem;
            color: rgba(255,255,255,0.42);
            font-weight: 500;
            margin: 0;
        }

        .header-divider {
            height: 2px;
            background: linear-gradient(to right, var(--accent) 0%, transparent 70%);
        }

        /* ── BODY ── */
        .login-body {
            padding: 1.75rem 2rem 2rem;
        }

        /* ── LABELS ── */
        .form-label {
            color: #475569;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
            display: block;
        }

        /* ── INPUT WRAP (custom, no Bootstrap input-group) ── */
        .input-wrap {
            display: flex;
            border: 1.5px solid #e2e8f0;
            border-radius: var(--radius);
            overflow: hidden;
            transition: var(--transition);
            background: #f8fafc;
        }

        .input-wrap:focus-within {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
        }

        .input-icon {
            display: flex;
            align-items: center;
            padding: 0 13px;
            color: #94a3b8;
            font-size: 0.95rem;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .input-wrap:focus-within .input-icon { color: var(--primary); }

        .input-wrap input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: 0.72rem 0.5rem;
            font-size: 0.9rem;
            color: var(--primary);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-width: 0;
            width: 100%;
        }

        .input-wrap input::placeholder { color: #b0bec5; }

        .btn-toggle-password {
            background: transparent;
            border: none;
            padding: 0 13px;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .btn-toggle-password:hover { color: var(--primary); }

        /* ── LOGIN BUTTON ── */
        .btn-login {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.8rem;
            font-weight: 700;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            letter-spacing: 0.3px;
            border-radius: 50px;
            transition: var(--transition);
            box-shadow: 0 4px 18px rgba(27,58,82,0.28);
            width: 100%;
            cursor: pointer;
        }

        .btn-login:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 26px rgba(27,58,82,0.35);
        }

        /* ── ALERTS ── */
        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 0.8rem 0.95rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .alert-success { background: #f0fdf4; color: #166534; border-left: 3px solid #22c55e; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444; }
        .alert-warning { background: #fffbeb; color: #92400e; border-left: 3px solid #f59e0b; }

        /* ── DIVIDER ── */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.4rem 0;
            color: #cbd5e1;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── FOOTER ── */
        .login-footer { text-align: center; }

        .login-footer p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .link-primary {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            font-size: 0.875rem;
            border-bottom: 1.5px solid var(--accent);
            padding-bottom: 1px;
            transition: var(--transition);
        }

        .link-primary:hover { color: var(--primary-light); border-color: var(--primary-light); }

        .link-wa {
            color: #16a34a;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .link-wa:hover { color: #15803d; }

        /* ── REMEMBER ── */
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.82rem;
            color: #64748b;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            body { padding: 1rem; align-items: flex-start; padding-top: 3.5rem; }
            .login-card { border-radius: 18px; max-width: 100%; }
            .login-body { padding: 1.4rem 1.4rem 1.75rem; }
            .login-header { padding: 1.75rem 1.4rem 1.5rem; }
            .btn-back-home { top: 12px; left: 12px; padding: 7px 12px; font-size: 0.75rem; }
        }

        /* short screens (landscape mobile) */
        @media (max-height: 680px) {
            body { align-items: flex-start; padding-top: 3.5rem; }
            .login-header { padding: 1.4rem 2rem 1.2rem; }
            .logo-wrap { width: 48px; height: 48px; margin-bottom: 9px; }
            .logo-wrap i { font-size: 1.5rem; }
            .login-header h1 { font-size: 1.3rem; }
            .login-body { padding: 1.35rem 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    <a href="{{ route('landing.index') }}" class="btn-back-home">
        <i class="bi bi-arrow-left"></i> Beranda
    </a>

    <div class="login-card">

        {{-- ── HEADER ── --}}
        <div class="login-header">
            <div class="login-header-inner">
                <div class="logo-wrap">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h1>Sistem Alumni</h1>
                <p>SD Muhammadiyah Birrul Walidain Kudus</p>
            </div>
        </div>
        <div class="header-divider"></div>

        {{-- ── BODY ── --}}
        <div class="login-body">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Notifikasi Error Login --}}
            @if($errors->has('username'))
                @php $loginStatus = session('login_status'); @endphp

                @if($loginStatus === 'rejected')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-x-octagon-fill mt-1"></i>
                            <div><strong>Pendaftaran Ditolak</strong><br>{{ $errors->first('username') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                @elseif($loginStatus === 'pending')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-hourglass-split mt-1"></i>
                            <div><strong>Menunggu Verifikasi</strong><br>{{ $errors->first('username') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                @else
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>{{ $errors->first('username') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ── FORM ── --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-person-fill"></i></span>
                        <input type="text"
                               id="username"
                               name="username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username"
                               required
                               autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="••••••••"
                               required>
                        <button class="btn-toggle-password" type="button"
                                id="togglePassword" title="Lihat/Sembunyikan Password">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Masuk Sekarang <i class="bi bi-box-arrow-in-right ms-2"></i>
                </button>
            </form>

            <div class="login-divider">atau</div>

            <div class="login-footer">
                <p>Belum punya akun?</p>
                <a href="{{ route('register') }}" class="link-primary">Daftar Sebagai Alumni</a>

                <div class="mt-3">
                    <p>Lupa password?</p>
                    <a href="https://wa.me/6281248076886" target="_blank" class="link-wa" rel="noopener noreferrer">
                        <i class="bi bi-whatsapp"></i> Hubungi Admin Sekolah
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon    = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
                this.title = 'Sembunyikan Password';
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                this.title = 'Lihat Password';
            }
        });
    </script>
</body>
</html>
