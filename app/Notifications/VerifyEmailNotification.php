<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = route('verify.email', ['token' => $notifiable->verification_token]);

        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->line('Klik tombol di bawah untuk verifikasi email Anda.')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Terima kasih telah mendaftar!');
    }
}
