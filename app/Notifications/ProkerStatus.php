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
    protected $actor;
    protected $status;

    public static function notify($users, $actor, $programKerjaItemId, $status)
    {
        foreach ($users as $user) {
            $user->notify(new self($actor, $programKerjaItemId, $status));
        }
    }

    /**
     * Create a new notification instance.
     */
    public function __construct($actor, $programKerjaItemId, $status)
    {
        $this->actor = $actor;
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
            "message" => "Pengajuan Program Kerja dengan ID {$this->programKerjaItemId} telah {$this->status} oleh: {$this->actor->name}.",
            "redirect_url" => route('pengajuanproker.show', $this->programKerjaItemId, false),
            "data" => [
                "actor" => $this->actor,
                "programKerjaItemId" => $this->programKerjaItemId,
                "status" => $this->status,
            ],
        ];
    }
}
