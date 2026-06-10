@extends('layouts.admin')

@section('title', 'Manajemen Testimoni')
@section('page-title', 'Kelola Testimoni Alumni')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
            <div>
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-chat-quote-fill text-primary me-2"></i> Daftar Testimoni
                </h5>
                <p class="text-muted small mb-0 mt-1">Kelola testimoni alumni untuk ditampilkan di halaman utama</p>
            </div>
            
            <div class="d-flex flex-wrap align-items-center gap-3">
                <form action="{{ route('admin.testimonis.index') }}" method="GET" class="position-relative" style="min-width: 250px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search ?? '' }}"
                        class="form-control ps-5 py-2 rounded-pill border-0 bg-light shadow-none" 
                        placeholder="Cari testimoni..."
                    >
                </form>
                
                <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalTambahTestimoni">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Testimoni
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead class="text-muted small text-uppercase fw-bold bg-light">
                    <tr>
                        <th class="ps-4 py-3">Alumni</th>
                        <th class="py-3">Testimoni</th>
                        <th class="py-3">Featured</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonis as $testimoni)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-primary">{{ $testimoni->alumni->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $testimoni->alumni->angkatan->nama_angkatan ?? '-' }}</div>
                        </td>
                        <td class="py-3 text-muted small text-break fst-italic" style="max-width: 300px;">
                            "{{ Str::limit($testimoni->content, 80) }}"
                        </td>
                        <td class="py-3">
                            @if($testimoni->is_featured)
                                <i class="bi bi-star-fill text-warning fs-5" title="Featured"></i>
                            @else
                                <i class="bi bi-star text-muted opacity-25 fs-5"></i>
                            @endif
                        </td>
                        <td class="py-3">
                            @if($testimoni->is_active)
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">Nonaktif</span>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light text-primary rounded-start-pill" data-bs-toggle="modal" data-bs-target="#modalEditTestimoni{{ $testimoni->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.testimonis.destroy', $testimoni) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus testimoni ini?');">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada data Testimoni
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="small text-muted mb-2 mb-md-0">
                Menampilkan {{ $testimonis->firstItem() }} sampai {{ $testimonis->lastItem() }} dari {{ $testimonis->total() }} Testimoni
            </div>
            {{ $testimonis->links() }}
        </div>
    </div>
</div>

@foreach($testimonis as $testimoni)
<!-- Edit Modal -->
<div class="modal fade" id="modalEditTestimoni{{ $testimoni->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Edit Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.testimonis.update', $testimoni) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Alumni</label>
                        <select name="alumni_id" class="form-select rounded-3" required>
                            @php $currentAngkatan = null; @endphp
                            @foreach($alumnis as $al)
                                @php $groupName = $al->angkatan->nama_angkatan ?? 'Tanpa Angkatan'; @endphp
                                @if($currentAngkatan !== $groupName)
                                    @if($currentAngkatan !== null) </optgroup> @endif
                                    @php $currentAngkatan = $groupName; @endphp
                                    <optgroup label="{{ $currentAngkatan }}">
                                @endif
                                <option value="{{ $al->id }}" {{ $al->id == $testimoni->alumni_id ? 'selected' : '' }}>
                                    {{ $al->nama_lengkap }}
                                </option>
                            @endforeach
                            @if($currentAngkatan !== null) </optgroup> @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Isi Testimoni</label>
                        <textarea name="content" class="form-control rounded-3" rows="4" required>{{ $testimoni->content }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted d-block">Featured (Sorotan)</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ $testimoni->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label small">Jadikan Sorotan Utama</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted d-block">Status Aktif</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $testimoni->is_active ? 'checked' : '' }}>
                                <label class="form-check-label small">Tampilkan di Web</label>
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
<div class="modal fade" id="modalTambahTestimoni" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Tambah Testimoni Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.testimonis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Alumni</label>
                        <select name="alumni_id" class="form-select rounded-3" required>
                            <option value="">-- Cari & Pilih Alumni --</option>
                            @php $currentAngkatan = null; @endphp
                            @foreach($alumnis as $alumni)
                                @php $groupName = $alumni->angkatan->nama_angkatan ?? 'Tanpa Angkatan'; @endphp
                                @if($currentAngkatan !== $groupName)
                                    @if($currentAngkatan !== null) </optgroup> @endif
                                    @php $currentAngkatan = $groupName; @endphp
                                    <optgroup label="{{ $currentAngkatan }}">
                                @endif
                                <option value="{{ $alumni->id }}">
                                    {{ $alumni->nama_lengkap }}
                                </option>
                            @endforeach
                            @if($currentAngkatan !== null) </optgroup> @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Isi Testimoni</label>
                        <textarea name="content" class="form-control rounded-3" rows="4" placeholder="Tulis testimoni dari alumni..." required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted d-block">Featured (Sorotan)</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" checked>
                                <label class="form-check-label small">Jadikan Sorotan Utama</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted d-block">Status Aktif</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label small">Tampilkan di Web</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Testimoni</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
