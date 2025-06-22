<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgendaNotification extends Notification
{
    use Queueable;

    protected $agenda;
    protected $actor;

    public static function notify($users, $actor, $agenda)
    {
        foreach ($users as $user) {
            $user->notify(new self($actor, $agenda));
        }
    }

    /**
     * Create a new notification instance.
     */
    public function __construct($actor, $agenda)
    {
        $this->actor = $actor;
        $this->agenda = $agenda;
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
            "type" => "Agenda",
            "message" => "Agenda {$this->agenda->title} telah dibuat.",
            "redirect_url" => route('agenda.show', $this->agenda->id, false),
            "data" => [
                "actor" => $this->actor,
                "agendaId" => $this->agenda->id
            ],
        ];
    }
}
