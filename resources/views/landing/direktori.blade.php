@extends('layouts.alumni')

@section('title', 'Direktori Alumni')

@section('content')

<style>
    :root {
        --color-primary: #213448;
        --color-primary-light: #2d4a65;
        --color-bg-light: #f8fafc;
        --color-accent: #EAE0CF;
    }

    .page-title {
        color: var(--color-primary);
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    .card-custom {
        border-radius: 15px;
        background: #ffffff;
        border: none;
    }

    .custom-input {
        border: 1px solid #e2e8f0 !important;
        padding: 0.75rem 1rem !important;
        background-color: var(--color-bg-light) !important;
        border-radius: 10px !important;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        background-color: #fff !important;
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 0 4px rgba(33, 52, 72, 0.05) !important;
    }

    .hover-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 20px;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(33, 52, 72, 0.1) !important;
    }

    /* Perbaikan: Menggunakan Width tetap untuk mencegah penyusutan */
    .avatar-wrapper {
        width: 65px;
        min-width: 65px;
    }

    .avatar-circle {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 4px 10px rgba(33, 52, 72, 0.2);
    }

    .icon-wrapper {
        width: 35px;
        min-width: 35px;
    }

    .icon-box {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .badge-angkatan {
        background-color: rgba(33, 52, 72, 0.08);
        color: var(--color-primary);
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-primary-custom {
        background: var(--color-primary);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        padding: 10px 20px;
        transition: all 0.3s;
    }

    .btn-primary-custom:hover {
        background: var(--color-primary-light);
        transform: scale(1.02);
        color: white;
    }

    .btn-outline-primary-custom {
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        border-radius: 12px;
        transition: all 0.3s;
    }

    .btn-outline-primary-custom:hover {
        background: var(--color-primary);
        color: white;
    }

    .pagination .page-link {
        border-radius: 10px !important;
        margin: 0 4px;
        border: none;
        background-color: #f1f5f9;
        color: var(--color-primary);
        font-weight: 700;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--color-primary);
        color: white;
    }

    .text-label-small {
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #94a3b8;
    }
</style>

<div class="mb-4">
    <h3 class="page-title">Direktori Alumni</h3>
    <p class="text-muted">Temukan dan terhubung dengan rekan alumni lintas angkatan.</p>
</div>

{{-- Filter Card --}}
<div class="card-custom border-0 shadow-sm mb-5">
    <div class="card-body p-4">
        <h6 class="mb-4 fw-bold text-uppercase" style="color: var(--color-primary); letter-spacing: 1.5px;">
            <i class="bi bi-funnel-fill me-2"></i>Filter Pencarian
        </h6>
        <form action="{{ route('landing.direktori') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-label-small fw-bold">ANGKATAN</label>
                    <select name="angkatan_id" class="form-select custom-input">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->id }}" {{ request('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                                {{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label text-label-small fw-bold">CARI NAMA / NISN</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 custom-input">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 custom-input"
                               placeholder="Masukkan nama atau NISN..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary-custom w-100 py-2 shadow-sm">
                        <i class="bi bi-search me-2"></i>Cari Alumni
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($alumnis->count() > 0)
    <div class="row g-4 mb-5">
        @foreach($alumnis as $alumni)
        <div class="col-md-6 col-lg-4">
            <div class="card-custom h-100 border-0 shadow-sm hover-card">
                <div class="card-body p-4">
                    {{-- Profile Header - Menggunakan wrapper lebar tetap --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-wrapper">
                            <div class="avatar-circle">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3 overflow-hidden">
                            <h5 class="mb-1 fw-bold text-dark text-truncate">
                                {{ $alumni->nama_lengkap }}
                            </h5>
                            <span class="badge badge-angkatan px-3 py-2">
                                <i class="bi bi-mortarboard-fill me-1"></i> {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <hr class="opacity-10 mb-4">

                    {{-- Profile Info - Menggunakan wrapper lebar tetap --}}
                    <div class="info-list mb-4">
                        <div class="d-flex mb-3 align-items-start">
                            <div class="icon-wrapper">
                                <div class="icon-box text-primary bg-light">
                                    <i class="bi bi-building"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <small class="text-label-small d-block fw-bold">PENDIDIKAN</small>
                                <span class="text-dark small fw-semibold">{{ $alumni->pendidikan_lanjutan ?? 'Belum diperbarui' }}</span>
                            </div>
                        </div>

                        <div class="d-flex mb-2 align-items-start">
                            <div class="icon-wrapper">
                                <div class="icon-box text-success bg-light">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <small class="text-label-small d-block fw-bold">PEKERJAAN</small>
                                <span class="text-dark small fw-semibold">{{ $alumni->pekerjaan ?? 'Belum diperbarui' }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('landing.profil', $alumni->id) }}"
                       class="btn btn-outline-primary-custom w-100 py-2 fw-bold">
                        Lihat Profil <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center pb-5 pagination-wrapper">
        {{ $alumnis->links() }}
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-person-exclamation display-1 text-muted opacity-25"></i>
        </div>
        <h4 class="fw-bold text-muted">Data Tidak Ditemukan</h4>
        <p class="text-muted mb-4">Kami tidak menemukan alumni dengan kriteria pencarian tersebut.</p>
        <a href="{{ route('landing.direktori') }}" class="btn btn-primary-custom px-5">
            <i class="bi bi-arrow-clockwise me-2"></i>Reset Pencarian
        </a>
    </div>
@endif

@endsection
