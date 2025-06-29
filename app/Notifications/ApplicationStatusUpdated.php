<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    protected $status;
    protected $applicationId;
    protected $customMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $applicationId, $customMessage = null)
    {
        $this->status = $status;
        $this->applicationId = $applicationId;
        $this->customMessage = $customMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Hostel Application Notification')
            ->greeting('Hi ' . $notifiable->username . ',');

        if ($this->customMessage) {
            $message->line($this->customMessage);
        } else {
            $message->line('**Status:** ' . ucfirst($this->status));
        }

        $message->action('View Application', route('mainresidentapplication'))
                ->line('Thank you for using our Hostel Management System!');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
            'message' => $this->customMessage
                ?? 'Your hostel application status has been updated to ' . ucfirst($this->status),
            'url' => route('mainresidentapplication'),
        ];
    }
}
