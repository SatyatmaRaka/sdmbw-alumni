@extends('layouts.admin')

@section('title', 'Manajemen Berita')
@section('page-title', 'Kelola Berita')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold d-flex align-items-center">
                <i class="bi bi-newspaper text-primary me-2"></i> Daftar Berita
            </h5>
            <p class="text-muted small mb-0 mt-1">Kelola berita dan informasi terbaru untuk publik</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
            <i class="bi bi-plus-lg me-1"></i> Tambah Berita
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead class="text-muted small text-uppercase fw-bold bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="width: 15%;">Tanggal</th>
                        <th class="py-3" style="width: 30%;">Judul</th>
                        <th class="py-3" style="width: 35%;">Konten</th>
                        <th class="py-3" style="width: 10%;">Status</th>
                        <th class="pe-4 py-3 text-end" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $berita)
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="text-muted small">{{ $berita->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="py-3 fw-bold text-primary">
                            <div class="d-flex align-items-center gap-3">
                                @if($berita->image)
                                    <img src="{{ asset('storage/' . $berita->image) }}" class="rounded-3 border object-fit-cover shadow-sm" style="width: 60px; height: 40px;">
                                @else
                                    <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px; font-size: 0.8rem;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div>
                                    {{ $berita->title }}
                                    <div class="text-muted small fw-normal">Slug: <span class="font-monospace text-secondary">{{ $berita->slug }}</span></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-muted small text-break">
                            {{ Str::limit($berita->content, 120) }}
                        </td>
                        <td class="py-3">
                            @if($berita->is_active)
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">Nonaktif</span>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light text-primary rounded-start-pill" data-bs-toggle="modal" data-bs-target="#modalEditBerita{{ $berita->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.beritas.destroy', $berita) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-end-pill">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="modalEditBerita{{ $berita->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow rounded-4">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="fw-bold mb-0">Edit Berita</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.beritas.update', $berita) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        @if($berita->image)
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted d-block">Foto Saat Ini</label>
                                            <img src="{{ asset('storage/' . $berita->image) }}" class="rounded-3 border mb-2 object-fit-cover shadow-sm" style="height: 100px; width: 150px;">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Judul Berita</label>
                                            <input type="text" name="title" class="form-control rounded-3" value="{{ $berita->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Konten Berita</label>
                                            <textarea name="content" class="form-control rounded-3" rows="8" required>{{ $berita->content }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Foto Berita (Baru)</label>
                                            <input type="file" name="image" class="form-control rounded-3 image-input" accept="image/*">
                                            <div class="form-text text-muted small">Format: JPG, PNG, WEBP. Maks: 3MB.</div>
                                            <div class="mt-2 preview-container d-none">
                                                <img src="" class="img-thumbnail rounded-3 img-preview" style="max-height: 140px;">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted d-block">Status Aktif</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $berita->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label small">Tampilkan di Web Publik</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada data berita.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="small text-muted mb-2 mb-md-0">
                Menampilkan {{ $beritas->firstItem() ?? 0 }} sampai {{ $beritas->lastItem() ?? 0 }} dari {{ $beritas->total() }} berita
            </div>
            {{ $beritas->links() }}
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.beritas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Judul Berita</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="Contoh: Kegiatan Reuni Akbar Alumni 2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Konten Berita</label>
                        <textarea name="content" class="form-control rounded-3" rows="8" placeholder="Tulis isi berita lengkap di sini..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Foto Berita</label>
                        <input type="file" name="image" class="form-control rounded-3 image-input" accept="image/*">
                        <div class="form-text text-muted small">Format: JPG, PNG, WEBP. Maks: 3MB.</div>
                        <div class="mt-2 preview-container d-none">
                            <img src="" class="img-thumbnail rounded-3 img-preview" style="max-height: 140px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted d-block">Status Aktif</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <label class="form-check-label small">Tampilkan di Web Publik</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Progress Upload -->
<div class="modal fade" id="modalUploadProgress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 p-4 text-center">
            <h5 class="fw-bold mb-3 text-primary">Mengunggah Berita...</h5>
            
            <!-- Grayscale vs Color Progress Image Container -->
            <div class="upload-animation-container position-relative mx-auto mb-4" style="width: 280px; height: 180px; overflow: hidden; border-radius: 14px; background: #f1f5f9; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(0,0,0,0.06);">
                <!-- Grayscale layer (background) -->
                <img id="progressPreviewGrayscale" src="" class="position-absolute w-100 h-100 object-fit-cover" style="filter: grayscale(100%); opacity: 0.4; top:0; left:0;">
                
                <!-- Color layer (foreground) -->
                <img id="progressPreviewColor" src="" class="position-absolute w-100 h-100 object-fit-cover" style="clip-path: inset(0 100% 0 0); transition: clip-path 0.08s ease-out; top:0; left:0;">
            </div>
            
            <div class="progress rounded-pill mb-3" style="height: 10px; background-color: #f1f5f9;">
                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
            </div>
            
            <div id="uploadProgressText" class="fw-bold text-primary fs-5 mb-0">0%</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar terpilih
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const container = this.closest('.mb-3').querySelector('.preview-container');
            const img = container.querySelector('.img-preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                container.classList.add('d-none');
            }
        });
    });

    // Intersepsi form submission dengan progress upload animasi
    document.querySelectorAll('form').forEach(form => {
        const action = form.getAttribute('action');
        if (action && (action.includes('/admin/beritas') || action.includes('/admin/berita'))) {
            // Abaikan form DELETE
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput && methodInput.value === 'DELETE') return;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const fileInput = form.querySelector('input[type="file"]');
                const file = fileInput ? fileInput.files[0] : null;
                
                const progressModalEl = document.getElementById('modalUploadProgress');
                const progressModal = new bootstrap.Modal(progressModalEl);
                const progressBar = document.getElementById('uploadProgressBar');
                const progressText = document.getElementById('uploadProgressText');
                const colorImg = document.getElementById('progressPreviewColor');
                const grayImg = document.getElementById('progressPreviewGrayscale');
                
                // Set preview di progress modal
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        colorImg.src = e.target.result;
                        grayImg.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Fallback gambar sekolah jika tidak upload gambar
                    const fallbackSrc = "{{ asset('images/bw-sekolah.webp') }}";
                    colorImg.src = fallbackSrc;
                    grayImg.src = fallbackSrc;
                }
                
                // Reset progress
                progressBar.style.width = '0%';
                progressText.innerText = '0%';
                colorImg.style.clipPath = 'inset(0 100% 0 0)';
                
                // Sembunyikan modal tambah/edit yang sedang terbuka agar tidak tumpang tindih
                const activeModalEl = form.closest('.modal');
                if (activeModalEl) {
                    const activeModal = bootstrap.Modal.getInstance(activeModalEl);
                    if (activeModal) activeModal.hide();
                }
                
                progressModal.show();
                
                // Build FormData
                const formData = new FormData(form);
                
                // Submit via Axios
                window.axios.post(action, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function(progressEvent) {
                        if (progressEvent.total) {
                            const percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            progressBar.style.width = percent + '%';
                            progressText.innerText = percent + '%';
                            
                            // Animasi transisi grayscale ke color dari kiri ke kanan
                            colorImg.style.clipPath = `inset(0 ${100 - percent}% 0 0)`;
                        }
                    }
                })
                .then(response => {
                    progressBar.style.width = '100%';
                    progressText.innerText = '100%';
                    colorImg.style.clipPath = 'inset(0 0% 0 0)';
                    
                    setTimeout(() => {
                        progressModal.hide();
                        if (response.data.success) {
                            if (window.showToast) {
                                window.showToast(response.data.message, 'success');
                            }
                            setTimeout(() => {
                                window.location.href = response.data.redirect;
                            }, 800);
                        } else {
                            window.location.reload();
                        }
                    }, 800);
                })
                .catch(error => {
                    progressModal.hide();
                    console.error(error);
                    
                    let errorMsg = 'Gagal menyimpan berita.';
                    if (error.response && error.response.data && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        errorMsg = Object.values(errors).flat().join('<br>');
                    } else if (error.response && error.response.data && error.response.data.message) {
                        errorMsg = error.response.data.message;
                    }
                    
                    if (window.showToast) {
                        window.showToast(errorMsg, 'error', 6000);
                    } else {
                        alert(errorMsg);
                    }
                    
                    // Buka kembali modal form jika terjadi error
                    if (activeModalEl) {
                        const activeModal = new bootstrap.Modal(activeModalEl);
                        activeModal.show();
                    }
                });
            });
        }
    });
});
</script>
@endpush
@endsection
