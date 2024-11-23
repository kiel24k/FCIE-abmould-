<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementCreated extends Notification
{
    use Queueable;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Stock Alert Notification')
            ->greeting('Hello!')
            ->line($this->message)  
            ->action('Back to page', url('/'))
            ->line('Thank you');
           
    }
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
}
