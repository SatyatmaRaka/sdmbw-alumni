@extends('layouts.admin')

@section('title', 'Manajemen Komentar')
@section('page-title', 'Kelola Komentar Anonim')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
            <div>
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-chat-left-text-fill text-primary me-2"></i> Daftar Komentar Anonim (Suara Alumni)
                </h5>
                <p class="text-muted small mb-0 mt-1">Daftar masukan, kritik, dan saran yang dikirim oleh alumni secara anonim di halaman utama</p>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead class="text-muted small text-uppercase fw-bold bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="width: 80px;">ID</th>
                        <th class="py-3" style="width: 200px;">Alias Pengirim</th>
                        <th class="py-3">Pesan / Isi Komentar</th>
                        <th class="py-3" style="width: 200px;">Tanggal Dikirim</th>
                        <th class="pe-4 py-3 text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                    <tr>
                        <td class="ps-4 py-3 text-muted">
                            #{{ $comment->id }}
                        </td>
                        <td class="py-3">
                            <span class="badge bg-light text-primary border rounded-pill px-3 py-2 fw-semibold">
                                <i class="bi bi-incognito me-1"></i> {{ $comment->alias }}
                            </span>
                        </td>
                        <td class="py-3 text-muted small text-break" style="max-width: 400px; white-space: pre-wrap;">{{ $comment->message }}</td>
                        <td class="py-3 small text-muted">
                            {{ $comment->created_at->format('d M Y H:i') }}
                            <div class="text-muted opacity-75 fs-xs mt-0.5" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar anonim ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-pill px-3 py-2 fw-semibold">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-left-dots fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada komentar dari alumni.
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
                Menampilkan {{ $comments->firstItem() ?? 0 }} sampai {{ $comments->lastItem() ?? 0 }} dari {{ $comments->total() ?? 0 }} Komentar
            </div>
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection
