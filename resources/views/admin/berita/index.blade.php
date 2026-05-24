@extends('layouts.admin')

@section('title', 'Manajemen Berita')
@section('page-title', 'Kelola Berita')

@push('styles')
<!-- Quill snow theme CSS -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>
    .ql-container {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 0.95rem !important;
        border-bottom-left-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
        min-height: 200px;
    }
    .ql-toolbar {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
        background: #f8fafc;
    }
    .editor-wrapper {
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center pb-2">
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

    <!-- Search & Filter Form -->
    <div class="card-header bg-white border-0 pt-0 pb-4 px-4">
        <form action="{{ route('admin.beritas.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control bg-light border-0" placeholder="Cari judul atau konten berita..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-light border-0">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-secondary px-4 rounded-3 fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
                @if(request()->filled('q') || request()->filled('status'))
                    <a href="{{ route('admin.beritas.index') }}" class="btn btn-light px-3 rounded-3 text-muted"><i class="bi bi-x-lg"></i> Bersihkan</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead class="text-muted small text-uppercase fw-bold bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="width: 12%;">Tanggal</th>
                        <th class="py-3" style="width: 28%;">Judul</th>
                        <th class="py-3" style="width: 25%;">Konten</th>
                        <th class="py-3 text-center" style="width: 8%;">Featured</th>
                        <th class="py-3 text-center" style="width: 10%;">Views</th>
                        <th class="py-3" style="width: 8%;">Status</th>
                        <th class="pe-4 py-3 text-end" style="width: 9%;">Aksi</th>
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
                            @if($berita->excerpt)
                                <div class="fw-semibold text-dark mb-1">{{ Str::limit($berita->excerpt, 60) }}</div>
                            @endif
                            {{ Str::limit(strip_tags($berita->content), 100) }}
                        </td>
                        <td class="py-3 text-center">
                            <button class="btn btn-sm btn-link toggle-featured-btn" data-id="{{ $berita->id }}" data-url="{{ route('admin.beritas.toggle-featured', $berita) }}" title="Toggle Featured" style="text-decoration: none;">
                                <i class="bi {{ $berita->is_featured ? 'bi-star-fill text-warning' : 'bi-star text-muted' }} fs-5"></i>
                            </button>
                        </td>
                        <td class="py-3 text-center text-muted small">
                            <i class="bi bi-eye me-1"></i> {{ number_format($berita->views_count) }}
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
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
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

<!-- Edit Modals (di luar table agar HTML valid dan form berfungsi dengan benar) -->
@foreach($beritas as $berita)
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
                        <label class="form-label small fw-bold text-muted">Ringkasan / Excerpt (Opsional)</label>
                        <textarea name="excerpt" class="form-control rounded-3" rows="2" maxlength="300" placeholder="Tulis ringkasan berita singkat untuk preview card (max 300 karakter). Jika kosong, ringkasan akan digenerate otomatis.">{{ $berita->excerpt }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Konten Berita</label>
                        <div class="editor-wrapper">
                            <div id="editorEdit{{ $berita->id }}" class="edit-editor" style="height: 250px;">
                                {!! $berita->content !!}
                            </div>
                        </div>
                        <textarea name="content" id="contentEdit{{ $berita->id }}" class="d-none"></textarea>
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
                        <label class="form-label small fw-bold text-muted d-block">Status & Pengaturan</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveEdit{{ $berita->id }}" value="1" {{ $berita->is_active ? 'checked' : '' }}>
                                <label class="form-check-label small" for="isActiveEdit{{ $berita->id }}">Tampilkan di Web Publik</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedEdit{{ $berita->id }}" value="1" {{ $berita->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label small" for="isFeaturedEdit{{ $berita->id }}">Berita Unggulan (Featured)</label>
                            </div>
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
@endforeach

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
                        <label class="form-label small fw-bold text-muted">Ringkasan / Excerpt (Opsional)</label>
                        <textarea name="excerpt" class="form-control rounded-3" rows="2" maxlength="300" placeholder="Tulis ringkasan berita singkat untuk preview card (max 300 karakter). Jika kosong, ringkasan akan digenerate otomatis."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Konten Berita</label>
                        <div class="editor-wrapper">
                            <div id="editorTambah" style="height: 250px;"></div>
                        </div>
                        <textarea name="content" id="contentTambah" class="d-none"></textarea>
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
                        <label class="form-label small fw-bold text-muted d-block">Status & Pengaturan</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveTambah" value="1" checked>
                                <label class="form-check-label small" for="isActiveTambah">Tampilkan di Web Publik</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedTambah" value="1">
                                <label class="form-check-label small" for="isFeaturedTambah">Berita Unggulan (Featured)</label>
                            </div>
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
<!-- Quill JS Library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
// Global error listener untuk membantu debugging di browser user
window.onerror = function(message, source, lineno, colno, error) {
    const errMsg = `JS Uncaught Error: ${message} (Baris ${lineno}:${colno} di ${source})`;
    console.error(errMsg, error);
    if (window.showToast) {
        window.showToast(errMsg, 'error', 15000);
    } else {
        alert(errMsg);
    }
    return false;
};

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Quill Editor untuk Tambah Berita
    let quillTambah = null;
    try {
        const editorTambahEl = document.getElementById('editorTambah');
        if (editorTambahEl) {
            quillTambah = new Quill('#editorTambah', {
                theme: 'snow',
                placeholder: 'Tulis isi berita lengkap di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });
        }
    } catch (e) {
        console.error("Gagal inisialisasi editor tambah:", e);
    }

    // Inisialisasi Quill Editor untuk Edit Berita (Dinamis per Modal)
    const editEditors = {};
    try {
        document.querySelectorAll('.edit-editor').forEach(editor => {
            const id = editor.id; // Misal: editorEdit1
            const beritaId = id.replace('editorEdit', '');
            editEditors[beritaId] = new Quill('#' + id, {
                theme: 'snow',
                placeholder: 'Ubah isi berita lengkap di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });
        });
    } catch (e) {
        console.error("Gagal inisialisasi editor edit:", e);
    }

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

                // Helper untuk mereset tombol submit ke keadaan semula jika terjadi error/validasi gagal
                const resetSubmitBtn = () => {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                        if (submitBtn.hasAttribute('data-original-text')) {
                            submitBtn.innerHTML = submitBtn.getAttribute('data-original-text');
                        }
                    }
                };

                try {
                    // Sinkronisasi konten Quill ke Textarea Tersembunyi sebelum submit
                    const editorEl = form.querySelector('.edit-editor');
                    if (editorEl) {
                        const beritaId = editorEl.id.replace('editorEdit', '');
                        const quillEdit = editEditors[beritaId];
                        const textareaEdit = document.getElementById('contentEdit' + beritaId);
                        if (quillEdit && textareaEdit) {
                            const html = quillEdit.root.innerHTML;
                            // Quill empty content is usually "<p><br></p>"
                            if (html === '<p><br></p>' || html.trim() === '') {
                                if (window.showToast) {
                                    window.showToast('Konten berita tidak boleh kosong.', 'error');
                                } else {
                                    alert('Konten berita tidak boleh kosong.');
                                }
                                resetSubmitBtn();
                                return;
                            }
                            textareaEdit.value = html;
                        }
                    } else {
                        const textareaTambah = document.getElementById('contentTambah');
                        if (quillTambah && textareaTambah) {
                            const html = quillTambah.root.innerHTML;
                            if (html === '<p><br></p>' || html.trim() === '') {
                                if (window.showToast) {
                                    window.showToast('Konten berita tidak boleh kosong.', 'error');
                                } else {
                                    alert('Konten berita tidak boleh kosong.');
                                }
                                resetSubmitBtn();
                                return;
                            }
                            textareaTambah.value = html;
                        }
                    }
                    
                    const fileInput = form.querySelector('input[type="file"]');
                    const file = fileInput ? fileInput.files[0] : null;
                    
                    const progressModalEl = document.getElementById('modalUploadProgress');
                    if (!progressModalEl) {
                        throw new Error("Elemen modalUploadProgress tidak ditemukan di halaman!");
                    }
                    
                    let progressModal = bootstrap.Modal.getInstance(progressModalEl);
                    if (!progressModal) {
                        progressModal = new bootstrap.Modal(progressModalEl);
                    }
                    
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
                    let activeModal = null;
                    if (activeModalEl) {
                        activeModal = bootstrap.Modal.getInstance(activeModalEl);
                        if (!activeModal) {
                            activeModal = new bootstrap.Modal(activeModalEl);
                        }
                        activeModal.hide();
                    }
                    
                    progressModal.show();
                    
                    // Build FormData
                    const formData = new FormData(form);
                    
                    if (!window.axios) {
                        throw new Error("Library Axios (window.axios) tidak terdeteksi di halaman!");
                    }
                    
                    // Submit via Axios (Hapus header manual multipart/form-data agar boundary terpasang otomatis)
                    window.axios.post(action, formData, {
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
                        
                        resetSubmitBtn();
                        
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
                        
                        // Buka kembali modal form menggunakan instance yang sama jika terjadi error
                        if (activeModal) {
                            activeModal.show();
                        }
                    });
                } catch (submitError) {
                    console.error("Submit error caught:", submitError);
                    alert("JS Submit Error: " + submitError.message);
                    resetSubmitBtn();
                }
            });
        }
    });

    // AJAX Toggle Featured
    document.querySelectorAll('.toggle-featured-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            const url = btn.getAttribute('data-url');
            
            btn.disabled = true;
            
            window.axios.post(url)
                .then(response => {
                    btn.disabled = false;
                    if (response.data.success) {
                        const icon = btn.querySelector('i');
                        if (response.data.is_featured) {
                            icon.className = 'bi bi-star-fill text-warning fs-5';
                        } else {
                            icon.className = 'bi bi-star text-muted fs-5';
                        }
                        if (window.showToast) {
                            window.showToast(response.data.message, 'success');
                        } else {
                            // Fallback toast
                            const toastEl = document.createElement('div');
                            toastEl.className = 'position-fixed bottom-0 end-0 p-3';
                            toastEl.style.zIndex = '9999';
                            toastEl.innerHTML = `<div class="toast show align-items-center text-white bg-success border-0" role="alert"><div class="d-flex"><div class="toast-body">${response.data.message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
                            document.body.appendChild(toastEl);
                            setTimeout(() => toastEl.remove(), 3000);
                        }
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    console.error(error);
                    const errorMsg = error.response?.data?.message || 'Gagal mengubah status unggulan.';
                    if (window.showToast) {
                        window.showToast(errorMsg, 'error');
                    } else {
                        alert(errorMsg);
                    }
                });
        });
    });
});
</script>
@endpush
@endsection
