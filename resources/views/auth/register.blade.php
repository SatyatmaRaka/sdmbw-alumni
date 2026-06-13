<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi - Sistem Alumni SDMBW</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            background: #112534;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at 15% 50%, rgba(42,83,120,0.6) 0%, transparent 55%);
            pointer-events: none;
        }
        .btn-back-home {
            position: fixed;
            top: 20px; left: 20px;
            z-index: 100;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-weight: 600;
            background: rgba(255,255,255,0.1);
            padding: 8px 20px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .login-card-premium { width: 100%; max-width: 500px; background: white; border-radius: 30px; box-shadow: 0 25px 60px rgba(0,0,0,0.12); overflow: hidden; }
        .login-header { background: #1B3A52; }
        .header-glow { width: 300px; height: 300px; background: radial-gradient(circle, rgba(232, 200, 122, 0.2) 0%, transparent 70%); }
        
        .logo-wrap-premium { width: 64px; height: 64px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px; }
        .z-1 { z-index: 1; }
        .letter-spacing-1 { letter-spacing: 1px; }

        .input-group-premium { position: relative; display: flex; align-items: center; }
        .input-icon { position: absolute; left: 16px; color: #94a3b8; font-size: 1.1rem; z-index: 5; }
        .form-control-premium, .form-select-premium { 
            width: 100%; padding: 0.8rem 1rem 0.8rem 3rem; background: #f8fafc; border: 1.5px solid #e2e8f0; 
            border-radius: 16px; transition: all 0.2s ease; outline: none;
        }
        .form-control-premium:focus, .form-select-premium:focus { border-color: #1B3A52; background: white; box-shadow: 0 0 0 4px rgba(27, 58, 82, 0.1); }

        .btn-primary-premium { background: #1B3A52; color: white; border: none; transition: all 0.3s ease; }
        .btn-primary-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(27, 58, 82, 0.25); }

        .alert-premium-danger { background: #fee2e2; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 12px; color: #991b1b; }
        .alert-icon { font-size: 1.25rem; }
    </style>
</head>
<body>
    <a href="{{ route('landing.index') }}" class="btn-back-home">
        <i class="bi bi-arrow-left"></i> Beranda
    </a>

    <div class="w-100 d-flex justify-content-center my-5">
        <div class="login-card-premium animate__animated animate__zoomIn">
            <div class="login-header text-center py-5 position-relative overflow-hidden">
                <!-- Decorative Background -->
                <div class="header-glow position-absolute top-0 start-50 translate-middle-x"></div>
                
                <div class="position-relative z-1">
                    <div class="logo-wrap-premium mx-auto mb-4 d-flex align-items-center justify-content-center shadow-lg">
                        <i class="bi bi-person-vcard fs-2 text-white"></i>
                    </div>
                    <h2 class="h4 fw-bold text-white mb-1">Pendaftaran Alumni</h2>
                    <p class="small text-white text-opacity-50 mb-0">Lengkapi data Anda untuk mendaftar</p>
                </div>
            </div>

            <div class="login-body p-4 p-md-5 bg-white">
                @if(session('error'))
                    <div class="alert-premium-danger d-flex align-items-center gap-3 mb-4">
                        <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="small fw-bold">{{ session('error') }}</div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert-premium-danger d-flex align-items-start gap-3 mb-4">
                        <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="small fw-bold">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">NISN (10 Digit)</label>
                        <div class="input-group-premium">
                            <span class="input-icon"><i class="bi bi-123"></i></span>
                            <input type="text" name="nisn" class="form-control-premium" value="{{ old('nisn') }}" placeholder="Contoh: 0051234567" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Nama Lengkap</label>
                        <div class="input-group-premium">
                            <span class="input-icon"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control-premium" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap Anda" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Jenis Kelamin</label>
                            <div class="input-group-premium">
                                <span class="input-icon"><i class="bi bi-gender-ambiguous"></i></span>
                                <select name="jenis_kelamin" class="form-select-premium" required>
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih...</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Tahun Lulus</label>
                            <div class="input-group-premium">
                                <span class="input-icon"><i class="bi bi-calendar-event"></i></span>
                                <input type="number" name="tahun_lulus" class="form-control-premium" value="{{ old('tahun_lulus') }}" placeholder="Contoh: 2023" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Angkatan</label>
                        <div class="input-group-premium">
                            <span class="input-icon"><i class="bi bi-mortarboard"></i></span>
                            <select name="angkatan_id" class="form-select-premium" required>
                                <option value="" disabled {{ old('angkatan_id') ? '' : 'selected' }}>Pilih Angkatan Anda...</option>
                                @foreach($angkatans as $angkatan)
                                    <option value="{{ $angkatan->id }}" {{ old('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                                        {{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Password Baru</label>
                        <div class="input-group-premium">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" class="form-control-premium" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Konfirmasi Password</label>
                        <div class="input-group-premium">
                            <span class="input-icon"><i class="bi bi-shield-check"></i></span>
                            <input type="password" name="password_confirmation" class="form-control-premium" placeholder="Ulangi password Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-premium w-100 py-3 rounded-pill fw-bold shadow-lg mb-4">
                        Daftar Sekarang <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <p class="small text-muted mb-2">Sudah punya akun atau sudah terdaftar?</p>
                    <a href="{{ route('login') }}" class="text-success small fw-bold text-decoration-none d-inline-flex align-items-center gap-2 link-hover-move">
                        <i class="bi bi-box-arrow-in-right fs-5"></i> 🔑 Masuk ke Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
