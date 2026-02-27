@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Statistik')

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

    /* ─── STAT CARDS ─── */
    .stat-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 2px 0 rgba(255,255,255,0.8) inset, 0 16px 36px rgba(27,58,82,0.1);
    }

    .stat-card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .icon-primary  { background: rgba(27,58,82,0.08);  color: var(--primary); }
    .icon-success  { background: rgba(22,163,74,0.08);  color: var(--success); }
    .icon-warning  { background: rgba(217,119,6,0.08);  color: var(--warning); }
    .icon-info     { background: rgba(8,145,178,0.08);  color: var(--info); }

    .stat-card-num {
        font-weight: 800;
        font-size: 1.65rem;
        line-height: 1;
        margin-bottom: 3px;
    }

    .num-primary { color: var(--primary); }
    .num-success { color: var(--success); }
    .num-warning { color: var(--warning); }
    .num-info    { color: var(--info); }

    .stat-card-label {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 600;
    }

    /* ─── CARD SECTION ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 1.5rem;
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

    .btn-print-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.35rem 0.9rem;
        background: var(--accent);
        border: none;
        color: var(--primary-dark);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-print-sm:hover {
        background: #d9b75e;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(232,200,122,0.35);
    }

    /* ─── MAIN TABLE ─── */
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .report-table thead th {
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

    .report-table thead th:first-child { padding-left: 1.5rem; }
    .report-table thead th.col-right   { text-align: center; }
    .report-table thead th.col-end     { text-align: right; padding-right: 1.5rem; }

    .report-table tbody td {
        padding: 0.82rem 1rem;
        border-bottom: 1px solid #f8fafc;
        color: var(--primary);
        vertical-align: middle;
    }

    .report-table tbody td:first-child { padding-left: 1.5rem; font-weight: 700; }
    .report-table tbody td.col-right   { text-align: center; }
    .report-table tbody td.col-end     { text-align: right; padding-right: 1.5rem; }

    .report-table tbody tr:last-child td { border-bottom: none; }
    .report-table tbody tr:hover td { background: #fafbfc; }

    /* tfoot */
    .report-table tfoot td {
        padding: 0.82rem 1rem;
        font-weight: 800;
        font-size: 0.83rem;
        color: var(--primary);
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
    }

    .report-table tfoot td:first-child { padding-left: 1.5rem; }
    .report-table tfoot td.col-right   { text-align: center; }
    .report-table tfoot td.col-end     { text-align: right; padding-right: 1.5rem; }

    .td-year { color: #64748b; font-weight: 400; font-size: 0.83rem; }

    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.65rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .tag-lulus { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .tag-aktif { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }

    .num-chip {
        display: inline-block;
        padding: 0.18rem 0.65rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .chip-total    { background: #f1f5f9;                       color: var(--primary); }
    .chip-verified { background: rgba(22,163,74,0.1);           color: var(--success); }
    .chip-pending  { background: rgba(217,119,6,0.1);           color: var(--warning); }
    .chip-lengkap  { background: rgba(8,145,178,0.1);           color: var(--info); }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.35rem 0.85rem;
        background: rgba(8,145,178,0.1);
        border: 1px solid rgba(8,145,178,0.22);
        color: var(--info);
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-detail:hover { background: var(--info); color: white; border-color: var(--info); }

    /* ─── MINI TABLES (pendidikan & pekerjaan) ─── */
    .mini-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .mini-table thead th {
        background: #f8fafc;
        padding: 0.6rem 1rem;
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
    }

    .mini-table thead th:first-child { padding-left: 1.25rem; }
    .mini-table thead th:last-child  { text-align: center; padding-right: 1.25rem; }

    .mini-table tbody td {
        padding: 0.7rem 1rem;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        vertical-align: middle;
    }

    .mini-table tbody td:first-child { padding-left: 1.25rem; font-weight: 600; }
    .mini-table tbody td:last-child  { text-align: center; padding-right: 1.25rem; }
    .mini-table tbody tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover td { background: #fafbfc; }

    .rank-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px; height: 22px;
        border-radius: 50%;
        font-size: 0.68rem;
        font-weight: 800;
        background: #f1f5f9;
        color: #94a3b8;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .rank-num.top3 { background: var(--accent-soft); color: #7a5c1e; }

    .td-instansi {
        display: flex;
        align-items: center;
    }

    .count-chip-edu  { background: rgba(27,58,82,0.08);  color: var(--primary); padding: 0.2rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
    .count-chip-work { background: rgba(22,163,74,0.08); color: var(--success); padding: 0.2rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }

    /* ─── EMPTY ─── */
    .empty-mini {
        text-align: center;
        padding: 2.5rem 1rem;
    }

    .empty-mini i { font-size: 2rem; opacity: 0.12; color: var(--primary); display: block; margin-bottom: 0.6rem; }
    .empty-mini p { color: #94a3b8; font-size: 0.83rem; font-weight: 600; margin: 0; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .report-table .hide-md { display: none; }
        .stat-card { padding: 1rem; }
        .stat-card-num { font-size: 1.35rem; }
    }

    /* ─── PRINT ─── */
    @media print {
        .no-print { display: none !important; }
        .card-section { border: 1px solid #ddd !important; box-shadow: none !important; border-radius: 0 !important; }
        .report-table td, .report-table th { font-size: 9pt !important; border: 1px solid #dee2e6 !important; }
        .num-chip, .status-tag { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
    }
</style>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-icon icon-primary"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-card-num num-primary">{{ number_format($stats['total_alumni']) }}</div>
                <div class="stat-card-label">Total Alumni</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-icon icon-success"><i class="bi bi-patch-check-fill"></i></div>
            <div>
                <div class="stat-card-num num-success">{{ number_format($stats['alumni_verified']) }}</div>
                <div class="stat-card-label">Alumni Verified</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-icon icon-warning"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-card-num num-warning">{{ number_format($stats['alumni_pending']) }}</div>
                <div class="stat-card-label">Menunggu Verifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-icon icon-info"><i class="bi bi-file-earmark-check-fill"></i></div>
            <div>
                <div class="stat-card-num num-info">{{ number_format($stats['profil_lengkap']) }}</div>
                <div class="stat-card-label">Profil Lengkap</div>
            </div>
        </div>
    </div>
</div>

{{-- ── TABLE ANGKATAN ── --}}
<div class="card-section">
    <div class="card-section-header">
        <div class="card-section-title">
            <i class="bi bi-bar-chart-fill"></i> Statistik per Angkatan
        </div>
        <button onclick="window.print()" class="btn-print-sm no-print">
            <i class="bi bi-printer-fill"></i>
            <span class="d-none d-sm-inline">Cetak Laporan</span>
        </button>
    </div>

    <div class="table-responsive">
        <table class="report-table">
            <thead>
                <tr>
                    <th>Angkatan</th>
                    <th class="hide-md">Tahun Ajaran</th>
                    <th class="hide-md">Status</th>
                    <th class="col-right">Alumni</th>
                    <th class="col-right hide-md">Verified</th>
                    <th class="col-right hide-md">Pending</th>
                    <th class="col-right hide-md">Lengkap</th>
                    <th class="col-end no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($angkatanStats as $angkatan)
                    <tr>
                        <td>{{ $angkatan->nama_angkatan }}</td>
                        <td class="td-year hide-md">{{ $angkatan->tahun_ajaran }}</td>
                        <td class="hide-md">
                            @if($angkatan->status === 'LULUS')
                                <span class="status-tag tag-lulus"><i class="bi bi-check-circle-fill"></i> LULUS</span>
                            @elseif($angkatan->status === 'AKTIF')
                                <span class="status-tag tag-aktif"><i class="bi bi-play-circle-fill"></i> AKTIF</span>
                            @endif
                        </td>
                        <td class="col-right">
                            <span class="num-chip chip-total">{{ $angkatan->alumni_count }}</span>
                        </td>
                        <td class="col-right hide-md">
                            <span class="num-chip chip-verified">{{ $angkatan->verified_count }}</span>
                        </td>
                        <td class="col-right hide-md">
                            <span class="num-chip chip-pending">{{ $angkatan->pending_count }}</span>
                        </td>
                        <td class="col-right hide-md">
                            <span class="num-chip chip-lengkap">{{ $angkatan->complete_count }}</span>
                        </td>
                        <td class="col-end no-print">
                            <a href="{{ route('admin.laporan.angkatan', $angkatan->id) }}" class="btn-detail">
                                <i class="bi bi-eye"></i>
                                <span class="d-none d-md-inline">Detail</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">TOTAL KESELURUHAN</td>
                    <td class="col-right">{{ number_format($stats['total_alumni']) }}</td>
                    <td class="col-right hide-md">{{ number_format($stats['alumni_verified']) }}</td>
                    <td class="col-right hide-md">{{ number_format($stats['alumni_pending']) }}</td>
                    <td class="col-right hide-md">{{ number_format($stats['profil_lengkap']) }}</td>
                    <td class="col-end no-print"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- ── BOTTOM ROWS ── --}}
<div class="row g-4">

    {{-- Top 10 Pendidikan --}}
    <div class="col-12 col-lg-6">
        <div class="card-section" style="margin-bottom:0;">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-mortarboard-fill"></i> Top 10 Pendidikan Lanjutan
                </div>
            </div>
            @if($pendidikanStats->count() > 0)
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>Sekolah / Universitas</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendidikanStats as $i => $item)
                            <tr>
                                <td>
                                    <div class="td-instansi">
                                        <span class="rank-num {{ $i < 3 ? 'top3' : '' }}">{{ $i + 1 }}</span>
                                        {{ $item->pendidikan_lanjutan }}
                                    </div>
                                </td>
                                <td><span class="count-chip-edu">{{ $item->total }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-mini">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada data pendidikan</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Top 10 Pekerjaan --}}
    <div class="col-12 col-lg-6">
        <div class="card-section" style="margin-bottom:0;">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-briefcase-fill"></i> Top 10 Pekerjaan
                </div>
            </div>
            @if($pekerjaanStats->count() > 0)
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>Bidang Pekerjaan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pekerjaanStats as $i => $item)
                            <tr>
                                <td>
                                    <div class="td-instansi">
                                        <span class="rank-num {{ $i < 3 ? 'top3' : '' }}">{{ $i + 1 }}</span>
                                        {{ $item->pekerjaan }}
                                    </div>
                                </td>
                                <td><span class="count-chip-work">{{ $item->total }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-mini">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada data pekerjaan</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
