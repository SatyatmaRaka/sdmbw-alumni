<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlumniAccountStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $alumniName;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $alumniName)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($this->status === 'verified') {
            return (new MailMessage)
                ->subject('Pemberitahuan: Akun Alumni Anda Telah Diverifikasi')
                ->greeting('Halo ' . $this->alumniName . '!')
                ->line('Selamat! Akun Anda di portal Alumni SD Muhammadiyah Birrul Walidain Kudus telah berhasil diverifikasi oleh Admin.')
                ->line('Anda sekarang dapat masuk secara penuh menggunakan NISN dan berpartisipasi dalam komunitas, melengkapi direktori, serta melihat data rekan alumni lainnya.')
                ->action('Masuk Sekarang', url('/login'))
                ->line('Mari bersama-sama membangun jaringan yang kuat dan inspiratif!');
        } else {
            return (new MailMessage)
                ->subject('Pemberitahuan: Pendaftaran Alumni Ditolak')
                ->greeting('Mohon Maaf, ' . $this->alumniName . '.')
                ->line('Pendaftaran Anda di portal Alumni SD Muhammadiyah Birrul Walidain Kudus tidak dapat disetujui pada saat ini.')
                ->line('Hal ini biasanya dikarenakan oleh ketidaksesuaian data yang Anda berikan dengan catatan sistem kami (misalnya: NISN atau Angkatan yang salah).')
                ->line('Silakan hubungi Admin Sekolah untuk informasi lebih lanjut atau klarifikasi data Anda.')
                ->action('Hubungi Admin (WhatsApp)', 'https://wa.me/6281248076886')
                ->line('Terima kasih atas pengertiannya.');
        }
    }
}
