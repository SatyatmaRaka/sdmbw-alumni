@extends('layouts.landing')

@section('title', 'Profil ' . $alumni->nama_lengkap)

@section('content')

<style>
    :root {
        --color-primary: #213448;
        --color-primary-light: #2d4a63;
        --color-bg: #f8f9fa;
    }

    .profile-header {
        background: white;
        padding: 3rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .breadcrumb-item a {
        color: var(--color-primary-light);
        font-weight: 500;
    }

    .badge-custom {
        padding: 0.6rem 1rem;
        font-weight: 600;
        border-radius: 8px;
        letter-spacing: 0.3px;
    }

    .badge-verified {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }

    .badge-primary-custom {
        background-color: var(--color-primary);
        color: white;
    }

    .card-profile {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(33, 52, 72, 0.05);
        transition: transform 0.3s ease;
    }

    .card-profile:hover {
        transform: translateY(-5px);
    }

    .section-title {
        color: var(--color-primary);
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: var(--color-primary);
        border-radius: 3px;
    }

    .data-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-value {
        color: var(--color-primary);
        font-weight: 600;
    }

    .harapan-box {
        background: white;
        border-left: 4px solid #fff;
        padding: 1.5rem;
        border-radius: 12px;
        position: relative;
    }

    .btn-contact {
        background: var(--color-primary);
        border: none;
        padding: 0.8rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .btn-contact:hover {
        background: var(--color-primary-light);
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(33, 52, 72, 0.2);
    }
</style>

{{-- ================= HEADER ================= --}}
<section class="profile-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('landing.direktori') }}" class="text-decoration-none">Direktori Alumni</a></li>
                <li class="breadcrumb-item active" aria-current="page text-muted">{{ $alumni->nama_lengkap }}</li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3" style="color: var(--color-primary);">{{ $alumni->nama_lengkap }}</h1>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="badge badge-custom badge-primary-custom">
                        <i class="bi bi-mortarboard-fill me-2"></i>{{ $alumni->angkatan->nama_angkatan ?? 'Tanpa Angkatan' }}
                    </span>

                    @if ($alumni->status_verifikasi === 'verified')
                        <span class="badge badge-custom badge-verified">
                            <i class="bi bi-patch-check-fill me-2"></i>Terverifikasi
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="d-inline-block p-3 rounded-circle bg-light">
                    <i class="bi bi-person-circle" style="font-size: 5.5rem; color: var(--color-primary); opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= PROFIL DETAIL ================= --}}
<section class="py-5" style="background-color: var(--color-bg);">
    <div class="container">
        <div class="row g-4">

            {{-- ===== KONTEN UTAMA ===== --}}
            <div class="col-lg-8">
                {{-- Data Pribadi --}}
                <div class="card card-profile mb-4">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="bi bi-person-vcard me-2"></i>Identitas Alumni
                        </h5>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="data-label d-block">NISN</label>
                                <span class="data-value fs-5">{{ $alumni->nisn ?? '-' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="data-label d-block">Tahun Ajaran</label>
                                <span class="data-value fs-5">{{ $alumni->angkatan->tahun_ajaran ?? '-' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="data-label d-block">Tahun Lulus</label>
                                <span class="data-value fs-5">{{ $alumni->tahun_lulus }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="data-label d-block">Status Kelengkapan</label>
                                @if($alumni->is_profile_complete)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Lengkap</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Belum Lengkap</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pendidikan & Pekerjaan --}}
                <div class="card card-profile">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="bi bi-briefcase me-2"></i>Karir & Pendidikan
                        </h5>

                        <div class="mb-4">
                            <label class="data-label d-block mb-1">Pendidikan Lanjutan</label>
                            <p class="data-value fs-5 mb-0">{{ $alumni->pendidikan_lanjutan ?? 'Tidak mencantumkan pendidikan lanjutan' }}</p>
                            <small class="text-muted">Instansi atau Universitas setelah lulus dari SDMBW.</small>
                        </div>

                        <div class="mb-0">
                            <label class="data-label d-block mb-1">Kesibukan Saat Ini</label>
                            <p class="data-value fs-5 mb-0">{{ $alumni->pekerjaan ?? 'Belum bekerja / Mencari Pekerjaan' }}</p>
                            <small class="text-muted">Bidang pekerjaan atau profesi yang sedang ditekuni.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== SIDEBAR ===== --}}
            <div class="col-lg-4">
                {{-- Harapan --}}
                <div class="card card-profile mb-4" style="background: var(--color-primary);">
                    <div class="card-body p-4 text-white">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-chat-left-quote-fill me-2 text-info"></i> Harapan & Pesan
                        </h6>
                        <div class="harapan-box text-dark">
                            @php $isiHarapan = trim($alumni->harapan); @endphp

                            @if (!empty($isiHarapan))
                                <p class="fst-italic mb-0" style="line-height: 1.7; color: var(--color-primary);">
                                    "{{ $isiHarapan }}"
                                </p>
                            @else
                                <p class="text-muted small mb-0">Alumni ini belum menuliskan pesan atau harapan untuk sekolah.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="card card-profile">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3 text-start">Hubungi Alumni</h6>
                        <p class="text-muted small text-start mb-4">Ingin menjalin silaturahmi atau kerjasama profesional?</p>

                        @if ($alumni->email)
                            <a href="mailto:{{ $alumni->email }}" class="btn btn-contact btn-primary w-100 shadow-sm">
                                <i class="bi bi-envelope-paper-fill me-2"></i>Kirim Email
                            </a>
                        @else
                            <div class="p-3 rounded-3 bg-light text-muted small">
                                <i class="bi bi-lock-fill me-1"></i> Informasi kontak tidak tersedia secara publik.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
