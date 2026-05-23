@extends('layouts.admin')

@section('title', 'Moderasi Forum')
@section('page-title', 'Moderasi Forum')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-funnel-fill me-2"></i> Filter Kategori</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.forum.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="forum_id" class="form-label small fw-bold">Kategori Forum</label>
                        <select name="forum_id" id="forum_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($forums as $forum)
                                <option value="{{ $forum->id }}" {{ request('forum_id') == $forum->id ? 'selected' : '' }}>
                                    {{ $forum->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                    @if(request()->filled('forum_id'))
                        <div class="col-md-2">
                            <a href="{{ route('admin.forum.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-list-task me-2"></i> Daftar Thread (Topik Diskusi)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small">
                <tr>
                    <th scope="col" width="35%">Topik</th>
                    <th scope="col" width="15%">Kategori</th>
                    <th scope="col" width="15%">Pembuat</th>
                    <th scope="col" width="10%" class="text-center">Statistik</th>
                    <th scope="col" width="10%" class="text-center">Status</th>
                    <th scope="col" width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($threads as $thread)
                    <tr>
                        <td>
                            <a href="{{ route('forum.thread.show', $thread->slug) }}" target="_blank" class="fw-bold text-decoration-none" style="color: var(--color-primary-dark);">
                                {{ Str::limit($thread->title, 50) }}
                            </a>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-clock me-1"></i> {{ $thread->created_at->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $thread->forum->icon }} {{ $thread->forum->name }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $thread->user->username }}</span>
                        </td>
                        <td class="text-center small">
                            <div><i class="bi bi-chat-dots"></i> {{ $thread->replies_count }}</div>
                            <div class="text-muted"><i class="bi bi-eye"></i> {{ $thread->views_count }}</div>
                        </td>
                        <td class="text-center">
                            @if($thread->is_pinned)
                                <span class="badge bg-warning text-dark mb-1 d-block">PINNED</span>
                            @endif
                            @if($thread->is_locked)
                                <span class="badge bg-secondary d-block">LOCKED</span>
                            @endif
                            @if(!$thread->is_pinned && !$thread->is_locked)
                                <span class="badge bg-success bg-opacity-10 text-success d-block">AKTIF</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <!-- Pin Toggle -->
                                <form action="{{ route('admin.forum.pin', $thread->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $thread->is_pinned ? 'btn-warning' : 'btn-outline-warning' }}" title="{{ $thread->is_pinned ? 'Unpin' : 'Pin' }}">
                                        <i class="bi bi-pin-angle-fill"></i>
                                    </button>
                                </form>

                                <!-- Lock Toggle -->
                                <form action="{{ route('admin.forum.lock', $thread->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $thread->is_locked ? 'btn-secondary' : 'btn-outline-secondary' }}" title="{{ $thread->is_locked ? 'Buka Kunci' : 'Kunci' }}">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.forum.destroyThread', $thread->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permanen thread ini beserta semua balasannya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Permanen">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada thread yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($threads->hasPages())
        <div class="card-footer bg-white pt-3">
            {{ $threads->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
