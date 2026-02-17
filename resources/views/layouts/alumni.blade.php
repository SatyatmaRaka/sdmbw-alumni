<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistem Alumni</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        :root {
            --color-primary:      #213448;
            --color-primary-light:#2d4a65;
            --color-primary-dark: #1a2838;
            --color-accent:       #EAE0CF;
            --color-bg:           #f4f7f9;
            --sidebar-width:      280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header i {
            font-size: 2.5rem;
            color: var(--color-accent);
            margin-bottom: 10px;
            display: block;
        }

        .sidebar-header h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .nav-item { margin: 0.4rem 1rem; }

        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .nav-link i {
            font-size: 1.25rem;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.08);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--color-accent);
            color: var(--color-primary-dark);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .nav-link.active i { color: var(--color-primary-dark); }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1.5rem;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: all 0.3s ease;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: white;
            padding: 1rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--color-primary);
            margin: 0;
            font-size: 1.4rem;
        }

        .content-body { padding: 2.5rem; }

        /* ===== USER DROPDOWN ===== */
        .user-dropdown .btn-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 50px;
            transition: all 0.3s;
            border: 1px solid #f1f5f9;
            cursor: pointer;
        }

        .user-dropdown .btn-user:hover { background: #f8fafc; }

        .user-info { text-align: right; line-height: 1.2; }
        .user-info .name { display: block; font-weight: 600; font-size: 0.9rem; color: var(--color-primary); }
        .user-info .role { font-size: 0.75rem; color: #94a3b8; }

        .avatar-circle {
            width: 40px; height: 40px;
            background: var(--color-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* ===== MOBILE TOGGLE ===== */
        .mobile-toggle {
            display: none;
            background: white;
            border: none;
            font-size: 1.5rem;
            color: var(--color-primary);
            padding: 0.5rem;
            cursor: pointer;
        }

        /* ===== SIDEBAR OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }
        .sidebar-overlay.show { display: block; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .topbar { padding: 1rem 1.5rem; }
            .content-body { padding: 1.5rem; }
            .user-info { display: none; }
        }

        @media (max-width: 575px) {
            .content-body { padding: 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Overlay untuk mobile sidebar --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-mortarboard-fill"></i>
            <h5>SISTEM ALUMNI</h5>
            <div class="badge bg-white bg-opacity-10 text-white-50 fw-normal mt-2">
                SD Muhammadiyah BWK
            </div>
        </div>

        <nav class="mt-4">
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}"
                   href="{{ route('alumni.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.profile.*') ? 'active' : '' }}"
                   href="{{ route('alumni.profile.edit') }}">
                    <i class="bi bi-person-bounding-box"></i>
                    <span>Profil Saya</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.direktori.*') ? 'active' : '' }}"
                   href="{{ route('alumni.direktori.index') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Direktori Alumni</span>
                </a>
            </div>

            <div class="nav-divider"></div>

            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="nav-link text-start w-100 border-0 bg-transparent"
                            style="color: #ff6b6b;">
                        <i class="bi bi-power"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" id="btnToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4>@yield('title', 'Dashboard')</h4>
            </div>

            <div class="dropdown user-dropdown">
                <div class="btn-user dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-info">
                        <span class="name">{{ Auth::user()->alumni->nama_lengkap ?? Auth::user()->username }}</span>
                        <span class="role">Alumni Verified</span>
                    </div>
                    <div class="avatar-circle">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3"
                    style="border-radius: 15px; min-width: 200px;">
                    <li class="p-2">
                        <a class="dropdown-item rounded-3 py-2" href="{{ route('alumni.profile.edit') }}">
                            <i class="bi bi-person me-2"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50 my-1"></li>
                    <li class="p-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content-body">

            {{-- SESSION ALERTS --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-x-circle-fill me-3 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                    <div>{{ session('warning') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Toggle --}}
    <script>
        const btnToggle   = document.getElementById('btnToggle');
        const sidebar     = document.getElementById('sidebar');
        const overlay     = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        btnToggle?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Auto-close sidebar on nav link click (mobile)
        if (window.innerWidth < 992) {
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (sidebar.classList.contains('show')) toggleSidebar();
                });
            });
        }
    </script>

    {{-- Toast Notification --}}
    <script>
    function showToast(message, type = 'success', duration = 3000) {
        const container = document.getElementById('toast-container');

        const icons = {
            success: '<i class="bi bi-check-circle-fill"></i>',
            error:   '<i class="bi bi-x-circle-fill"></i>',
            warning: '<i class="bi bi-exclamation-triangle-fill"></i>',
            info:    '<i class="bi bi-info-circle-fill"></i>'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span class="toast-icon">${icons[type] || icons.info}</span>
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

    // Auto-show dari Laravel session
    @if(session('success'))
        showToast("{{ addslashes(session('success')) }}", 'success');
    @endif
    @if(session('error'))
        showToast("{{ addslashes(session('error')) }}", 'error');
    @endif
    @if(session('warning'))
        showToast("{{ addslashes(session('warning')) }}", 'warning');
    @endif
    @if(session('info'))
        showToast("{{ addslashes(session('info')) }}", 'info');
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast("{{ addslashes($error) }}", 'error', 5000);
        @endforeach
    @endif
    </script>

    {{-- Loading State --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.classList.contains('btn-loading')) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
                    submitBtn.innerHTML = submitBtn.querySelector('i')
                        ? '<i class="bi bi-arrow-clockwise spinning me-2"></i> Memproses...'
                        : 'Memproses...';
                }
            });
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
