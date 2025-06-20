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
    /**
     * Create a new notification instance.
     */
    public function __construct($status, $applicationId)
    {
        $this->status = $status;
        $this->applicationId = $applicationId;
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
        return (new MailMessage)
            ->subject('Hostel Application Status Updated')
            ->greeting('Hi ' . $notifiable->username . ',')
            ->line('Your hostel application status has been updated.')
            ->line('**Status:** ' . ucfirst($this->status))
            ->line('Thank you for using our Hostel Management System!');
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
            'message' => 'Your hostel application status has been updated to ' . ucfirst($this->status),
            'url' => route('mainresidentapplication'),
        ];
    }
}
