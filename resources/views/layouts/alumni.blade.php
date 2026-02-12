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

    <style>
        :root {
            --color-primary: #213448;
            --color-primary-light: #2d4a65;
            --color-primary-dark: #1a2838;
            --color-accent: #EAE0CF; /* Menambahkan aksen cream dari landing page agar seragam */
            --color-bg: #f4f7f9;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* --- Sidebar --- */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
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

        .nav-item {
            margin: 0.4rem 1rem;
        }

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

        .nav-link.active i {
            color: var(--color-primary-dark);
        }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1.5rem 1.5rem;
        }

        /* --- Main Content & Topbar --- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: all 0.3s ease;
        }

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

        .content-body {
            padding: 2.5rem;
        }

        /* --- User Menu --- */
        .user-dropdown .btn-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 50px;
            transition: all 0.3s;
            border: 1px solid #f1f5f9;
        }

        .user-dropdown .btn-user:hover {
            background: #f8fafc;
        }

        .user-info {
            text-align: right;
            line-height: 1.2;
        }

        .user-info .name {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--color-primary);
        }

        .user-info .role {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* --- Mobile Toggle --- */
        .mobile-toggle {
            display: none;
            background: white;
            border: none;
            font-size: 1.5rem;
            color: var(--color-primary);
            padding: 0.5rem;
        }

        /* --- Responsive Logic --- */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-toggle {
                display: block;
            }
            .topbar {
                padding: 1rem 1.5rem;
            }
            .content-body {
                padding: 1.5rem;
            }
            .user-info {
                display: none;
            }
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }
        .sidebar-overlay.show {
            display: block;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-mortarboard-fill"></i>
            <h5>SISTEM ALUMNI</h5>
            <div class="badge bg-white bg-opacity-10 text-white-50 fw-normal mt-2">SD Muhammadiyah BWK</div>
        </div>

        <nav class="mt-4">
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}" href="{{ route('alumni.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.profile.*') ? 'active' : '' }}" href="{{ route('alumni.profile.edit') }}">
                    <i class="bi bi-person-bounding-box"></i>
                    <span>Profil Saya</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('alumni.direktori.*') ? 'active' : '' }}" href="{{ route('alumni.direktori.index') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Direktori Alumni</span>
                </a>
            </div>

            <div class="nav-divider"></div>

            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-start w-100 border-0 bg-transparent text-danger bg-danger-hover">
                        <i class="bi bi-power"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" id="btnToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4>@yield('title', 'Dashboard')</h4>
            </div>

            <div class="dropdown user-dropdown">
                <div class="btn-user dropdown-toggle" role="button" data-bs-toggle="dropdown">
                    <div class="user-info">
                        <span class="name">{{ Auth::user()->alumni->nama_lengkap ?? Auth::user()->username }}</span>
                        <span class="role">Alumni Verified</span>
                    </div>
                    <div class="avatar-circle" style="width: 40px; height: 40px; background: var(--color-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ substr(Auth::user()->username, 0, 1) }}
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" style="border-radius: 15px; min-width: 200px;">
                    <li class="p-2">
                        <a class="dropdown-item rounded-3 py-2" href="{{ route('alumni.profile.edit') }}">
                            <i class="bi bi-person me-2"></i> Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50"></li>
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

        <main class="content-body">
            @if(session('success') || session('error') || session('warning'))
                <div class="mb-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btnToggle = document.getElementById('btnToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        btnToggle?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);
    </script>
    @stack('scripts')
</body>
</html>
