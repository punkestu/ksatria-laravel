<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProkerStatus extends Notification
{
    use Queueable;

    protected $programKerjaItem;
    protected $actor;
    protected $status;

    public static function notify($users, $actor, $programKerjaItem, $status)
    {
        foreach ($users as $user) {
            $user->notify(new self($actor, $programKerjaItem, $status));
        }
    }

    /**
     * Create a new notification instance.
     */
    public function __construct($actor, $programKerjaItem, $status)
    {
        $this->actor = $actor;
        $this->programKerjaItem = $programKerjaItem;
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
            "message" => "Pengajuan Program Kerja {$this->programKerjaItem->name} cabang {$this->programKerjaItem->cabang->name} telah {$this->status}.",
            "redirect_url" => route('pengajuanproker.show', $this->programKerjaItem->id, false),
            "data" => [
                "actor" => $this->actor,
                "programKerjaItemId" => $this->programKerjaItem->id,
                "status" => $this->status,
            ],
        ];
    }
}
