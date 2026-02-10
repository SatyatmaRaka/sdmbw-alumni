@extends('layouts.landing')

@section('title', 'Direktori Alumni')

@section('content')
<style>
    :root {
        --primary: #213448;
        --primary-light: #2d4a65;
        --primary-dark: #152230;
        --accent: #EAE0CF;
        --danger: #dc3545;
        --success: #198754;
    }

    /* Hero Section */
    .hero-direktori {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 4rem 0;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }

    .hero-direktori::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(234, 224, 207, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-direktori h1 {
        color: white;
        font-weight: 800;
        font-size: 3rem;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
        font-family: 'Poppins', sans-serif;
    }

    .hero-direktori p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
    }

    .hero-badge {
        display: inline-block;
        background: var(--accent);
        color: var(--primary-dark);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(33, 52, 72, 0.12);
        margin-bottom: 3rem;
        border: 1px solid rgba(234, 224, 207, 0.3);
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-title i {
        font-size: 1.3rem;
    }

    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-group:last-child {
        margin-bottom: 0;
    }

    .filter-label {
        display: block;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.7rem;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        border: 2px solid rgba(33, 52, 72, 0.1);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(33, 52, 72, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .btn-filter {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(33, 52, 72, 0.2);
        color: white;
    }

    .btn-reset {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
        border: 2px solid var(--danger);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-reset:hover {
        background: var(--danger);
        color: white;
    }

    /* Alumni Cards */
    .alumni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .alumni-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(33, 52, 72, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(234, 224, 207, 0.2);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .alumni-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 32px rgba(33, 52, 72, 0.15);
        border-color: var(--accent);
    }

    .alumni-card-image {
        position: relative;
        height: 220px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .alumni-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .alumni-card-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alumni-card-image-placeholder i {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .alumni-card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--accent);
        color: var(--primary-dark);
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 10;
    }

    .alumni-card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .alumni-card-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .alumni-card-angkatan {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 0.35rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        width: fit-content;
    }

    .alumni-card-info {
        flex-grow: 1;
    }

    .alumni-card-item {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
        margin-bottom: 0.8rem;
        font-size: 0.95rem;
    }

    .alumni-card-item i {
        color: var(--primary);
        font-weight: 600;
        margin-top: 0.2rem;
        min-width: 20px;
    }

    .alumni-card-item-label {
        color: #666;
        font-weight: 500;
    }

    .alumni-card-item-value {
        color: var(--primary);
        font-weight: 600;
    }

    .alumni-card-footer {
        padding-top: 1rem;
        border-top: 1px solid rgba(33, 52, 72, 0.1);
        margin-top: auto;
    }

    .btn-profile {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(33, 52, 72, 0.2);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: rgba(33, 52, 72, 0.2);
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state h3 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #666;
    }

    /* Results Counter */
    .results-counter {
        color: #666;
        font-weight: 500;
        margin-bottom: 2rem;
        text-align: center;
    }

    /* Filter Row */
    @media (min-width: 768px) {
        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 1.5rem;
            align-items: flex-end;
        }
    }

    /* Responsive */
    @media (max-width: 767px) {
        .hero-direktori h1 {
            font-size: 2rem;
        }

        .alumni-grid {
            grid-template-columns: 1fr;
        }

        .btn-filter, .btn-reset {
            width: 100%;
        }
    }
</style>

<div class="hero-direktori">
    <div class="container">
        <div class="hero-badge">
            <i class="bi bi-people-fill"></i> JELAJAHI NETWORK
        </div>
        <h1>Direktori Alumni</h1>
        <p>Temukan dan terhubung dengan ribuan alumni SD Muhammadiyah Birrul Walidain Kudus</p>
    </div>
</div>

<div class="container">
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="bi bi-funnel-fill"></i>
            Cari Alumni
        </div>

        <form action="{{ route('public.direktori') }}" method="GET">
            <div class="filter-row">
                <!-- Search Nama -->
                <div class="filter-group">
                    <label class="filter-label"><i class="bi bi-person"></i> Cari Nama</label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan nama alumni..." value="{{ request('search') }}">
                </div>

                <!-- Filter Angkatan (Dinamis dari Database) -->
                <div class="filter-group">
                    <label class="filter-label"><i class="bi bi-mortarboard"></i> Angkatan</label>
                    <select name="angkatan" class="form-select">
                        <option value="">Semua Angkatan</option>
                        @forelse($angkatanList as $ang)
                            <option value="{{ $ang->id }}" {{ request('angkatan') == $ang->id ? 'selected' : '' }}>
                                {{ $ang->nama_angkatan }} ({{ $ang->tahun_ajaran }})
                            </option>
                        @empty
                            <option disabled>Tidak ada angkatan</option>
                        @endforelse
                    </select>
                </div>

                <!-- Buttons -->
                <div class="filter-group">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>

            <!-- Reset Button -->
            @if(request('search') || request('angkatan'))
                <div style="margin-top: 1rem;">
                    <a href="{{ route('public.direktori') }}" class="btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Results Counter -->
    @if($alumni->count() > 0)
        <div class="results-counter">
            Menampilkan <strong>{{ $alumni->count() }}</strong> dari <strong>{{ $alumni->total() }}</strong> alumni yang tersedia
        </div>
    @endif

    <!-- Alumni Grid -->
    @if($alumni->count() > 0)
        <div class="alumni-grid">
            @foreach($alumni as $item)
                <div class="alumni-card">
                    <!-- Card Image -->
                    <div class="alumni-card-image">
                        @php $fotoUtama = $item->fotos->where('is_main', true)->first(); @endphp

                        @if($fotoUtama)
                            <img src="{{ asset('storage/' . $fotoUtama->path_file) }}" alt="Foto {{ $item->nama_lengkap }}">
                        @else
                            <div class="alumni-card-image-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif

                        <div class="alumni-card-badge">
                            <i class="bi bi-check-circle-fill"></i> Verified
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="alumni-card-body">
                        <h5 class="alumni-card-name">{{ $item->nama_lengkap }}</h5>

                        <span class="alumni-card-angkatan">
                            <i class="bi bi-mortarboard-fill"></i> {{ $item->angkatan->nama_angkatan ?? '-' }}
                        </span>

                        <div class="alumni-card-info">
                            <div class="alumni-card-item">
                                <i class="bi bi-calendar-event"></i>
                                <div>
                                    <span class="alumni-card-item-label">Lulus:</span>
                                    <span class="alumni-card-item-value">{{ $item->tahun_lulus }}</span>
                                </div>
                            </div>

                            @if($item->email)
                                <div class="alumni-card-item">
                                    <i class="bi bi-envelope"></i>
                                    <div>
                                        <span class="alumni-card-item-label">Email:</span>
                                        <span class="alumni-card-item-value" style="font-size: 0.85rem;">{{ Str::limit($item->email, 20) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="alumni-card-footer">
                            <a href="{{ route('public.profil', $item) }}" class="btn-profile">
                                <i class="bi bi-eye"></i> Lihat Profil Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($alumni->hasPages())
            <div class="d-flex justify-content-center">
                {{ $alumni->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Tidak Ada Hasil</h3>
            <p>Alumni yang Anda cari tidak ditemukan. Coba ubah filter pencarian Anda.</p>
        </div>
    @endif
</div>

@endsection
