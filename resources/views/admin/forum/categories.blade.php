@extends('layouts.admin')

@section('title', 'Kelola Kategori Forum')
@section('page-title', 'Kelola Kategori Forum')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.forum.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Moderasi Forum
        </a>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-tags-fill me-2"></i> Daftar Kategori Forum</h6>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th scope="col" width="5%" class="text-center">Urutan</th>
                            <th scope="col" width="10%" class="text-center">Ikon</th>
                            <th scope="col" width="25%">Nama Kategori</th>
                            <th scope="col" width="40%">Deskripsi</th>
                            <th scope="col" width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($forums as $forum)
                            <tr>
                                <td class="text-center fw-bold">{{ $forum->order }}</td>
                                <td class="text-center fs-5">{!! $forum->icon ?? '-' !!}</td>
                                <td class="fw-bold" style="color: var(--color-primary-dark);">{{ $forum->name }}</td>
                                <td class="text-muted small">{{ Str::limit($forum->description, 80) ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <!-- Edit Button (Triggers Modal) -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editCategoryModal{{ $forum->id }}" 
                                            title="Edit Kategori">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.forum-categories.destroy', $forum->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini? Pastikan tidak ada thread di dalamnya.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal for this Category -->
                            <div class="modal fade" id="editCategoryModal{{ $forum->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $forum->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.forum-categories.update', $forum->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="editCategoryModalLabel{{ $forum->id }}">Edit Kategori Forum</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Nama Kategori</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $forum->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Ikon (Emoji atau Bootstrap Icon Class)</label>
                                                    <input type="text" class="form-control" name="icon" value="{{ $forum->icon }}" placeholder="Misal: 💼 atau <i class='bi bi-briefcase'></i>">
                                                    <div class="form-text">Dapat berupa emoji atau tag icon.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Urutan Tampil (Order)</label>
                                                    <input type="number" class="form-control" name="order" value="{{ $forum->order }}" required min="0">
                                                    <div class="form-text">Angka lebih kecil tampil lebih dulu.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Deskripsi</label>
                                                    <textarea class="form-control" name="description" rows="3">{{ $forum->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    Belum ada kategori yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.forum-categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" required placeholder="Misal: Lowongan Kerja">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Ikon (Emoji atau HTML)</label>
                        <input type="text" class="form-control" name="icon" placeholder="Misal: 💼">
                        <div class="form-text">Dapat berupa emoji atau tag html ikon.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Urutan Tampil (Order)</label>
                        <input type="number" class="form-control" name="order" required min="0" value="0">
                        <div class="form-text">Angka lebih kecil tampil lebih dulu.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Opsional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
