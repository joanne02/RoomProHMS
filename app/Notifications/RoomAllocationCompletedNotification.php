<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoomAllocationCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $sessionId;
    public $chunkNumber;

    public function __construct($message, $sessionId, $chunkNumber)
    {
        $this->onQueue('room-allocation');
        $this->message = $message;
        $this->sessionId = $sessionId;
        $this->chunkNumber = $chunkNumber;
    }

    public function via($notifiable)
    {
        return ['database']; // use 'mail' if you also want email
    }

    public function toDatabase($notifiable)
    {

        return [
            'message' => $this->message,
            'url' => route('roomallocationbatch', [
                'session_id' => $this->sessionId,
                'chunk_index' => $this->chunkNumber,
            ]),
        ];
    }
}
