<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumniExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    /**
     * Counter baris — instance property (bukan static) agar
     * aman jika export dipanggil lebih dari sekali dalam satu request.
     */
    protected int $counter = 1;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query dengan filter
     */
    public function query()
    {
        $query = Alumni::with(['angkatan', 'pendidikan', 'pekerjaan']);

        // Filter status verifikasi
        if (!empty($this->filters['status'])) {
            $query->where('status_verifikasi', $this->filters['status']);
        }

        // Filter angkatan
        if (!empty($this->filters['angkatan_id'])) {
            $query->where('angkatan_id', $this->filters['angkatan_id']);
        }

        // Filter kelengkapan profil
        if (isset($this->filters['complete']) && $this->filters['complete'] !== '') {
            $query->where('is_profile_complete', (int)$this->filters['complete']);
        }

        return $query->orderBy('nama_lengkap');
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIPD',
            'Jenis Kelamin',
            'NISN',
            'Angkatan ID',
            'Tahun Lulus',
            'Email',
            'No HP / WA',
            'Alamat',
            'Status Verifikasi',
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($alumni): array
    {
        // Akses collection yang sudah di-eager-load di collection() — TIDAK trigger query baru
        $pendidikanTerakhir = $alumni->pendidikan
            ->sortByDesc('tahun_lulus')
            ->first();
        $pendidikanText = $pendidikanTerakhir
            ? $pendidikanTerakhir->jenjang . ' - ' . $pendidikanTerakhir->nama_instansi
            : '-';

        // Akses collection pekerjaan yang sudah di-eager-load
        $pekerjaanTerkini = $alumni->pekerjaan->firstWhere('is_current', true)
            ?? $alumni->pekerjaan->last();
        $pekerjaanText = $pekerjaanTerkini
            ? $pekerjaanTerkini->jabatan . ' di ' . $pekerjaanTerkini->nama_perusahaan
            : '-';

        // Status verifikasi dalam bahasa Indonesia
        $statusText = match($alumni->status_verifikasi) {
            'verified' => 'Terverifikasi',
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
            default => $alumni->status_verifikasi,
        };

        // Kelengkapan profil
        $profilLengkap = $alumni->is_profile_complete ? 'Lengkap' : 'Belum Lengkap';

        return [
            $alumni->nama_lengkap,
            $alumni->nipd ?? '-',
            $alumni->jenis_kelamin ?? '-',
            $alumni->nisn,
            $alumni->angkatan_id,
            $alumni->tahun_lulus,
            $alumni->email ?? '-',
            $alumni->no_hp ?? '-',
            $alumni->alamat ?? '-',
            $statusText,
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Header styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '213448'], // Primary color
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                    'wrapText' => true,
                ],
            ],
        ];
    }
}
