@extends('layouts.admin')

@section('title', 'Import Data Alumni')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-file-earmark-excel-fill text-success me-2"></i>Import Data Alumni
                        </h5>
                        <a href="{{ route('admin.alumni.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-4 mb-4" style="background: rgba(8, 145, 178, 0.08); border-left: 4px solid #0891b2 !important;">
                        <h6 class="fw-bold mb-3 text-info-emphasis"><i class="bi bi-info-circle-fill me-2"></i>Panduan Import Data Alumni</h6>
                        <ul class="mb-0 small ps-3 text-secondary" style="line-height: 1.6;">
                            <li>Gunakan format file <strong>.xlsx</strong> (Excel) untuk hasil terbaik.</li>
                            <li>Sangat disarankan menggunakan <strong>Template Resmi</strong> yang telah disediakan di bawah.</li>
                            <li>Sistem akan otomatis mendeteksi baris data Anda (biasanya dimulai setelah judul kolom).</li>
                            <li>Kolom wajib: <strong>Nama Lengkap, NISN (10 digit), Angkatan,</strong> dan <strong>Tahun Lulus</strong>.</li>
                            <li>Sistem akan <strong>otomatis membuatkan akun login</strong> untuk setiap alumni.</li>
                            <li>Username & Password default adalah <strong>NISN</strong> masing-masing alumni.</li>
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('admin.alumni.downloadTemplate') }}" class="btn btn-info text-white fw-bold px-4 rounded-pill shadow-sm">
                                <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i> Download Template Excel (.xlsx)
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold">Pilih File Excel <span class="text-danger">*</span></label>
                            <input class="form-control form-control-lg @error('file') is-invalid @enderror" type="file" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                <i class="bi bi-cloud-upload me-2"></i> Proses Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
