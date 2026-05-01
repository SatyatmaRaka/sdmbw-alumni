<?php

namespace App\Observers;

use App\Models\Alumni;
use App\Models\AlumniPendidikan;
use App\Models\AlumniPekerjaan;

class AlumniCompletenessObserver
{
    /**
     * Handle the "saved" event for all observed models.
     */
    public function saved($model): void
    {
        $this->sync($model);
    }

    /**
     * Handle the "deleted" event for all observed models.
     */
    public function deleted($model): void
    {
        $this->sync($model);
    }

    /**
     * Sync the profile completeness status.
     */
    protected function sync($model): void
    {
        $alumni = null;

        if ($model instanceof Alumni) {
            $alumni = $model;
        } elseif ($model instanceof AlumniPendidikan || $model instanceof AlumniPekerjaan) {
            $alumni = $model->alumni;
        }

        if ($alumni) {
            // Kita hitung ulang status kelengkapan
            $isComplete = $alumni->isDataComplete();
            
            // Hanya update jika status berubah untuk menghindari infinite loop
            if ($alumni->is_profile_complete !== $isComplete) {
                // Gunakan updateQuietly agar tidak memicu event 'saved' lagi
                $alumni->updateQuietly(['is_profile_complete' => $isComplete]);
            }
        }
    }
}
