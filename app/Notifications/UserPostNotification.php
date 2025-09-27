<?php

namespace App\Notifications;

use App\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserPostNotification extends Notification
{
    use Queueable;

    protected string $type;
    protected string $text;
    public ?string $expiresAt;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $type, string $text, ?string $expiresAt = null)
    {
        $this->type = $type;
        $this->text = $text;
        $this->expiresAt = $expiresAt;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [DatabaseChannel::class]; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'title' => $this->text,
            'expires_at' => $this->expiresAt,
        ];
    }
}
