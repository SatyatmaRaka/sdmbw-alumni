@extends('layouts.admin')

@section('title', 'Kelola Alumni')
@section('page-title', 'Kelola Alumni')

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
        position: relative;
    }

    .filter-card-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .filter-card-header i { opacity: 0.8; }
    .filter-card-body { padding: 1.1rem 1.5rem; }

    .filter-label {
        display: block;
        font-size: 0.66rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.4rem;
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

    /* search input with icon */
    .search-wrap {
        display: flex;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        transition: var(--transition);
        overflow: hidden;
    }

    .search-wrap:focus-within {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(27,58,82,0.09);
    }

    .search-icon {
        display: flex; align-items: center;
        padding: 0 11px;
        color: #94a3b8;
        font-size: 0.85rem;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .search-wrap:focus-within .search-icon { color: var(--primary); }

    .search-input {
        flex: 1; border: none; outline: none;
        background: transparent;
        padding: 0.58rem 0.5rem;
        font-size: 0.85rem;
        color: var(--primary);
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        min-width: 0;
    }

    .search-input::placeholder { color: #b0bec5; }

    .btn-filter-submit {
        width: 100%;
        padding: 0.62rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 9px;
        font-weight: 700;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex; align-items: center; justify-content: center; gap: 5px;
    }

    .btn-filter-submit:hover { background: var(--primary-light); transform: translateY(-1px); }

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

    .total-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.15rem 0.65rem;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 600;
        color: rgba(255,255,255,0.8);
        margin-left: 5px;
    }

    .btn-clear-filter {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3rem 0.85rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        color: rgba(255,255,255,0.75);
        border-radius: 50px;
        font-size: 0.73rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-clear-filter:hover { background: rgba(255,255,255,0.18); color: white; }

    /* ─── TABLE ─── */
    .alumni-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .alumni-table thead th {
        background: #f8fafc;
        padding: 0.7rem 0.9rem;
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .alumni-table thead th:first-child  { padding-left: 1.5rem; }
    .alumni-table thead th:last-child   { text-align: center; padding-right: 1.5rem; }

    .alumni-table tbody td {
        padding: 0.78rem 0.9rem;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
        color: var(--primary);
    }

    .alumni-table tbody td:first-child { padding-left: 1.5rem; color: #94a3b8; font-size: 0.8rem; }
    .alumni-table tbody td:last-child  { text-align: center; padding-right: 1.5rem; }

    .alumni-table tbody tr:last-child td { border-bottom: none; }
    .alumni-table tbody tr:hover td { background: #fafbfc; }

    /* ─── AVATAR ─── */
    .alumni-avatar {
        width: 42px; height: 42px;
        border-radius: 11px;
        overflow: hidden;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 2px solid #f1f5f9;
    }

    .alumni-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .alumni-avatar i   { color: rgba(255,255,255,0.25); font-size: 1.15rem; }

    /* ─── NISN ─── */
    .nisn-chip {
        display: inline-block;
        font-family: 'Courier New', monospace;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--primary);
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 5px;
    }

    /* ─── NAMA ─── */
    .td-nama  { font-weight: 700; color: var(--primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px; display: block; }
    .td-uname { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }

    /* ─── ANGKATAN ─── */
    .angkatan-tag {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.65rem;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.28);
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #7a5c1e;
        white-space: nowrap;
    }

    /* ─── STATUS PILLS ─── */
    .v-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.22rem 0.65rem;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .v-verified { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .v-pending  { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .v-rejected { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }

    .profil-ok  { font-size: 0.8rem; font-weight: 700; color: var(--success); display: flex; align-items: center; gap: 4px; }
    .profil-no  { font-size: 0.8rem; font-weight: 500; color: #94a3b8; display: flex; align-items: center; gap: 4px; }

    /* ─── ACTION BUTTONS ─── */
    .action-group { display: inline-flex; gap: 4px; align-items: center; }

    .btn-act {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px; height: 30px;
        border-radius: 8px;
        font-size: 0.82rem;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-act-info    { background: rgba(8,145,178,0.1);  border: 1px solid rgba(8,145,178,0.22);  color: var(--info); }
    .btn-act-warning { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .btn-act-danger  { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }

    .btn-act-info:hover    { background: var(--info);    color: white; border-color: var(--info); }
    .btn-act-warning:hover { background: var(--warning); color: white; border-color: var(--warning); }
    .btn-act-danger:hover  { background: var(--danger);  color: white; border-color: var(--danger); }

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

    .empty-state h6 { color: var(--primary); font-weight: 700; margin-bottom: 4px; }
    .empty-state p  { color: #94a3b8; font-size: 0.85rem; margin: 0; }

    /* ─── FOOTER PAGINATION ─── */
    .card-footer-custom {
        padding: 0.9rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .footer-info {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .footer-info strong { color: var(--primary); }

    .pagination .page-link {
        color: var(--primary);
        border-color: #e2e8f0;
        font-weight: 600;
        font-size: 0.82rem;
        border-radius: 7px !important;
        margin: 0 2px;
        padding: 0.38rem 0.75rem;
        transition: var(--transition);
    }

    .pagination .page-link:hover { background: var(--primary); color: white; border-color: var(--primary); }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(27,58,82,0.2);
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .alumni-table thead th:nth-child(5),
        .alumni-table tbody td:nth-child(5),
        .alumni-table thead th:nth-child(7),
        .alumni-table tbody td:nth-child(7) { display: none; }
    }
</style>

{{-- ── FILTER ── --}}
<div class="filter-card">
    <div class="filter-card-header">
        <i class="bi bi-funnel-fill"></i> Filter Alumni
    </div>
    <div class="filter-card-body">
        <form action="{{ route('admin.alumni.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="filter-label">Status Verifikasi</label>
                    <select name="status" class="filter-input">
                        <option value="">Semua Status</option>
                        <option value="pending"  {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status') === 'verified'  ? 'selected' : '' }}>Verified (Aktif)</option>
                        <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="filter-label">Angkatan</label>
                    <select name="angkatan_id" class="filter-input">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->id }}" {{ request('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                                {{ $angkatan->nama_angkatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="filter-label">Profil</label>
                    <select name="complete" class="filter-input">
                        <option value="">Semua</option>
                        <option value="1" {{ request('complete') === '1' ? 'selected' : '' }}>Lengkap</option>
                        <option value="0" {{ request('complete') === '0' ? 'selected' : '' }}>Belum Lengkap</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="filter-label">Cari</label>
                    <div class="search-wrap">
                        <span class="search-icon"><i class="bi bi-person-search"></i></span>
                        <input type="text" name="search" class="search-input"
                               placeholder="NISN atau Nama..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-md-1">
                    <button type="submit" class="btn-filter-submit">
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
            <i class="bi bi-people-fill"></i>
            Daftar Alumni
            <span class="total-badge">{{ number_format($alumnis->total()) }} Total</span>
        </div>
        @if(request()->anyFilled(['status', 'angkatan_id', 'complete', 'search']))
            <a href="{{ route('admin.alumni.index') }}" class="btn-clear-filter">
                <i class="bi bi-x-circle"></i> Bersihkan Filter
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="alumni-table">
            <thead>
                <tr>
                    <th style="width:4%;">No</th>
                    <th style="width:7%;">Foto</th>
                    <th style="width:11%;">NISN</th>
                    <th>Nama Lengkap</th>
                    <th>Angkatan</th>
                    <th>Status</th>
                    <th>Profil</th>
                    <th style="width:12%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnis as $index => $alumni)
                    @php $foto = $alumni->fotos->where('is_main', true)->first(); @endphp
                    <tr>
                        <td>{{ $alumnis->firstItem() + $index }}</td>
                        <td>
                            <div class="alumni-avatar">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto->path_file) }}"
                                         alt="{{ $alumni->nama_lengkap }}">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                        </td>
                        <td><span class="nisn-chip">{{ $alumni->nisn }}</span></td>
                        <td>
                            <span class="td-nama">{{ $alumni->nama_lengkap }}</span>
                            <span class="td-uname">
                                <i class="bi bi-at" style="font-size:0.72rem;"></i>{{ $alumni->user->username ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="angkatan-tag">{{ $alumni->angkatan->nama_angkatan ?? '-' }}</span>
                        </td>
                        <td>
                            @if($alumni->status_verifikasi === 'verified')
                                <span class="v-pill v-verified"><i class="bi bi-patch-check-fill"></i> Aktif</span>
                            @elseif($alumni->status_verifikasi === 'pending')
                                <span class="v-pill v-pending"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                            @else
                                <span class="v-pill v-rejected"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($alumni->is_profile_complete)
                                <span class="profil-ok"><i class="bi bi-check-circle-fill"></i> Lengkap</span>
                            @else
                                <span class="profil-no"><i class="bi bi-circle"></i> Belum</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.alumni.show', $alumni) }}"
                                   class="btn-act btn-act-info"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button"
                                        class="btn-act btn-act-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalReset{{ $alumni->id }}"
                                        title="Reset Password">
                                    <i class="bi bi-shield-lock"></i>
                                </button>
                                <button type="button"
                                        class="btn-act btn-act-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDelete{{ $alumni->id }}"
                                        title="Hapus Permanen">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('admin.alumni.partials.modals', ['item' => $alumni])
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="bi bi-folder2-open"></i></div>
                                <h6>Data Tidak Ditemukan</h6>
                                <p>Tidak ada alumni yang sesuai dengan kriteria filter saat ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer-custom">
        <span class="footer-info">
            Menampilkan <strong>{{ $alumnis->firstItem() ?? 0 }}</strong>–<strong>{{ $alumnis->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $alumnis->total() }}</strong> alumni
        </span>
        {{ $alumnis->links() }}
    </div>
</div>

@endsection
