<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SDMBW Alumni</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">

    <style>
        :root {
            --color-primary: #213448;
            --color-primary-light: #2d4a63;
            --color-primary-dark: #1a2937;
            --color-bg: #f0f2f5; /* Sedikit lebih abu-abu agar kartu putih lebih 'pop' */
            --color-secondary: #6c757d;
            --color-accent: #0d6efd;
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: var(--color-bg);
            color: #444;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            z-index: 1050;
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 30px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-brand small {
            display: block;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            margin-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 4px 15px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-menu li a i {
            font-size: 1.25rem;
            margin-right: 15px;
            transition: transform 0.2s;
        }

        .sidebar-menu li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu li a:hover i {
            transform: scale(1.1);
        }

        .sidebar-menu li a.active {
            background: var(--color-accent);
            color: white;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .sidebar-menu li a.active i {
            color: white;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all var(--transition-speed) ease;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 0 25px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: var(--topbar-height);
        }

        .topbar h5 {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
            font-weight: 700;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 15px;
            background: #f8f9fa;
            border-radius: 50px;
            border: 1px solid #eee;
        }

        .user-info span {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--color-primary);
        }

        .btn-logout {
            background: #fff;
            color: #dc3545;
            border: 1px solid #ffc1c1;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
        }

        /* ===== CARDS & UI ELEMENTS ===== */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-header {
            background: #fff;
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
        }

        .alert {
            border: none;
            border-radius: 12px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }

        /* ===== TOGGLE BUTTON (MOBILE) ===== */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: var(--color-primary);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(33, 52, 72, 0.3);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(3px);
            z-index: 1040;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
                padding-top: 85px;
            }
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 575.98px) {
            .topbar {
                flex-direction: column;
                height: auto;
                padding: 15px;
                gap: 15px;
                align-items: flex-start;
            }
            .user-menu {
                width: 100%;
                justify-content: space-between;
            }
            .user-info span {
                max-width: 80px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list fs-3"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>ADMIN PANEL</h4>
            <small>SD Muhammadiyah BWK</small>
        </div>

        <nav>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.alumni.index') }}" class="{{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> <span>Kelola Alumni</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.angkatan.index') }}" class="{{ request()->routeIs('admin.angkatan.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar3"></i> <span>Kelola Angkatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i> <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.logs.index') }}" class="{{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> <span>Activity Logs</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <h5>@yield('page-title', 'Dashboard')</h5>

            <div class="user-menu">
                <div class="user-info">
                    <i class="bi bi-person-circle fs-5 text-primary"></i>
                    <span>{{ Auth::user()->username }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        @foreach(['success', 'error', 'warning'] as $msg)
            @if(session($msg))
                <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
                    <i class="bi {{ $msg === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }} me-3"></i>
                    <div>{{ session($msg) }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </main>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }

            toggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            if (window.innerWidth < 992) {
                document.querySelectorAll('.sidebar-menu a').forEach(link => {
                    link.addEventListener('click', toggleSidebar);
                });
            }
        });
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
