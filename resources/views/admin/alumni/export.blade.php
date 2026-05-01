@extends('layouts.admin')

@section('title', 'Export Data Alumni')
@section('page-title', 'Export Data Alumni')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-file-earmark-excel-fill text-success me-2"></i>Export Data Excel
                </h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4">
                    Pilih filter di bawah ini untuk mengekspor data alumni ke dalam format Spreadsheet (Excel). 
                    Data akan diproses secara instan dan langsung terunduh ke komputer Anda.
                </p>

                <form action="{{ route('admin.alumni.export') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="angkatan_id" class="form-label fw-bold">Angkatan</label>
                        <select name="angkatan_id" id="angkatan_id" class="form-select">
                            <option value="">-- Semua Angkatan --</option>
                            @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan->id }}">{{ $angkatan->nama_angkatan }} ({{ $angkatan->tahun_ajaran }})</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="complete" class="form-label fw-bold">Kelengkapan Profil</label>
                        <select name="complete" id="complete" class="form-select">
                            <option value="">-- Semua Kelengkapan --</option>
                            <option value="1">Profil Lengkap</option>
                            <option value="0">Profil Belum Lengkap</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.alumni.index') }}" class="btn btn-light border px-4 rounded-pill fw-bold">Batal</a>
                        <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold">
                            <i class="bi bi-download me-1"></i> Mulai Ekspor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
