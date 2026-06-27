<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AlumniAccountStatusNotification extends Notification
{
    use Queueable;

    public string $status;
    public string $alumniName;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $status, string $alumniName)
    {
        $this->status = $status;
        $this->alumniName = $alumniName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        if ($this->status === 'verified') {
            return [
                'type' => 'account_status',
                'title' => 'Akun Anda Telah Diverifikasi',
                'message' => "Halo {$this->alumniName}, akun Anda telah diverifikasi. Silakan masuk untuk melanjutkan.",
                'icon' => 'success',
            ];
        }

        return [
            'type' => 'account_status',
            'title' => 'Pendaftaran Tidak Disetujui',
            'message' => "Halo {$this->alumniName}, pendaftaran Anda tidak disetujui. Silakan hubungi admin untuk informasi lebih lanjut.",
            'icon' => 'danger',
        ];
    }
}
