<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ComplaintFeedbackUpdated extends Notification
{
    use Queueable;

    protected $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct($complaint)
    {
        $this->complaint = $complaint;
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
        Log::info('toMail triggered for user: ' . $notifiable->email);
        return (new MailMessage)
                    ->subject('Complaint Feedback Updated')
                    ->greeting('Hi ' . $notifiable->username . ',')
                    ->line('There is a new update on your complaint.')
                    ->line('You can view the latest feedback now.')
                    // ->action('View Complaint Update', route('viewcomplaint', ['id' => $this->complaint->id]))
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your complaint has received new feedback.',
            'complaint_id' => $this->complaint->id,
            'url' => route('viewcomplaint', ['id' => $this->complaint->id]),
        ];
    }
}
