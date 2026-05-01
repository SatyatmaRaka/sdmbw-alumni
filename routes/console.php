<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
*/

// Hapus file export Excel yang berumur > 7 hari (setiap hari jam 02:00)
Schedule::call(function () {
    $files = Storage::disk('public')->files('exports');
    $deleted = 0;

    foreach ($files as $file) {
        $lastModified = Storage::disk('public')->lastModified($file);
        // Hapus jika lebih dari 7 hari
        if (now()->timestamp - $lastModified > (7 * 24 * 60 * 60)) {
            Storage::disk('public')->delete($file);
            $deleted++;
        }
    }

    if ($deleted > 0) {
        \Illuminate\Support\Facades\Log::info("Auto-cleanup: {$deleted} file export Excel dihapus (> 7 hari).");
    }
})->dailyAt('02:00')->name('cleanup-export-files')->withoutOverlapping();

// Hapus file imports sementara yang berumur > 1 hari (setiap hari jam 03:00)
Schedule::call(function () {
    $files = Storage::files('imports');
    $deleted = 0;

    foreach ($files as $file) {
        $lastModified = Storage::lastModified($file);
        if (now()->timestamp - $lastModified > (24 * 60 * 60)) {
            Storage::delete($file);
            $deleted++;
        }
    }

    if ($deleted > 0) {
        \Illuminate\Support\Facades\Log::info("Auto-cleanup: {$deleted} file import sementara dihapus (> 1 hari).");
    }
})->dailyAt('03:00')->name('cleanup-import-files')->withoutOverlapping();
