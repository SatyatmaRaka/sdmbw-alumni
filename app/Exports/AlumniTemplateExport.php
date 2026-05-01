<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class AlumniTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell, WithTitle
{
    public function title(): string
    {
        return 'Template Import Alumni';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function collection()
    {
        return new Collection([
            [
                '1',
                'Budi Santoso',
                '12345678',
                'L',
                '0012345678',
                'Angkatan 1',
                '2021'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Nama Lengkap',
            'NIPD',
            'Jenis Kelamin',
            'NISN',
            'Angkatan',
            'Tahun Lulus'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Instruksi di bagian atas
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'PANDUAN IMPORT DATA ALUMNI SD MUHAMMADIYAH BW');
        
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', '1. Jangan mengubah urutan kolom. 2. NISN wajib 10 digit. 3. Jenis Kelamin isi L atau P.');
        
        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue('A3', '4. Angkatan bisa diisi Nama Angkatan (misal: Angkatan 1). Data dimulai dari baris ke-5.');

        return [
            // Style Header Judul
            1 => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B3A52']
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
            // Style Instruksi
            2 => [
                'font' => ['italic' => true, 'color' => ['rgb' => '555555']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
            3 => [
                'font' => ['italic' => true, 'color' => ['rgb' => '555555']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
            // Style Header Tabel
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2C3E50']
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
}
