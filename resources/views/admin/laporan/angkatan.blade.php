@extends('layouts.admin')

@section('title', 'Laporan Angkatan')
@section('page-title', 'Laporan ' . $angkatan->nama_angkatan)

@section('content')
<div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
        <div>
            <div class="fw-bold fs-5"><i class="bi bi-calendar3 me-2"></i> {{ $angkatan->nama_angkatan }}</div>
            <small class="opacity-75">Tahun Ajaran: {{ $angkatan->tahun_ajaran }}</small>
        </div>
        <div class="d-flex gap-2 no-print">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-light-premium btn-sm rounded-pill px-3 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak
            </button>
        </div>
    </div>
    <div class="card-body p-4">
        
        <!-- Stat Grid -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-primary line-height-1">{{ $stats['total'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Total</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-success line-height-1">{{ $stats['verified'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Verified</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-warning line-height-1">{{ $stats['pending'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Pending</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-danger line-height-1">{{ $stats['rejected'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Rejected</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-info line-height-1">{{ $stats['lengkap'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Lengkap</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <div class="fw-800 fs-4 text-secondary line-height-1">{{ $stats['belum_lengkap'] }}</div>
                    <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.6rem;">Belum</div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light text-uppercase small fw-bold">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>NISN</th>
                        <th>Nama Lengkap</th>
                        <th>No. HP</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Pekerjaan Terkini</th>
                        <th class="text-center pe-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumniFormatted as $index => $item)
                        <tr>
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td><code class="fw-bold text-primary">{{ $item['nisn'] }}</code></td>
                            <td class="fw-bold">{{ $item['nama_lengkap'] }}</td>
                            <td class="small text-muted">{{ $item['no_hp'] }}</td>
                            <td class="small">{{ $item['pendidikan_terakhir'] }}</td>
                            <td class="small">{{ $item['pekerjaan_terkini'] }}</td>
                            <td class="text-center pe-3">
                                @if($item['status_verifikasi'] === 'verified')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Verified</span>
                                @elseif($item['status_verifikasi'] === 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                Belum ada alumni di angkatan ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-header { background-color: var(--primary) !important; color: white !important; -webkit-print-color-adjust: exact; }
    }
    .fw-800 { font-weight: 800; }
    .line-height-1 { line-height: 1; }
    .btn-light-premium {
        background: #fff;
        color: var(--primary);
        border: 1px solid #e2e8f0;
    }
    .btn-light-premium:hover {
        background: #f8fafc;
    }
</style>
@endsection
