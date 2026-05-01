<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Alumni SDMBW</title>

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
    </style>
</head>
<body>
    <a href="{{ route('landing.index') }}" class="btn-back-home">
        <i class="bi bi-arrow-left"></i> Beranda
    </a>

    <div id="app" class="w-100 d-flex justify-content-center">
        <login-form 
            action-url="{{ route('login') }}" 
            csrf-token="{{ csrf_token() }}"
            initial-error="{{ $errors->first('username') ?: session('error') }}">
        </login-form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
