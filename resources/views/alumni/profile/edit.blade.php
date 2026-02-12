@extends('layouts.alumni')

@section('title', 'Edit Profil')

@section('content')
<div class="row g-4">
    {{-- SISI KIRI: FORM UTAMA --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm custom-radius">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-light text-primary me-3">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Profil Alumni</h5>
                        <p class="text-muted small mb-0">Perbarui informasi diri dan riwayat Anda</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 pt-0">
                {{-- ERROR MESSAGES --}}
                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-3 mt-1"></i>
                        <div>
                            <strong class="d-block mb-1">Terjadi kesalahan:</strong>
                            <ul class="mb-0 px-3 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('alumni.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- DATA IDENTITAS --}}
                    <div class="section-title mb-3">
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Data Identitas</span>
                        <small class="text-muted ms-2">(Read-Only)</small>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">NISN</label>
                            <input type="text" class="form-control bg-light border-0 py-2" value="{{ $alumni->nisn }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light border-0 py-2" value="{{ $alumni->nama_lengkap }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Angkatan</label>
                            <input type="text" class="form-control bg-light border-0 py-2" value="{{ $alumni->angkatan->nama_angkatan ?? '-' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tahun Lulus Sekolah</label>
                            <input type="text" class="form-control bg-light border-0 py-2" value="{{ $alumni->tahun_lulus }}" disabled>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    {{-- DATA KONTAK --}}
                    <div class="section-title mb-3">
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Data Kontak & Dasar</span>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Foto Profil</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror shadow-none"
                               name="foto" accept="image/*" onchange="previewImage(event)">
                        <div class="form-text small opacity-75">Format: JPG, PNG, WEBP • Maks 2MB</div>
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Alamat Saat Ini <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror shadow-none"
                                  name="alamat" rows="3" required placeholder="Alamat lengkap domisili">{{ old('alamat', $alumni->alamat) }}</textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-phone"></i></span>
                                <input type="tel" class="form-control border-start-0 shadow-none @error('no_hp') is-invalid @enderror"
                                       name="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" required
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14" placeholder="08xxxxxxxx">
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input shadow-none" type="checkbox" name="show_no_hp" id="show_no_hp" value="1" {{ old('show_no_hp', $alumni->show_no_hp) ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="show_no_hp">Tampilkan nomor di profil</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control border-start-0 shadow-none"
                                       name="email" value="{{ old('email', $alumni->user->email ?? $alumni->email) }}" placeholder="nama@email.com">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    {{-- PENDIDIKAN --}}
                    <div class="section-title mb-3">
                        <span class="text-primary fw-bold small text-uppercase tracking-wider">Riwayat Pendidikan</span>
                    </div>
                    <div id="education-container">
                        @php $jenjangWajib = ['SMP/MTS', 'SMA/MA/SMK', 'Perguruan Tinggi']; @endphp
                        @foreach($jenjangWajib as $key => $jenjang)
                            @php
                                $eduData = $alumni->pendidikan->where('jenjang', $jenjang)->first();
                                $isOngoingValue = old("pendidikan.$key.is_ongoing", $eduData->is_ongoing ?? 0);
                            @endphp
                            <div class="education-item border-0 bg-light p-3 mb-3 custom-radius-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-dark small mb-0"><i class="bi bi-mortarboard me-2 text-primary"></i> {{ $jenjang }}</h6>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="pendidikan[{{ $key }}][is_ongoing]" value="0">
                                        <input class="form-check-input status-studi shadow-none" type="checkbox"
                                               name="pendidikan[{{ $key }}][is_ongoing]" value="1"
                                               id="ongoing-{{ $key }}" data-index="{{ $key }}" {{ $isOngoingValue == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold text-muted" for="ongoing-{{ $key }}">Masih Belajar</label>
                                    </div>
                                </div>
                                <input type="hidden" name="pendidikan[{{ $key }}][jenjang]" value="{{ $jenjang }}">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" name="pendidikan[{{ $key }}][nama_instansi]"
                                               class="form-control form-control-sm border-0 instansi-input" data-jenjang="{{ $jenjang }}"
                                               value="{{ old("pendidikan.$key.nama_instansi", $eduData->nama_instansi ?? '') }}" placeholder="Nama Sekolah/Kampus">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="pendidikan[{{ $key }}][tahun_masuk]" class="form-control form-control-sm border-0"
                                               value="{{ old("pendidikan.$key.tahun_masuk", $eduData->tahun_masuk ?? '') }}" placeholder="Thn Masuk">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="pendidikan[{{ $key }}][tahun_lulus]" id="tahun-lulus-{{ $key }}"
                                               class="form-control form-control-sm border-0" value="{{ old("pendidikan.$key.tahun_lulus", $eduData->tahun_lulus ?? '') }}" placeholder="Thn Lulus">
                                    </div>
                                    @if($jenjang === 'Perguruan Tinggi')
                                        <div class="col-md-12 mt-2 {{ (empty($eduData->nama_instansi) && !old('pendidikan.'.$key.'.nama_instansi')) ? 'd-none' : '' }}" id="prodi-wrapper-{{ $key }}">
                                            <input type="text" name="pendidikan[{{ $key }}][program_studi]" class="form-control form-control-sm border-0"
                                                   value="{{ old("pendidikan.$key.program_studi", $eduData->program_studi ?? '') }}" placeholder="Program Studi (Contoh: Teknik Informatika)">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PEKERJAAN --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                        <div class="section-title m-0">
                            <span class="text-primary fw-bold small text-uppercase tracking-wider">Riwayat Pekerjaan</span>
                        </div>
                        <button type="button" id="add-work" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </button>
                    </div>

                    <div id="work-container">
                        @forelse($alumni->pekerjaan as $index => $job)
                            <div class="work-item border-0 bg-light p-3 mb-3 custom-radius-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="pekerjaan[{{ $index }}][is_current]" value="0">
                                        <input class="form-check-input shadow-none" type="checkbox" name="pekerjaan[{{ $index }}][is_current]" value="1" {{ $job->is_current ? 'checked' : '' }}>
                                        <label class="form-check-label small text-muted">Pekerjaan Saat Ini</label>
                                    </div>
                                    <button type="button" class="btn btn-link text-danger btn-sm p-0 text-decoration-none" onclick="deletePekerjaan({{ $job->id }}, this)">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" name="pekerjaan[{{ $index }}][nama_perusahaan]" class="form-control form-control-sm border-0" value="{{ $job->nama_perusahaan }}" placeholder="Perusahaan" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="pekerjaan[{{ $index }}][jabatan]" class="form-control form-control-sm border-0" value="{{ $job->jabatan }}" placeholder="Jabatan" required>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="work-empty-placeholder" class="text-center py-4 text-muted bg-light border-dashed custom-radius-sm mb-3">
                                <i class="bi bi-briefcase fs-3 d-block mb-2 opacity-50"></i>
                                <p class="small mb-0">Belum ada data pekerjaan.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Pesan & Harapan Untuk Sekolah</label>
                        <textarea class="form-control shadow-none" name="harapan" rows="3" placeholder="Tuliskan pesan Anda...">{{ old('harapan', $alumni->harapan) }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-5">
                        <a href="{{ route('alumni.dashboard') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SISI KANAN: PREVIEW & PASSWORD --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm custom-radius text-center mb-4">
            <div class="card-body py-5">
                @php $fotoUtama = $alumni->fotos->where('is_main', true)->first(); @endphp
                <div class="position-relative d-inline-block mb-3">
                    <img id="previewFoto"
                        src="..."
                        class="rounded-circle shadow-sm border-5 border-white"
                        style="width: 140px; height: 140px; object-fit: cover;">
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $alumni->nama_lengkap }}</h5>
                <p class="text-muted small mb-0">Preview Foto Profil</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm custom-radius">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 d-flex align-items-center">
                    <span class="icon-box-sm bg-warning-light text-warning me-2">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    Keamanan Akun
                </h6>
                <form action="{{ route('alumni.profile.updatePassword') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <input type="password" name="current_password" class="form-control form-control-sm shadow-none @error('current_password') is-invalid @enderror" placeholder="Password Saat Ini" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-sm shadow-none" placeholder="Password Baru" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control form-control-sm shadow-none" placeholder="Ulangi Password Baru" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white shadow-sm mt-2">
                        Perbarui Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Utility */
    .custom-radius { border-radius: 1rem; }
    .custom-radius-sm { border-radius: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Icon Boxes */
    .icon-box { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.25rem; }
    .icon-box-sm { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.9rem; }

    /* Colors (Lightened versions for backgrounds) */
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }

    /* Inputs */
    .form-control { border: 1px solid #e9ecef; padding: 0.6rem 1rem; }
    .form-control:focus { border-color: #0d6efd; background-color: #fff; }
    .form-control-sm { padding: 0.5rem 0.75rem; }
    .border-dashed { border: 2px dashed #dee2e6; }

    /* Section Title Line */
    .section-title { border-left: 4px solid #0d6efd; padding-left: 10px; margin-bottom: 20px; }

    /* Button Animations */
    .btn { transition: all 0.3s ease; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25); }
</style>

<script>
    // Logic tetap sama, hanya memoles interaksi sedikit
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = () => document.getElementById('previewFoto').src = reader.result;
        if (event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
    }

    function deletePekerjaan(id, btn) {
        if (confirm('Hapus riwayat pekerjaan ini?')) {
            const form = document.getElementById('delete-pekerjaan-form');
            form.action = "{{ url('alumni/riwayat-pekerjaan') }}/" + id;
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Prodi Visibility
        document.querySelectorAll('.instansi-input[data-jenjang="Perguruan Tinggi"]').forEach((ptInput) => {
            const index = ptInput.closest('.education-item').querySelector('.status-studi').getAttribute('data-index');
            const prodiWrapper = document.getElementById(`prodi-wrapper-${index}`);
            ptInput.addEventListener('input', () => {
                ptInput.value.trim() !== "" ? prodiWrapper.classList.remove('d-none') : prodiWrapper.classList.add('d-none');
            });
        });

        // Add Work Logic
        let workIndex = {{ $alumni->pekerjaan->count() }};
        document.getElementById('add-work').addEventListener('click', function() {
            const container = document.getElementById('work-container');
            const placeholder = document.getElementById('work-empty-placeholder');
            if (placeholder) placeholder.remove();

            const html = `
                <div class="work-item border-0 bg-light p-3 mb-3 custom-radius-sm animate__animated animate__fadeIn">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="pekerjaan[${workIndex}][is_current]" value="0">
                            <input class="form-check-input shadow-none" type="checkbox" name="pekerjaan[${workIndex}][is_current]" value="1">
                            <label class="form-check-label small text-muted">Pekerjaan Saat Ini</label>
                        </div>
                        <button type="button" class="btn btn-link text-danger btn-sm p-0 text-decoration-none remove-item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="pekerjaan[${workIndex}][nama_perusahaan]" class="form-control form-control-sm border-0" placeholder="Perusahaan" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="pekerjaan[${workIndex}][jabatan]" class="form-control form-control-sm border-0" placeholder="Jabatan" required>
                        </div>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            workIndex++;
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.remove-item')) {
                e.target.closest('.work-item').remove();
            }
        });
    });
</script>
@endsection
