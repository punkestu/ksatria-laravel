<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProkerStatus extends Notification
{
    use Queueable;

    protected $programKerjaItemId;
    protected $status;

    public static function notify($users, $programKerjaItemId, $status)
    {
        foreach ($users as $user) {
            $user->notify(new self($programKerjaItemId, $status));
        }
    }

    /**
     * Create a new notification instance.
     */
    public function __construct($programKerjaItemId, $status)
    {
        $this->programKerjaItemId = $programKerjaItemId;
        $this->status = $status;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "type" => "Program Kerja",
            "message" => "Program Kerja dengan ID {$this->programKerjaItemId} telah {$this->status}.",
            "redirect_url" => route('pengajuanproker.show', $this->programKerjaItemId, false),
            "data" => [
                "programKerjaItemId" => $this->programKerjaItemId,
                "status" => $this->status,
            ],
        ];
    }
}
