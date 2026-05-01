@extends('layouts.alumni')

@section('title', 'Berikan Testimoni')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 border-0 text-center">
                    <div class="icon-box-premium bg-primary text-white mx-auto mb-3">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Satu Langkah Lagi!</h4>
                    <p class="text-muted">Bagikan pengalaman berkesan Anda selama bersekolah di <br>SD Muhammadiyah Birrul Walidain</p>
                </div>

                <div class="card-body p-4 p-md-5 pt-0">
                    <form action="{{ route('alumni.testimonial.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold small text-muted text-uppercase">Pesan Testimoni</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                class="form-control rounded-4 border-0 bg-light p-4 @error('content') is-invalid @enderror" 
                                rows="6" 
                                placeholder="Contoh: Sekolah ini memberikan fondasi karakter yang sangat kuat bagi saya. Guru-gurunya sangat perhatian dan sabar..."
                                required
                                minlength="10"
                                maxlength="1000"
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2 small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Testimoni Anda akan ditampilkan di halaman depan website setelah diverifikasi oleh Admin.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-send-fill me-2"></i> Kirim Testimoni & Selesaikan Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">Kenapa ini wajib? Testimoni Anda sangat berharga bagi sekolah dan adik-adik kelas untuk terus termotivasi.</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-box-premium {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(27, 58, 82, 0.1);
    }
</style>
@endpush
@endsection
