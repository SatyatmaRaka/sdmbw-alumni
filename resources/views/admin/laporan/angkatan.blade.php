@extends('layouts.admin')

@section('title', 'Laporan Angkatan')
@section('page-title', 'Laporan ' . $angkatan->nama_angkatan)

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

    /* ─── MAIN CARD ─── */
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
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        position: relative;
    }

    .card-section-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    /* dot grid */
    .card-section-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 18px 18px;
        pointer-events: none;
    }

    .header-info { position: relative; z-index: 1; }

    .header-angkatan {
        font-family: 'DM Serif Display', Georgia, serif;
        font-weight: 400;
        font-size: 1.35rem;
        color: white;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .header-meta {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.5);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }

    .btn-back-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.42rem 1rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.75);
        border-radius: 9px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-back-sm:hover { background: rgba(255,255,255,0.16); color: white; border-color: rgba(255,255,255,0.28); }

    .btn-print-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.42rem 1rem;
        background: var(--accent);
        border: none;
        color: var(--primary-dark);
        border-radius: 9px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-print-sm:hover {
        background: #d9b75e;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(232,200,122,0.35);
    }

    .card-section-body { padding: 1.5rem; }

    /* ─── STAT MINI CARDS ─── */
    .stat-mini-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stat-mini {
        background: #fafbfc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 0.85rem 0.75rem;
        text-align: center;
        transition: var(--transition);
    }

    .stat-mini:hover {
        background: white;
        border-color: rgba(232,200,122,0.3);
        box-shadow: 0 4px 12px rgba(27,58,82,0.07);
        transform: translateY(-2px);
    }

    .stat-mini-num {
        display: block;
        font-weight: 800;
        font-size: 1.5rem;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-mini-label {
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
    }

    .num-total    { color: var(--primary); }
    .num-verified { color: var(--success); }
    .num-pending  { color: var(--warning); }
    .num-rejected { color: var(--danger); }
    .num-lengkap  { color: #0891b2; }
    .num-belum    { color: #64748b; }

    /* ─── SECTION DIVIDER ─── */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 1.5rem 0 1rem;
    }

    .section-divider-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #94a3b8;
        white-space: nowrap;
    }

    .section-divider-line {
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    /* ─── TABLE ─── */
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }

    .report-table thead th {
        background: #f8fafc;
        padding: 0.65rem 0.9rem;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .report-table thead th:first-child { padding-left: 1.25rem; text-align: center; }
    .report-table thead th:last-child  { text-align: center; }

    .report-table tbody td {
        padding: 0.75rem 0.9rem;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
        color: #334155;
    }

    .report-table tbody td:first-child { padding-left: 1.25rem; text-align: center; color: #94a3b8; font-size: 0.8rem; }
    .report-table tbody td:last-child  { text-align: center; }

    .report-table tbody tr:last-child td { border-bottom: none; }
    .report-table tbody tr:hover td { background: #fafbfc; }

    .td-nisn {
        font-family: 'Courier New', monospace;
        font-size: 0.83rem;
        font-weight: 700;
        color: var(--primary);
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 5px;
        display: inline-block;
    }

    .td-nama { font-weight: 700; color: var(--primary); }
    .td-muted { color: #64748b; font-size: 0.82rem; }
    .td-small { font-size: 0.8rem; color: #475569; }

    .v-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.22rem 0.65rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .v-verified { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .v-pending  { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .v-rejected { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }

    /* ─── EMPTY ─── */
    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }

    .empty-state i { font-size: 2.5rem; opacity: 0.12; color: var(--primary); display: block; margin-bottom: 0.75rem; }
    .empty-state p { color: #94a3b8; font-weight: 600; font-size: 0.875rem; margin: 0; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .stat-mini-grid { grid-template-columns: repeat(3, 1fr); }
        .report-table thead th:nth-child(4),
        .report-table thead th:nth-child(5),
        .report-table tbody td:nth-child(4),
        .report-table tbody td:nth-child(5) { display: none; }
    }

    @media (max-width: 480px) {
        .stat-mini-grid { grid-template-columns: repeat(2, 1fr); }
        .header-angkatan { font-size: 1.1rem; }
    }

    /* ─── PRINT ─── */
    @media print {
        .sidebar,
        .topbar,
        .no-print,
        footer,
        .navbar {
            display: none !important;
        }

        .main-content, body {
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-section {
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        .card-section-header {
            background: var(--primary-dark) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .stat-mini {
            border: 1px solid #dee2e6 !important;
        }

        .report-table thead th {
            background: #f8fafc !important;
            -webkit-print-color-adjust: exact;
        }

        .report-table td, .report-table th {
            font-size: 9pt !important;
            border: 1px solid #dee2e6 !important;
        }

        .v-pill {
            border: 1px solid #000 !important;
            color: #000 !important;
            background: transparent !important;
        }
    }
</style>

{{-- ── MAIN CARD ── --}}
<div class="card-section">

    {{-- Header --}}
    <div class="card-section-header no-print">
        <div class="header-info">
            <h5 class="header-angkatan">{{ $angkatan->nama_angkatan }}</h5>
            <span class="header-meta">
                <i class="bi bi-calendar3"></i> Tahun Ajaran: {{ $angkatan->tahun_ajaran }}
            </span>
        </div>
        <div class="header-actions no-print">
            <a href="{{ route('admin.laporan.index') }}" class="btn-back-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn-print-sm">
                <i class="bi bi-printer-fill"></i> Print
            </button>
        </div>
    </div>

    <div class="card-section-body">

        {{-- Stat Mini Grid --}}
        <div class="stat-mini-grid">
            <div class="stat-mini">
                <span class="stat-mini-num num-total">{{ $stats['total'] }}</span>
                <span class="stat-mini-label">Total</span>
            </div>
            <div class="stat-mini">
                <span class="stat-mini-num num-verified">{{ $stats['verified'] }}</span>
                <span class="stat-mini-label">Verified</span>
            </div>
            <div class="stat-mini">
                <span class="stat-mini-num num-pending">{{ $stats['pending'] }}</span>
                <span class="stat-mini-label">Pending</span>
            </div>
            <div class="stat-mini">
                <span class="stat-mini-num num-rejected">{{ $stats['rejected'] }}</span>
                <span class="stat-mini-label">Rejected</span>
            </div>
            <div class="stat-mini">
                <span class="stat-mini-num num-lengkap">{{ $stats['lengkap'] }}</span>
                <span class="stat-mini-label">Profil Lengkap</span>
            </div>
            <div class="stat-mini">
                <span class="stat-mini-num num-belum">{{ $stats['belum_lengkap'] }}</span>
                <span class="stat-mini-label">Belum Lengkap</span>
            </div>
        </div>

        {{-- Table Header --}}
        <div class="section-divider">
            <span class="section-divider-label">
                <i class="bi bi-people-fill me-1"></i> Daftar Alumni Angkatan
            </span>
            <div class="section-divider-line"></div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width:4%;">No</th>
                        <th style="width:11%;">NISN</th>
                        <th>Nama Lengkap</th>
                        <th style="width:12%;">Username</th>
                        <th style="width:12%;">No. HP</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Pekerjaan Terkini</th>
                        <th style="width:9%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumniFormatted as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="td-nisn">{{ $item['nisn'] }}</span></td>
                            <td class="td-nama">{{ $item['nama_lengkap'] }}</td>
                            <td class="td-muted">{{ $item['username'] }}</td>
                            <td class="td-muted">{{ \App\Helpers\FormatHelper::phone($item['no_hp'] ?? null) }}</td>
                            <td class="td-small">{{ $item['pendidikan_terakhir'] }}</td>
                            <td class="td-small">{{ $item['pekerjaan_terkini'] }}</td>
                            <td>
                                @if($item['status_verifikasi'] === 'verified')
                                    <span class="v-pill v-verified"><i class="bi bi-patch-check-fill"></i> Verified</span>
                                @elseif($item['status_verifikasi'] === 'pending')
                                    <span class="v-pill v-pending"><i class="bi bi-hourglass-split"></i> Pending</span>
                                @else
                                    <span class="v-pill v-rejected"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>Belum ada alumni di angkatan ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
