@extends('layouts.alumni')

@section('title', 'Profil Alumni')

@section('content')
<style>
    :root {
        --color-primary: #213448;
        --color-primary-light: #2d4a65;
        --color-bg-light: #f8fafc;
        --color-accent: #EAE0CF;
    }

    /* Custom Card Styling */
    .card-custom {
        border-radius: 20px;
        background: #ffffff;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .card-header-custom {
        background-color: #fff;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
        border: none;
        font-weight: 700;
        color: var(--color-primary);
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
    }

    .card-header-custom i {
        font-size: 1.25rem;
        color: var(--color-primary-light);
    }

    /* Info Items */
    .info-item {
        background: #fcfdfe;
        padding: 1.2rem;
        border-radius: 15px;
        border: 1px solid #f1f5f9;
        height: 100%;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #fff;
        border-color: var(--color-primary-light);
        box-shadow: 0 5px 15px rgba(33, 52, 72, 0.05);
        transform: translateY(-2px);
    }

    .info-label {
        display: block;
        font-weight: 700;
        color: #94a3b8;
        font-size: 0.75rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        margin: 0;
        color: var(--color-primary);
        font-size: 1rem;
        font-weight: 600;
    }

    /* Status Badges */
    .badge-verified {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-angkatan-large {
        background: var(--color-primary);
        color: #fff;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Back Button */
    .btn-back {
        border: 2px solid #e2e8f0;
        color: var(--color-primary);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    .profile-avatar-container {
        position: relative;
        display: inline-block;
    }

    .profile-avatar-container img, .profile-avatar-placeholder {
        width: 130px;
        height: 130px;
        border-radius: 35px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .profile-avatar-placeholder {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="mb-4">
    <a href="{{ route('alumni.direktori') }}" class="btn-back shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Direktori
    </a>
</div>

<div class="row">
    {{-- Sidebar Profil --}}
    <div class="col-lg-4 mb-4">
        <div class="card-custom text-center p-4">
            <div class="card-body">
                <div class="mb-4 profile-avatar-container">
                    @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp
                    @if($fotoUtama)
                        <img src="{{ asset('storage/' . $fotoUtama->path_file) }}" alt="Foto Profil">
                    @else
                        <div class="profile-avatar-placeholder">
                            <i class="bi bi-person-fill" style="font-size: 4.5rem; color: white;"></i>
                        </div>
                    @endif
                </div>

                <h4 class="mb-2" style="color: var(--color-primary); font-weight: 800; font-family: 'Poppins', sans-serif;">
                    {{ $alumni->nama_lengkap }}
                </h4>

                <div class="mb-3">
                    <span class="badge badge-angkatan-large mb-2 shadow-sm">
                        <i class="bi bi-mortarboard-fill me-1"></i> {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                    </span>
                    <br>
                    @if($alumni->status_verifikasi === 'verified')
                        <span class="badge badge-verified shadow-sm">
                            <i class="bi bi-patch-check-fill me-1"></i> Alumni Terverifikasi
                        </span>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-top">
                    <p class="text-muted small mb-1">Tahun Kelulusan</p>
                    <h5 class="fw-bold" style="color: var(--color-primary);">{{ $alumni->tahun_lulus }}</h5>
                </div>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-header-custom border-bottom pb-3">
                <i class="bi bi-shield-check"></i> Status Akun
            </div>
            <div class="card-body py-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light p-2 rounded-3 me-3"><i class="bi bi-calendar-event text-primary"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">TERDAFTAR</small>
                        <strong class="small">{{ $alumni->created_at->format('d M Y') }}</strong>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-light p-2 rounded-3 me-3"><i class="bi bi-arrow-repeat text-success"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">PEMBARUAN TERAKHIR</small>
                        <strong class="small">{{ $alumni->updated_at->format('d M Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="col-lg-8">
        {{-- Data Pribadi --}}
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="bi bi-person-vcard-fill"></i> Data Identitas
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Nomor Induk (NISN)</label>
                            <p class="info-value">{{ $alumni->nisn }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Nama Lengkap</label>
                            <p class="info-value">{{ $alumni->nama_lengkap }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Angkatan & Tahun Ajaran</label>
                            <p class="info-value">
                                {{ $alumni->angkatan->nama_angkatan ?? '-' }}
                                <span class="text-muted fw-normal">({{ $alumni->angkatan->tahun_ajaran ?? '-' }})</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Tahun Lulus</label>
                            <p class="info-value">{{ $alumni->tahun_lulus }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item" style="border-left: 4px solid var(--color-accent);">
                            <label class="info-label">Pesan & Harapan Untuk Sekolah</label>
                            <p class="info-value fw-normal fst-italic">"{{ $alumni->harapan ?? 'Tidak ada pesan yang dibagikan.' }}"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="bi bi-telephone-inbound-fill"></i> Informasi Kontak
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="info-label">Alamat Domisili</label>
                            <p class="info-value">{{ $alumni->alamat ?? 'Alamat belum diatur' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Nomor WhatsApp</label>
                            <p class="info-value">
                                @if($alumni->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_hp) }}" class="text-decoration-none d-flex align-items-center gap-2" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i> {{ $alumni->no_hp }}
                                    </a>
                                @else - @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">Alamat Email</label>
                            <p class="info-value">
                                @if($alumni->email)
                                    <a href="mailto:{{ $alumni->email }}" class="text-decoration-none d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope-at text-primary"></i> {{ $alumni->email }}
                                    </a>
                                @else <span class="text-muted fst-italic small">Belum dipublikasikan</span> @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat --}}
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="bi bi-journal-bookmark-fill"></i> Riwayat Pendidikan & Karir
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="info-label mb-3">Pendidikan Lanjutan</label>
                        @forelse($alumni->pendidikan as $edu)
                            <div class="d-flex gap-3 mb-3 p-3 bg-light rounded-4">
                                <div class="text-primary"><i class="bi bi-mortarboard font-size-lg"></i></div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $edu->nama_instansi }}</h6>
                                    <p class="text-muted small mb-1">{{ $edu->jenjang }}</p>
                                    @if($edu->is_ongoing)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">Sedang Menempuh</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Lulus {{ $edu->tahun_lulus }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small fst-italic">Belum ada data riwayat pendidikan.</p>
                        @endforelse
                    </div>
                    <div class="col-12">
                        <label class="info-label mb-3">Pekerjaan Saat Ini</label>
                        @forelse($alumni->pekerjaan as $job)
                            <div class="d-flex gap-3 p-3 bg-light rounded-4">
                                <div class="text-success"><i class="bi bi-briefcase"></i></div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $job->nama_perusahaan }}</h6>
                                    <p class="text-dark small mb-0">{{ $job->jabatan }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small fst-italic">Belum ada data riwayat pekerjaan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
