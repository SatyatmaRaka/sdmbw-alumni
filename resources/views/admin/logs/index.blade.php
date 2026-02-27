@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #E8C87A;
        --accent-soft:   rgba(232,200,122,0.12);
        --success:       #16a34a;
        --warning:       #d97706;
        --danger:        #e53e3e;
        --info:          #0891b2;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── FILTER CARD ─── */
    .filter-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .filter-card-header {
        background: var(--primary);
        padding: 0.85rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.3px;
        position: relative;
    }

    .filter-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .filter-card-body { padding: 1.1rem 1.5rem; }

    .filter-label {
        display: block;
        font-size: 0.67rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.38rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.58rem 0.85rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 0.85rem;
        color: var(--primary);
        background: #f8fafc;
        transition: var(--transition);
        appearance: none;
    }

    .filter-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
        outline: none;
    }

    .filter-input::placeholder { color: #b0bec5; }

    .btn-filter {
        width: 100%;
        padding: 0.6rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 9px;
        font-weight: 700;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-filter:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(27,58,82,0.2);
    }

    /* ─── MAIN CARD ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .card-section-header {
        background: var(--primary);
        padding: 0.95rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .card-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.83rem;
    }

    .card-section-title i { opacity: 0.8; }

    .btn-hapus-semua {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.35rem 0.9rem;
        background: rgba(239,68,68,0.15);
        border: 1px solid rgba(239,68,68,0.3);
        color: #fca5a5;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-hapus-semua:hover {
        background: var(--danger);
        border-color: var(--danger);
        color: white;
    }

    /* ─── TABLE ─── */
    .log-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
    }

    .log-table thead th {
        background: #f8fafc;
        padding: 0.7rem 1rem;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .log-table thead th:first-child { padding-left: 1.5rem; }
    .log-table thead th:last-child  { text-align: center; }

    .log-table tbody td {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
        color: var(--primary);
    }

    .log-table tbody td:first-child { padding-left: 1.5rem; color: #94a3b8; font-size: 0.8rem; }
    .log-table tbody td:last-child  { text-align: center; }

    .log-table tbody tr:last-child td { border-bottom: none; }
    .log-table tbody tr:hover td { background: #fafbfc; }

    /* ─── TIME CELL ─── */
    .td-time-date { font-weight: 700; font-size: 0.85rem; }
    .td-time-hour { font-size: 0.75rem; color: #94a3b8; }

    /* ─── ADMIN CELL ─── */
    .td-admin {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        font-size: 0.83rem;
        color: var(--primary);
    }

    .td-admin i { color: #94a3b8; }

    /* ─── ACTION BADGE ─── */
    .action-tag {
        display: inline-block;
        padding: 0.22rem 0.7rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .action-create  { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .action-update  { background: rgba(8,145,178,0.1);  border: 1px solid rgba(8,145,178,0.22);  color: var(--info); }
    .action-delete  { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }
    .action-verify  { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .action-reset   { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .action-default { background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; }

    /* ─── DESCRIPTION CELL ─── */
    .td-desc { max-width: 340px; }
    .td-desc-text { line-height: 1.5; color: #334155; }
    .td-target {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 5px;
        padding: 0.18rem 0.55rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        font-size: 0.68rem;
        color: #64748b;
        font-weight: 600;
    }

    /* ─── DELETE BUTTON ─── */
    .btn-delete-log {
        background: transparent;
        border: none;
        color: #cbd5e1;
        padding: 5px 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .btn-delete-log:hover { color: var(--danger); background: rgba(229,62,62,0.08); }

    /* ─── EMPTY ─── */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-state i { font-size: 3rem; opacity: 0.12; color: var(--primary); display: block; margin-bottom: 1rem; }
    .empty-state p { color: #94a3b8; font-weight: 600; margin: 0; }

    /* ─── PAGINATION ─── */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .pagination .page-link {
        color: var(--primary);
        border-color: #e2e8f0;
        font-weight: 600;
        font-size: 0.82rem;
        border-radius: 7px !important;
        margin: 0 2px;
        padding: 0.42rem 0.8rem;
        transition: var(--transition);
    }

    .pagination .page-link:hover { background: var(--primary); color: white; border-color: var(--primary); }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    /* ─── MODAL ─── */
    .modal-content {
        border: none;
        border-radius: var(--radius);
        box-shadow: 0 24px 60px rgba(0,0,0,0.2);
        overflow: hidden;
    }

    .modal-header-danger {
        background: var(--danger);
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-danger h5 {
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-content {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .modal-body-content p { color: #334155; margin-bottom: 6px; }
    .modal-body-content small { color: var(--danger); font-weight: 600; }

    .modal-footer-content {
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-modal-cancel {
        padding: 0.6rem 1.5rem;
        background: #f1f5f9;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        color: #64748b;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-modal-cancel:hover { background: #e2e8f0; }

    .btn-modal-confirm {
        padding: 0.6rem 1.5rem;
        background: var(--danger);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.875rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(229,62,62,0.3);
    }

    .btn-modal-confirm:hover { background: #c53030; transform: translateY(-1px); }

    /* ─── INFO ALERT ─── */
    .info-alert {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        border-left: 4px solid var(--info);
        box-shadow: var(--shadow-card);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 1.25rem;
    }

    .info-alert i { font-size: 1.1rem; color: var(--info); flex-shrink: 0; margin-top: 2px; }
    .info-alert p { font-size: 0.84rem; color: #475569; margin: 0; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .log-table thead th:nth-child(3),
        .log-table tbody td:nth-child(3) { display: none; } /* hide admin col on mobile */
        .td-desc { max-width: 200px; }
    }
</style>

{{-- ── FILTER ── --}}
<div class="filter-card">
    <div class="filter-card-header">
        <i class="bi bi-funnel-fill"></i> Filter &amp; Pencarian
    </div>
    <div class="filter-card-body">
        <form action="{{ route('admin.logs.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="filter-label">Action</label>
                    <select name="action" class="filter-input">
                        <option value="">Semua Action</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="filter-label">Tanggal</label>
                    <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
                </div>
                <div class="col-12 col-md-5">
                    <label class="filter-label">Cari Deskripsi</label>
                    <input type="text" name="search" class="filter-input"
                           placeholder="Cari deskripsi log..." value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-1">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── MAIN TABLE ── --}}
<div class="card-section">
    <div class="card-section-header">
        <div class="card-section-title">
            <i class="bi bi-clock-history"></i>
            Activity Logs
            <span style="opacity:0.6; font-weight:500;">({{ number_format($logs->total()) }})</span>
        </div>
        @if($logs->total() > 0)
            <button type="button" class="btn-hapus-semua"
                    data-bs-toggle="modal" data-bs-target="#clearAllModal">
                <i class="bi bi-trash3"></i> Hapus Semua
            </button>
        @endif
    </div>

    <div class="table-responsive">
        <table class="log-table">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th style="width:13%;">Waktu</th>
                    <th style="width:13%;">Admin</th>
                    <th style="width:14%;">Action</th>
                    <th>Deskripsi</th>
                    <th style="width:7%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                    @php
                        $actionClass = match(true) {
                            str_contains($log->action, 'create') => 'action-create',
                            str_contains($log->action, 'update') => 'action-update',
                            str_contains($log->action, 'delete') => 'action-delete',
                            str_contains($log->action, 'verify') => 'action-verify',
                            str_contains($log->action, 'reset')  => 'action-reset',
                            default                              => 'action-default',
                        };
                    @endphp
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        <td>
                            <div class="td-time-date">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="td-time-hour">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td>
                            <span class="td-admin">
                                <i class="bi bi-person-circle"></i>
                                {{ $log->admin->username ?? 'System' }}
                            </span>
                        </td>
                        <td>
                            <span class="action-tag {{ $actionClass }}">
                                {{ strtoupper(str_replace('_', ' ', $log->action)) }}
                            </span>
                        </td>
                        <td class="td-desc">
                            <span class="td-desc-text">{{ $log->description }}</span>
                            @if($log->target_type && $log->target_id)
                                <div>
                                    <span class="td-target">
                                        <i class="bi bi-tag"></i>
                                        {{ class_basename($log->target_type) }} #{{ $log->target_id }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.logs.destroy', $log) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Hapus log ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-log" title="Hapus log ini">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada activity log yang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="pagination-wrap">
            {{ $logs->links() }}
        </div>
    @endif
</div>

{{-- ── INFO ALERT ── --}}
<div class="info-alert">
    <i class="bi bi-info-circle-fill"></i>
    <p><strong>Informasi Keamanan:</strong> Activity logs mencatat setiap perubahan data krusial untuk keperluan audit sistem (Tambah, Verifikasi, Hapus, dan Reset).</p>
</div>

{{-- ── CLEAR ALL MODAL ── --}}
<div class="modal fade" id="clearAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header-danger">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.logs.clearAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body-content">
                    <p>Yakin ingin menghapus seluruh riwayat aktivitas sebanyak <strong>{{ $logs->total() }} data</strong>?</p>
                    <small>Tindakan ini tidak dapat dibatalkan.</small>
                </div>
                <div class="modal-footer-content">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-confirm">
                        <i class="bi bi-trash3 me-1"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
