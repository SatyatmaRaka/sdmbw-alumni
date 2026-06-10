@extends('layouts.landing')

@section('title', 'Akses Ditolak (403)')

@section('content')
<div class="container my-5 py-5 d-flex align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="card text-center shadow-lg border-0 p-5" style="max-width: 600px; border-radius: var(--radius-md); background: #ffffff; border-top: 4px solid var(--color-accent) !important;">
        <div class="card-body">
            <div class="error-icon mb-4" style="color: var(--color-accent); font-size: 5rem;">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1 class="display-3 fw-bold mb-3" style="font-family: 'DM Serif Display', serif; color: var(--color-primary-dark);">403</h1>
            <h3 class="h4 fw-bold mb-3" style="color: var(--color-primary);">Akses Ditolak / Dilarang</h3>
            <p class="text-muted mb-4">Maaf, Anda tidak memiliki izin atau hak akses untuk membuka halaman ini. Silakan kembali ke halaman utama.</p>
            <a href="{{ url('/') }}" class="btn btn-navbar-accent d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
