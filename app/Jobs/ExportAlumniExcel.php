<?php

namespace App\Jobs;

use App\Exports\AlumniExport;
use App\Models\AdminLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ExportAlumniExcel implements ShouldQueue
{
    use Queueable;

    protected $filters;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($filters, $userId)
    {
        $this->filters = $filters;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Buat nama file unik
        $filename = 'exports/alumni_export_' . date('Ymd_His') . '.xlsx';
        
        // 2. Export dan simpan di Storage Public (storage/app/public/exports/...)
        Excel::store(new AlumniExport($this->filters), $filename, 'public');

        // 3. Log sebagai "Notifikasi" ke Admin yang me-request
        $downloadUrl = asset('storage/' . $filename);
        
        AdminLog::log(
            $this->userId,
            AdminLog::ACTION_EXPORT_ALUMNI,
            'alumni',
            null,
            "Export data alumni Selesai! File tersedia di: <a href='{$downloadUrl}' target='_blank'>Download Excel</a>"
        );
    }
}
