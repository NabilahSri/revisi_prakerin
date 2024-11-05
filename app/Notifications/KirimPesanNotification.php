<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class KirimPesanNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // private $channels;
    private $pesan;
    public function __construct(String $pesan)
    {
        // $this->channels = $channels;
        $this->pesan = $pesan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line($this->pesan);
    // }

    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
                title: 'Jurnal Prakerin',
                body: $this->pesan,
                // image: url('https://ppdb.smk-ypc.sch.id/pages/gambar/Logo_smk.gif')
        )));
            // ->data(['data1' => 'value', 'data2' => 'value2']);
    }
}
