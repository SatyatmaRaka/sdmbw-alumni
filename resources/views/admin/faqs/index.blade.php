@extends('layouts.admin')

@section('title', 'Manajemen FAQ')
@section('page-title', 'Kelola FAQ (Pertanyaan Umum)')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold d-flex align-items-center">
                <i class="bi bi-question-circle-fill text-primary me-2"></i> Daftar FAQ
            </h5>
            <p class="text-muted small mb-0 mt-1">Kelola pertanyaan yang tampil di halaman utama</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFaq">
            <i class="bi bi-plus-lg me-1"></i> Tambah FAQ
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead class="text-muted small text-uppercase fw-bold bg-light">
                    <tr>
                        <th class="ps-4 py-3">Urutan</th>
                        <th class="py-3">Pertanyaan</th>
                        <th class="py-3">Jawaban</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="badge bg-secondary rounded-pill">{{ $faq->order_num }}</span>
                        </td>
                        <td class="py-3 fw-bold text-primary">{{ $faq->question }}</td>
                        <td class="py-3 text-muted small text-break" style="max-width: 300px;">
                            {{ Str::limit($faq->answer, 80) }}
                        </td>
                        <td class="py-3">
                            @if($faq->is_active)
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">Nonaktif</span>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light text-primary rounded-start-pill" data-bs-toggle="modal" data-bs-target="#modalEditFaq{{ $faq->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus FAQ ini?');">
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
                            Belum ada data FAQ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="small text-muted mb-2 mb-md-0">
                Menampilkan {{ $faqs->firstItem() }} sampai {{ $faqs->lastItem() }} dari {{ $faqs->total() }} FAQ
            </div>
            {{ $faqs->links() }}
        </div>
    </div>
</div>

@foreach($faqs as $faq)
<!-- Edit Modal -->
<div class="modal fade" id="modalEditFaq{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pertanyaan</label>
                        <input type="text" name="question" class="form-control rounded-3" value="{{ $faq->question }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jawaban</label>
                        <textarea name="answer" class="form-control rounded-3" rows="4" required>{{ $faq->answer }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Urutan</label>
                            <input type="number" name="order_num" class="form-control rounded-3" value="{{ $faq->order_num }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted d-block">Status Aktif</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}>
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
<div class="modal fade" id="modalTambahFaq" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Tambah FAQ Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pertanyaan</label>
                        <input type="text" name="question" class="form-control rounded-3" placeholder="Contoh: Bagaimana cara mendaftar?" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jawaban</label>
                        <textarea name="answer" class="form-control rounded-3" rows="4" placeholder="Tulis jawaban lengkap..." required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Urutan</label>
                            <input type="number" name="order_num" class="form-control rounded-3" value="0">
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
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
