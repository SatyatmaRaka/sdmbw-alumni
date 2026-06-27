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
    <title>@yield('title', 'Dashboard') - Sistem Alumni</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary:       #1B3A52;
            --color-primary-light: #2a5378;
            --color-primary-dark:  #112534;
            --color-accent:        #EAE0CF;
            --color-accent-soft:   rgba(232, 200, 122, 0.15);
            --color-bg:            #EEF2F7;
            --color-surface:       #ffffff;
            --color-text:          #1e293b;
            --color-text-muted:    #64748b;
            --sidebar-width:       270px;
            --radius-card:         16px;
            --radius-btn:          10px;
            --shadow-card:         0 4px 24px rgba(27,58,82,0.08);
            --shadow-sidebar:      6px 0 32px rgba(0,0,0,0.14);
            --transition:          all 0.28s cubic-bezier(0.4,0,0.2,1);
        }



        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
        }

        /* ────────── SIDEBAR ────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--color-primary-dark);
            color: white;
            z-index: 1050;
            transition: var(--transition);
            box-shadow: var(--shadow-sidebar);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* subtle noise texture overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: 0.4;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1.75rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative;
        }

        .sidebar-logo-wrap {
            width: 56px; height: 56px;
            background: var(--color-accent);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            box-shadow: 0 8px 24px rgba(232,200,122,0.3);
        }

        .sidebar-logo-wrap i {
            font-size: 1.75rem;
            color: var(--color-primary-dark);
        }

        .sidebar-header h5 {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
            font-size: 1.15rem;
            letter-spacing: 0.3px;
            color: #fff;
            margin: 0 0 6px;
        }

        .sidebar-badge {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: 0.4px;
        }

        /* nav section label */
        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 0 1.6rem;
            margin: 1.4rem 0 0.5rem;
        }

        .nav-item { margin: 2px 0.75rem; }

        .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 0.78rem 1rem;
            border-radius: var(--radius-btn);
            transition: var(--transition);
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.875rem;
            gap: 12px;
            position: relative;
        }

        .nav-link i {
            font-size: 1.1rem;
            flex-shrink: 0;
            width: 22px;
            text-align: center;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.07);
            transform: translateX(3px);
        }

        .nav-link.active {
            background: var(--color-accent);
            color: var(--color-primary-dark);
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(232,200,122,0.25);
        }

        .nav-link.active i { color: var(--color-primary-dark); }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.07);
            margin: 1rem 1.25rem;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-footer .nav-item { margin: 0; }

        .nav-link-danger {
            color: rgba(255,100,100,0.7) !important;
        }
        .nav-link-danger:hover {
            color: #ff7272 !important;
            background: rgba(255,100,100,0.08) !important;
        }

        /* ────────── MAIN CONTENT ────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
        }

        /* ────────── TOPBAR ────────── */
        .topbar {
            background: var(--color-surface);
            padding: 0.875rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 0 rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
            gap: 1rem;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 0;
        }

        .topbar h4 {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
            color: var(--color-primary);
            margin: 0;
            font-size: 1.45rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* breadcrumb accent line */
        .topbar h4::before {
            content: '';
            display: inline-block;
            width: 4px; height: 1em;
            background: var(--color-accent);
            border-radius: 2px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .content-body {
            padding: 2rem 2.5rem;
        }

        /* ────────── USER DROPDOWN ────────── */
        .user-dropdown .btn-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 10px 5px 14px;
            border-radius: 50px;
            transition: var(--transition);
            border: 1px solid #e2e8f0;
            cursor: pointer;
            background: #f8fafc;
        }

        .user-dropdown .btn-user:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .user-info { text-align: right; line-height: 1.3; }
        .user-info .name {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--color-primary);
        }
        .user-info .role {
            font-size: 0.7rem;
            color: var(--color-text-muted);
            font-weight: 500;
        }

        .avatar-circle {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(27,58,82,0.25);
        }

        .dropdown-menu {
            border-radius: var(--radius-card) !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12) !important;
            padding: 0.5rem !important;
        }

        .dropdown-item {
            border-radius: 8px !important;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text) !important;
            transition: var(--transition);
        }
        .dropdown-item:hover { background: #f1f5f9 !important; }

        /* ────────── ALERTS ────────── */
        .alert {
            border: none;
            border-radius: var(--radius-card);
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: var(--shadow-card);
        }
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* ────────── MOBILE TOGGLE ────────── */
        .mobile-toggle {
            display: none;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1.25rem;
            color: var(--color-primary);
            padding: 0.35rem 0.6rem;
            cursor: pointer;
            transition: var(--transition);
            line-height: 1;
        }
        .mobile-toggle:hover { background: #e2e8f0; }

        /* ────────── OVERLAY ────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10,18,28,0.55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 1040;
        }
        .sidebar-overlay.show { display: block; }

        /* ────────── PAGE ENTRY ANIMATION ────────── */
        .content-body {
            animation: fadeUp 0.4s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ────────── RESPONSIVE ────────── */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: inline-flex; align-items: center; }
            .topbar { padding: 0.875rem 1.25rem; }
            .content-body { padding: 1.25rem; }
            .user-info { display: none; }
        }

        @media (max-width: 575px) {
            .content-body { padding: 1rem; }
            .topbar h4 { font-size: 1.2rem; }
        }

        /* ─── ONBOARDING STEPPER ─── */
        .onboarding-stepper {
            background: linear-gradient(135deg, #1B3A52 0%, #2a5378 100%);
            border-radius: 14px;
            padding: 1rem 1.5rem;
            color: white;
            box-shadow: 0 4px 16px rgba(27,58,82,0.2);
        }
        .stepper-header { margin-bottom: 1rem; font-size: 0.92rem; }
        .stepper-sub { color: rgba(255,255,255,0.6) !important; }
        .stepper-steps { display: flex; align-items: center; gap: 0; }
        .stepper-step {
            display: flex; flex-direction: column; align-items: center; gap: 6px; flex-shrink: 0;
        }
        .step-circle {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem; color: rgba(255,255,255,0.5);
            transition: all 0.3s ease;
        }
        .stepper-step.done .step-circle {
            background: #16a34a; border-color: #16a34a; color: white;
        }
        .stepper-step.active .step-circle {
            background: #EAE0CF; border-color: #EAE0CF; color: #1B3A52;
            box-shadow: 0 0 0 4px rgba(234,224,207,0.25);
            animation: pulse-step 1.8s infinite;
        }
        @keyframes pulse-step {
            0%, 100% { box-shadow: 0 0 0 4px rgba(234,224,207,0.25); }
            50%       { box-shadow: 0 0 0 8px rgba(234,224,207,0.1); }
        }
        .step-label {
            font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,0.55);
            text-align: center; white-space: nowrap;
        }
        .stepper-step.active .step-label,
        .stepper-step.done  .step-label { color: rgba(255,255,255,0.9); }
        .stepper-line {
            flex: 1; height: 2px; background: rgba(255,255,255,0.15);
            margin-bottom: 22px; transition: background 0.3s;
        }
        .stepper-line.done { background: #16a34a; }
        @media (max-width: 576px) {
            .stepper-sub { display: none; }
            .onboarding-stepper { padding: 0.85rem 1rem; }
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
            <div class="sidebar-logo-wrap">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h5>Sistem Alumni</h5>
            <span class="sidebar-badge">SD Muhammadiyah Birrul Walidain</span>
        </div>

        <nav class="mt-2">
            <div class="nav-section-label">Menu Utama</div>

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
        </nav>

        <div class="sidebar-footer">
            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="nav-link nav-link-danger text-start w-100 border-0 bg-transparent">
                        <i class="bi bi-power"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div id="app">
        <div class="main-content">

            {{-- TOPBAR --}}
            <header class="topbar">
                <div class="topbar-left">
                    <button class="mobile-toggle" id="btnToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4>@yield('title', 'Dashboard')</h4>
                </div>

                @php
                    $notifications = Auth::user()->notifications->take(10);
                    $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
                @endphp

                <div class="dropdown me-2">
                    <button class="btn btn-light position-relative border-0 rounded-circle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5 text-primary"></i>
                        @if($unreadNotificationsCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                            <strong>Notifikasi</strong>
                            <form action="{{ route('alumni.notifications.readAll') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link btn-sm p-0 text-primary">Tandai semua dibaca</button>
                            </form>
                        </div>
                        @forelse($notifications as $notification)
                            <div class="dropdown-item px-3 py-3 border-bottom">
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <div class="fw-semibold">{{ data_get($notification, 'data.title') }}</div>
                                        <div class="small text-muted">{{ data_get($notification, 'data.message') }}</div>
                                        <div class="small text-secondary mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(is_null($notification->read_at))
                                        <button type="button" class="btn btn-link btn-sm p-0 text-primary" onclick="markRead('{{ $notification->id }}')">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-3 py-4 text-center text-muted small">Tidak ada notifikasi.</div>
                        @endforelse
                    </div>
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
                        style="min-width: 200px;">
                        <li class="p-1">
                            <a class="dropdown-item py-2" href="{{ route('alumni.profile.edit') }}">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider opacity-50 my-1"></li>
                        <li class="p-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="content-body">

                {{-- ═══ ONBOARDING STEPPER (P2-5) ════════════════════════════════
                     Tampil otomatis di halaman profil & testimoni saat onboarding.
                     Disembunyikan setelah onboarding selesai.
                ════════════════════════════════════════════════════════════════ --}}
                @php
                    $alumniUser  = Auth::user()->alumni ?? null;
                    $isComplete  = $alumniUser?->is_profile_complete ?? false;
                    $hasTestimoni = $alumniUser
                        ? \App\Models\Testimoni::where('alumni_id', $alumniUser->id)->exists()
                        : false;
                    $onProfilePage     = request()->routeIs('alumni.profile.edit');
                    $onTestimonialPage = request()->routeIs('alumni.testimonial.form');
                    $showStepper       = $onProfilePage || $onTestimonialPage;
                    $step              = $onProfilePage ? 2 : ($onTestimonialPage ? 3 : 0);
                @endphp

                @if($showStepper)
                <div class="onboarding-stepper mx-4 mt-3 mb-1">
                    <div class="stepper-header">
                        <i class="bi bi-lightning-charge-fill me-2 text-warning"></i>
                        <strong>Aktivasi Akun</strong>
                        <span class="stepper-sub ms-2 text-muted small">— Selesaikan langkah berikut untuk mengaktifkan akun Anda</span>
                    </div>
                    <div class="stepper-steps">
                        {{-- Step 1: Login --}}
                        <div class="stepper-step done">
                            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
                            <div class="step-label">Login</div>
                        </div>
                        <div class="stepper-line done"></div>

                        {{-- Step 2: Profil --}}
                        <div class="stepper-step {{ $step >= 2 ? ($isComplete ? 'done' : 'active') : '' }}">
                            <div class="step-circle">{{ $isComplete ? '' : '2' }}@if($isComplete)<i class="bi bi-check-lg"></i>@endif</div>
                            <div class="step-label">Lengkapi Profil</div>
                        </div>
                        <div class="stepper-line {{ $isComplete ? 'done' : '' }}"></div>

                        {{-- Step 3: Testimoni --}}
                        <div class="stepper-step {{ $onTestimonialPage ? 'active' : ($hasTestimoni ? 'done' : '') }}">
                            <div class="step-circle">{{ $hasTestimoni ? '' : '3' }}@if($hasTestimoni)<i class="bi bi-check-lg"></i>@endif</div>
                            <div class="step-label">Testimoni</div>
                        </div>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Toggle --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            if (!sidebar || !overlay) return;
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        // Use event delegation because Vue might replace the DOM element
        document.addEventListener('click', function(e) {
            // Check if toggle button or its children (like the icon) was clicked
            if (e.target.closest('#btnToggle')) {
                toggleSidebar();
            }
            // Check if overlay was clicked
            else if (e.target === overlay) {
                toggleSidebar();
            }
            // Auto-close sidebar on nav link click (mobile)
            else if (window.innerWidth < 992 && e.target.closest('.sidebar .nav-link')) {
                if (sidebar && sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            }
        });
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

    <script>
        function markRead(id) {
            const url = "{{ route('alumni.notifications.read', ['id' => '__ID__']) }}".replace('__ID__', id);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            }).finally(() => window.location.reload());
        }
    </script>

    {{-- PWA Service Worker Registration --}}
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }
    </script>
</body>
</html>
