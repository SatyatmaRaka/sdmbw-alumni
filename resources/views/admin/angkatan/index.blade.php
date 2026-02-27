@extends('layouts.admin')

@section('title', 'Kelola Angkatan')
@section('page-title', 'Kelola Angkatan')

@section('content')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --success:       #16a34a;
        --warning:       #d97706;
        --danger:        #e53e3e;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
    }

    /* ─── CARD ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.25rem;
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

    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.38rem 1rem;
        background: var(--accent);
        border: none;
        color: var(--primary-dark);
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-tambah:hover {
        background: #d9b75e;
        color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(232,200,122,0.35);
    }

    /* ─── TABLE ─── */
    .angkatan-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .angkatan-table thead th {
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

    .angkatan-table thead th:first-child { padding-left: 1.5rem; }
    .angkatan-table thead th:last-child  { text-align: center; padding-right: 1.5rem; }
    .angkatan-table thead th.col-center  { text-align: center; }

    .angkatan-table tbody td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f8fafc;
        color: var(--primary);
        vertical-align: middle;
    }

    .angkatan-table tbody td:first-child { padding-left: 1.5rem; color: #94a3b8; font-size: 0.8rem; }
    .angkatan-table tbody td:last-child  { text-align: center; padding-right: 1.5rem; }
    .angkatan-table tbody td.col-center  { text-align: center; }

    .angkatan-table tbody tr:last-child td { border-bottom: none; }
    .angkatan-table tbody tr:hover td { background: #fafbfc; }

    .td-nama { font-weight: 700; }
    .td-year { color: #64748b; }

    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.22rem 0.75rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .tag-lulus { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .tag-aktif { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }

    .alumni-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.22rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(27,58,82,0.07);
        color: var(--primary);
    }

    /* ─── ACTION BUTTONS ─── */
    .action-group {
        display: inline-flex;
        gap: 5px;
        align-items: center;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(217,119,6,0.1);
        border: 1px solid rgba(217,119,6,0.22);
        color: var(--warning);
        text-decoration: none;
        transition: var(--transition);
        font-size: 0.85rem;
    }

    .btn-edit:hover { background: var(--warning); color: white; border-color: var(--warning); }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(229,62,62,0.1);
        border: 1px solid rgba(229,62,62,0.22);
        color: var(--danger);
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.85rem;
    }

    .btn-delete:hover { background: var(--danger); color: white; border-color: var(--danger); }

    .btn-delete-disabled {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        font-size: 0.85rem;
    }

    /* ─── EMPTY ─── */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.75rem;
        color: #94a3b8;
    }

    .empty-state h6 { color: var(--primary); font-weight: 700; margin-bottom: 0.4rem; }
    .empty-state p  { color: #94a3b8; font-size: 0.85rem; margin-bottom: 1.1rem; }

    .btn-empty-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.55rem 1.25rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-empty-action:hover { background: var(--primary-light); color: white; transform: translateY(-1px); }

    /* ─── INFO ALERT ─── */
    .info-alert {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        border-left: 4px solid var(--info, #0891b2);
        box-shadow: var(--shadow-card);
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-alert i { font-size: 1.1rem; color: #0891b2; flex-shrink: 0; margin-top: 2px; }

    .info-alert h6 { font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; font-size: 0.88rem; }

    .info-list {
        list-style: none;
        padding: 0; margin: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-list li {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        font-size: 0.82rem;
        color: #475569;
    }

    .info-list li::before {
        content: '';
        display: inline-block;
        width: 5px; height: 5px;
        border-radius: 50%;
        background: var(--accent);
        flex-shrink: 0;
        margin-top: 6px;
    }
</style>

{{-- ── MAIN CARD ── --}}
<div class="card-section">
    <div class="card-section-header">
        <div class="card-section-title">
            <i class="bi bi-calendar-event-fill"></i> Daftar Angkatan
        </div>
        <a href="{{ route('admin.angkatan.create') }}" class="btn-tambah">
            <i class="bi bi-plus-circle-fill"></i> Tambah Angkatan
        </a>
    </div>

    <div class="table-responsive">
        <table class="angkatan-table">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th>Nama Angkatan</th>
                    <th>Tahun Ajaran</th>
                    <th>Status</th>
                    <th class="col-center">Jumlah Alumni</th>
                    <th style="width:12%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($angkatans as $index => $angkatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="td-nama">{{ $angkatan->nama_angkatan }}</td>
                        <td class="td-year">{{ $angkatan->tahun_ajaran }}</td>
                        <td>
                            @if($angkatan->status === 'LULUS')
                                <span class="status-tag tag-lulus">
                                    <i class="bi bi-check-circle-fill"></i> LULUS
                                </span>
                            @elseif($angkatan->status === 'AKTIF')
                                <span class="status-tag tag-aktif">
                                    <i class="bi bi-play-circle-fill"></i> AKTIF
                                </span>
                            @endif
                        </td>
                        <td class="col-center">
                            <span class="alumni-chip">
                                <i class="bi bi-people-fill" style="font-size:0.72rem; opacity:0.6;"></i>
                                {{ $angkatan->alumni_count }} Alumni
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.angkatan.edit', $angkatan) }}"
                                    class="btn-edit" title="Edit Angkatan">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                @if($angkatan->alumni_count == 0)
                                    <form action="{{ route('admin.angkatan.destroy', $angkatan) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus angkatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus Angkatan">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="btn-delete-disabled"
                                            title="Tidak bisa dihapus — angkatan ini memiliki alumni">
                                        <i class="bi bi-trash3-fill"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <h6>Belum Ada Angkatan</h6>
                                <p>Buat angkatan pertama untuk mulai mengelola data alumni.</p>
                                <a href="{{ route('admin.angkatan.create') }}" class="btn-empty-action">
                                    <i class="bi bi-plus-circle-fill"></i> Buat Angkatan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── INFO ALERT ── --}}
<div class="info-alert">
    <i class="bi bi-info-circle-fill"></i>
    <div>
        <h6>Informasi Pengelolaan</h6>
        <ul class="info-list">
            <li>Angkatan dengan status <strong>LULUS</strong> diizinkan untuk melakukan registrasi akun alumni.</li>
            <li>Angkatan dengan status <strong>AKTIF</strong> tetap tercatat di sistem namun akses login alumni mungkin dibatasi.</li>
            <li>Sistem melarang penghapusan angkatan yang sudah memiliki data alumni untuk menjaga <strong>Integritas Data</strong>.</li>
        </ul>
    </div>
</div>

@endsection
