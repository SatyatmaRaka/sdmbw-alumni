<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Alumni') - SD Muhammadiyah Birrul Walidain Kudus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        :root {
            /* Warna Tema */
            --color-primary: #213448;
            --color-primary-light: #2d4a65;
            --color-primary-dark: #152230;
            --color-accent: #EAE0CF;
            --color-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        /* --- Navbar --- */
        .navbar-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            padding: 0.8rem 0;
            border-bottom: 3px solid var(--color-accent);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-custom .navbar-brand {
            color: #ffffff !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 5px;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-item.active .nav-link {
            color: var(--color-accent) !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-navbar-cream {
            background-color: var(--color-accent);
            color: var(--color-primary-dark) !important;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 50px;
            padding: 0.6rem 1.5rem !important;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(234, 224, 207, 0.2);
        }

        .btn-navbar-cream:hover {
            background-color: transparent;
            border-color: var(--color-accent);
            color: var(--color-accent) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(234, 224, 207, 0.3);
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.4rem 0.6rem;
        }

        /* --- Footer --- */
        .footer {
            background: linear-gradient(180deg, var(--color-primary-dark) 0%, #0a1420 100%);
            color: #ffffff !important;
            padding: 5rem 0 0 0;
            margin-top: auto;
            border-top: 4px solid var(--color-accent);
        }

        .footer-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .footer h5 {
            color: var(--color-accent) !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }

        /* Garis bawah kecil pada judul footer */
        .footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background: var(--color-accent);
        }

        .footer p {
            color: #b0b9c1 !important;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .footer ul li {
            margin-bottom: 0.8rem;
        }

        .footer ul li a {
            color: #b0b9c1 !important;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .footer ul li a:hover {
            color: var(--color-accent) !important;
            padding-left: 8px;
        }

        .contact-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-accent);
            margin-right: 12px;
            flex-shrink: 0;
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.4);
            padding: 1.5rem 0;
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-bottom p {
            margin: 0;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* --- Global Scrollbar --- */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 10px;
        }

        /* --- Responsive --- */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: var(--color-primary-dark);
                padding: 1.5rem;
                border-radius: 15px;
                margin-top: 1rem;
                border: 1px solid rgba(234, 224, 207, 0.2);
            }
            .nav-link {
                padding: 0.8rem 1rem !important;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            .btn-navbar-cream {
                width: 100%;
                margin-top: 1rem;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing.index') }}">
                <i class="bi bi-mortarboard-fill me-2 fs-3" style="color: var(--color-accent)"></i>
                <span>ALUMNI SDMBW</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="bi bi-list text-white fs-2"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.direktori') }}">Direktori Alumni</a>
                    </li>

                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link px-3" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}" class="btn btn-navbar-cream">Daftar Sekarang</a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link d-flex align-items-center" href="{{ route('alumni.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
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
                        <i class="bi bi-mortarboard-fill me-2" style="color: var(--color-accent)"></i>
                        ALUMNI SDMBW
                    </div>
                    <p>Wadah resmi silaturahmi alumni SD Muhammadiyah Birrul Walidain Kudus. Bersama membangun jejaring, berbagi inspirasi, dan berkontribusi untuk almamater tercinta.</p>
                </div>

                <div class="col-lg-2 col-md-4 ms-lg-auto">
                    <h5>Navigasi</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('landing.index') }}"><i class="bi bi-chevron-right me-1 small"></i> Beranda</a></li>
                        <li><a href="{{ route('public.direktori') }}"><i class="bi bi-chevron-right me-1 small"></i> Direktori Alumni</a></li>
                        <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right me-1 small"></i> Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right me-1 small"></i> Registrasi</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-8">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-3">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <span>Jl. HOS Cokroaminoto, Ds. Mlatinorowito, Gg. 10, RT 03 RW 09, Kab. Kudus, Jawa Tengah.</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <span>(0812) 48076886 / (0291) 4248302</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <span>info@sdmbwkudus.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} SD Muhammadiyah Birrul Walidain Kudus.</p>
            </div>
        </div>
    </footer>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
