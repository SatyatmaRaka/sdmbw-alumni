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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Alumni') - SD Muhammadiyah Birrul Walidain Kudus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        :root {
            --color-primary:       #1B3A52;
            --color-primary-light: #2a5378;
            --color-primary-dark:  #112534;
            --color-accent:        #E8C87A;
            --color-accent-hover:  #d9b75e;
            --color-bg:            #F7F5F0;
            --color-text:          #1e293b;
            --color-text-muted:    #64748b;
            --transition:          all 0.28s cubic-bezier(0.4,0,0.2,1);
            --radius-sm:           8px;
            --radius-md:           12px;
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--color-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: var(--color-text);
        }

        /* ──────────────────────────────────────────
            NAVBAR
        ────────────────────────────────────────── */
        .navbar-custom {
            background: var(--color-primary-dark);
            padding: 0;
            border-bottom: 2px solid rgba(232,200,122,0.35);
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            transition: var(--transition);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* scrolled state applied via JS */
        .navbar-custom.scrolled {
            background: rgba(17,37,52,0.95);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 4px 32px rgba(0,0,0,0.22);
        }

        .navbar-custom .container {
            min-height: 68px;
            display: flex;
            align-items: center;
        }

        .navbar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-logo-box {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: var(--radius-sm);
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .navbar-logo-box:hover { background: rgba(255,255,255,0.14); }

        .navbar-logo-box img {
            height: 36px;
            width: auto;
            object-fit: contain;
            filter: brightness(1.1) drop-shadow(0 0 4px rgba(255,255,255,0.25));
        }

        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.75) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.55rem 0.9rem !important;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            letter-spacing: 0.2px;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-item.active .nav-link {
            color: #fff !important;
            background: rgba(255,255,255,0.08);
        }

        .btn-navbar-accent {
            background-color: var(--color-accent);
            color: var(--color-primary-dark) !important;
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 50px;
            padding: 0.55rem 1.4rem !important;
            border: 2px solid transparent;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(232,200,122,0.3);
            letter-spacing: 0.3px;
        }

        .btn-navbar-accent:hover {
            background-color: var(--color-accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232,200,122,0.4);
            color: var(--color-primary-dark) !important;
        }

        .btn-navbar-ghost {
            background: transparent;
            color: rgba(255,255,255,0.75) !important;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.9rem !important;
            border: 1px solid rgba(255,255,255,0.18);
            transition: var(--transition);
        }

        .btn-navbar-ghost:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.35);
            color: #fff !important;
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.18);
            padding: 0.35rem 0.6rem;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.05);
            transition: var(--transition);
        }
        .navbar-toggler:hover { background: rgba(255,255,255,0.1); }

        /* ──────────────────────────────────────────
            FOOTER
        ────────────────────────────────────────── */
        .footer {
            background: var(--color-primary-dark);
            color: #ffffff;
            padding: 5rem 0 0;
            margin-top: auto;
            border-top: 3px solid var(--color-accent);
            position: relative;
            overflow: hidden;
        }

        /* subtle background pattern */
        .footer::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* glow orb top-right */
        .footer::after {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(42,83,120,0.4) 0%, transparent 70%);
            pointer-events: none;
        }

        .footer .container { position: relative; z-index: 1; }

        .footer-logo-text {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo-text i { color: var(--color-accent); }

        .footer h5 {
            color: var(--color-accent) !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.75rem;
            position: relative;
            padding-bottom: 12px;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            left: 0; bottom: 0;
            width: 28px; height: 2px;
            background: var(--color-accent);
            border-radius: 2px;
        }

        .footer p {
            color: rgba(255,255,255,0.55) !important;
            font-size: 0.9rem;
            line-height: 1.8;
        }

        .footer ul li { margin-bottom: 0.65rem; }

        .footer ul li a {
            color: rgba(255,255,255,0.55) !important;
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer ul li a i {
            font-size: 0.65rem;
            opacity: 0.6;
            transition: var(--transition);
        }

        .footer ul li a:hover {
            color: var(--color-accent) !important;
            padding-left: 4px;
        }

        .footer ul li a:hover i { opacity: 1; }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .contact-icon {
            width: 34px; height: 34px;
            background: rgba(232,200,122,0.1);
            border: 1px solid rgba(232,200,122,0.2);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-accent);
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .contact-item span {
            color: rgba(255,255,255,0.55);
            font-size: 0.88rem;
            line-height: 1.65;
        }

        .footer-bottom {
            background: rgba(0,0,0,0.3);
            padding: 1.4rem 0;
            margin-top: 4rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 1;
        }

        .footer-bottom p {
            margin: 0;
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            color: rgba(255,255,255,0.4) !important;
        }

        .footer-bottom strong { color: var(--color-accent); font-weight: 600; }

        /* ──────────────────────────────────────────
            SCROLLBAR
        ────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-primary-light); }

        /* ──────────────────────────────────────────
           RESPONSIVE
        ────────────────────────────────────────── */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: var(--color-primary-dark);
                padding: 1.25rem;
                border-radius: var(--radius-md);
                margin-top: 0.75rem;
                border: 1px solid rgba(232,200,122,0.15);
                box-shadow: 0 16px 40px rgba(0,0,0,0.3);
            }
            .navbar-custom .nav-link {
                padding: 0.75rem 1rem !important;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            .btn-navbar-accent {
                width: 100%;
                margin-top: 0.75rem;
                text-align: center;
                display: block;
            }
            .btn-navbar-ghost {
                width: 100%;
                text-align: center;
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
        <div class="container">
            <a class="navbar-brand-wrap" href="{{ route('landing.index') }}">
                <div class="navbar-logo-box">
                    <img src="{{ asset('images/logo-sdmbw.png') }}" alt="Logo SDMBW">
                </div>
            </a>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="bi bi-list text-white fs-3"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.direktori') }}">Direktori Alumni</a>
                    </li>

                    @guest
                        <li class="nav-item ms-lg-1">
                            <a class="btn-navbar-ghost nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}" class="btn btn-navbar-accent">Daftar Sekarang</a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ Auth::user()->isAdmin()
                                ? route('admin.dashboard')
                                : route('alumni.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4 col-md-12">
                    <div class="footer-logo-text">
                        <i class="bi bi-mortarboard-fill"></i>
                        Alumni SDMBW
                    </div>
                    <p>Wadah resmi silaturahmi alumni SD Muhammadiyah Birrul Walidain Kudus. Bersama membangun jejaring, berbagi inspirasi, dan berkontribusi untuk almamater tercinta.</p>
                </div>

                <div class="col-lg-2 col-md-4 ms-lg-auto">
                    <h5>Navigasi</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('landing.index') }}"><i class="bi bi-chevron-right"></i> Beranda</a></li>
                        <li><a href="{{ route('public.direktori') }}"><i class="bi bi-chevron-right"></i> Direktori Alumni</a></li>
                        <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i> Masuk</a></li>
                        <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right"></i> Registrasi</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-8">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li>
                            <div class="contact-item">
                                <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                                <span>Jl. HOS Cokroaminoto, Ds. Mlatinorowito, Gg. 10, RT 03 RW 09, Kab. Kudus, Jawa Tengah.</span>
                            </div>
                        </li>
                        <li>
                            <div class="contact-item">
                                <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                                <span>(0812) 48076886 / (0291) 4248302</span>
                            </div>
                        </li>
                        <li>
                            <div class="contact-item">
                                <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                                <span>info@sdmbwkudus.sch.id</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} <strong>SD Muhammadiyah Birrul Walidain Kudus</strong>.</p>
            </div>
        </div>
    </footer>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Navbar scroll effect --}}
    <script>
    (function() {
        const nav = document.getElementById('mainNav');
        if (!nav) return;
        const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 40);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    })();
    </script>

    {{-- Toast Notification Script --}}
    <script>
    function showToast(message, type = 'success', duration = 3000) {
        const container = document.getElementById('toast-container');

        const icons = {
            success: '<i class="bi bi-check-circle-fill"></i>',
            error: '<i class="bi bi-x-circle-fill"></i>',
            warning: '<i class="bi bi-exclamation-triangle-fill"></i>',
            info: '<i class="bi bi-info-circle-fill"></i>'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span class="toast-icon">${icons[type] || icons.success}</span>
            <div class="toast-content">${message}</div>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        `;

        container.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // Auto show Laravel session messages
    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif

    @if(session('warning'))
        showToast("{{ session('warning') }}", 'warning');
    @endif

    @if(session('info'))
        showToast("{{ session('info') }}", 'info');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast("{{ $error }}", 'error', 5000);
        @endforeach
    @endif
    </script>

    {{-- Loading State Script --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');

                if (submitBtn && !submitBtn.classList.contains('btn-loading')) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;

                    const originalText = submitBtn.innerHTML;
                    submitBtn.setAttribute('data-original-text', originalText);

                    const icon = submitBtn.querySelector('i');
                    if (icon) {
                        submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise spinning me-2"></i> Memproses...';
                    } else {
                        submitBtn.innerHTML = 'Memproses...';
                    }
                }
            });
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
