@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Ringkasan Sistem')

@push('styles')
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
        border-radius: var(--radius);
        padding: 1.4rem 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        text-decoration: none;
        display: block;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.22);
        color: white;
    }

    /* dot grid overlay */
    .stat-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 18px 18px;
        pointer-events: none;
    }

    .stat-card-primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); }
    .stat-card-success { background: linear-gradient(135deg, #15803d 0%, #22c55e 100%); }
    .stat-card-warning { background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); }
    .stat-card-info    { background: linear-gradient(135deg, #0e7490 0%, #22d3ee 100%); }

    .stat-card-inner { position: relative; z-index: 1; }

    .stat-icon {
        font-size: 2rem;
        opacity: 0.2;
        float: right;
        margin-top: -4px;
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon { opacity: 0.35; transform: scale(1.1); }

    .stat-number {
        font-weight: 800;
        font-size: 2rem;
        margin: 0.5rem 0 0.2rem;
        line-height: 1;
        display: block;
    }

    .stat-label {
        font-size: 0.82rem;
        opacity: 0.88;
        font-weight: 600;
        margin: 0;
    }

    /* notification badge */
    .stat-badge {
        position: absolute;
        top: -6px; right: -6px;
        background: #ef4444;
        color: white;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 50px;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(239,68,68,0.4);
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%   { box-shadow: 0 0 0 0 rgba(239,68,68,0.4); }
        70%  { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
        100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
    }

    /* ─── SECTION CARD ─── */
    .card-section {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        height: 100%;
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
        letter-spacing: 0.3px;
    }

    .card-section-title i { opacity: 0.8; }

    .card-section-body { padding: 0; }

    .btn-lihat-semua {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3rem 0.85rem;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        color: rgba(255,255,255,0.85);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-lihat-semua:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        border-color: rgba(255,255,255,0.3);
    }

    /* ─── TABLE ─── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table thead th {
        background: #f8fafc;
        padding: 0.75rem 1.25rem;
        font-size: 0.67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #f8fafc;
        color: var(--primary);
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }

    .data-table tbody tr:hover td { background: #fafbfc; }

    .td-angkatan { font-weight: 700; }
    .td-tahun    { color: #64748b; }
    .td-count strong { font-weight: 800; font-size: 1rem; }
    .td-count small  { color: #94a3b8; }

    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.7rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .tag-lulus { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .tag-aktif { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .tag-other { background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; }

    /* ─── RECENT ALUMNI LIST ─── */
    .alumni-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #f8fafc;
        transition: var(--transition);
        gap: 0.75rem;
    }

    .alumni-item:last-child { border-bottom: none; }
    .alumni-item:hover { background: #fafbfc; }

    .alumni-item-left {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
        flex: 1;
    }

    .alumni-avatar-sm {
        width: 40px; height: 40px;
        border-radius: 10px;
        overflow: hidden;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 2px solid #f1f5f9;
    }

    .alumni-avatar-sm img { width: 100%; height: 100%; object-fit: cover; }

    .alumni-avatar-sm i { font-size: 1.1rem; color: rgba(255,255,255,0.25); }

    .alumni-item-name {
        font-weight: 700;
        font-size: 0.875rem;
        color: var(--primary);
        text-decoration: none;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: var(--transition);
    }

    .alumni-item-name:hover { color: var(--primary-light); }

    .alumni-item-meta {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .v-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .v-verified { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .v-pending  {
        background: rgba(217,119,6,0.1);
        border: 1px solid rgba(217,119,6,0.22);
        color: var(--warning);
        animation: pulse-pending 2s infinite;
    }
    .v-rejected { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }

    @keyframes pulse-pending {
        0%   { box-shadow: 0 0 0 0 rgba(217,119,6,0.25); }
        70%  { box-shadow: 0 0 0 6px rgba(217,119,6,0); }
        100% { box-shadow: 0 0 0 0 rgba(217,119,6,0); }
    }

    /* ─── EMPTY STATE ─── */
    .empty-mini {
        text-align: center;
        padding: 2.5rem 1rem;
    }

    .empty-mini i { font-size: 2.5rem; opacity: 0.15; color: var(--primary); display: block; margin-bottom: 0.75rem; }
    .empty-mini p { font-size: 0.83rem; color: #94a3b8; margin: 0; }

    /* ─── SUMMARY ALERT ─── */
    .summary-alert {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        border-left: 4px solid var(--info);
        box-shadow: var(--shadow-card);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 1.5rem;
    }

    .summary-alert i { font-size: 1.1rem; color: var(--info); flex-shrink: 0; margin-top: 2px; }
    .summary-alert h6 { font-weight: 700; color: var(--primary); margin-bottom: 3px; font-size: 0.88rem; }
    .summary-alert p  { font-size: 0.83rem; color: #64748b; margin: 0; }
</style>
@endpush

@section('content')

{{-- ── STAT CARDS ── --}}
<admin-stats :data-prop="{{ json_encode($stats) }}"></admin-stats>

{{-- ── MAIN TABLES ── --}}
<div class="row g-3">

    {{-- Statistik Per Angkatan --}}
    <div class="col-lg-7">
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-bar-chart-fill"></i> Statistik Per Angkatan
                </div>
            </div>
            <div class="card-section-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Angkatan</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th style="text-align:center;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($angkatanStats as $angkatan)
                                <tr>
                                    <td class="td-angkatan">{{ $angkatan->nama_angkatan }}</td>
                                    <td class="td-tahun">{{ $angkatan->tahun_ajaran }}</td>
                                    <td>
                                        @if($angkatan->status === 'LULUS')
                                            <span class="status-tag tag-lulus"><i class="bi bi-check-circle-fill"></i> LULUS</span>
                                        @elseif($angkatan->status === 'AKTIF')
                                            <span class="status-tag tag-aktif"><i class="bi bi-play-circle-fill"></i> AKTIF</span>
                                        @else
                                            <span class="status-tag tag-other">{{ $angkatan->status }}</span>
                                        @endif
                                    </td>
                                    <td class="td-count" style="text-align:center;">
                                        <strong>{{ number_format($angkatan->alumni_count) }}</strong>
                                        <small>Orang</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-mini">
                                            <i class="bi bi-inbox"></i>
                                            <p>Belum ada data angkatan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Pendaftar Terbaru --}}
    <div class="col-lg-5">
        <div class="card-section">
            <div class="card-section-header">
                <div class="card-section-title">
                    <i class="bi bi-person-plus-fill"></i> Pendaftar Terbaru
                </div>
                <a href="{{ route('admin.alumni.index') }}" class="btn-lihat-semua">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-section-body">
                @forelse($recentAlumni as $alumni)
                    @php $foto = $alumni->fotos->where('is_main', true)->first(); @endphp
                    <div class="alumni-item">
                        <div class="alumni-item-left">
                            <div class="alumni-avatar-sm">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto->path_file) }}"
                                         alt="{{ $alumni->nama_lengkap }}">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                            <div style="min-width:0;">
                                <a href="{{ route('admin.alumni.show', $alumni) }}" class="alumni-item-name">
                                    {{ $alumni->nama_lengkap }}
                                </a>
                                <span class="alumni-item-meta">{{ $alumni->angkatan->nama_angkatan ?? 'Tanpa Angkatan' }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="v-pill v-verified"><i class="bi bi-patch-check-fill"></i> Terdaftar</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-mini">
                        <i class="bi bi-inbox"></i>
                        <p>Belum ada pendaftar baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ── ANALYTICAL CHARTS ── --}}
<admin-charts :stats="{{ json_encode($stats) }}" :angkatan-data="{{ json_encode($angkatanStats) }}"></admin-charts>

{{-- ── SUMMARY ── --}}
<div class="summary-alert">
    <i class="bi bi-info-circle-fill"></i>
    <div>
        <h6>Ringkasan Alumni</h6>
        <p>
            Sistem mencatat <strong>{{ $stats['total_alumni'] }}</strong> total alumni yang telah terdaftar dan aktif dalam database.
        </p>
    </div>
</div>

@endsection
