<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LeaveRequestApprovedNotification extends Notification
{
    use Queueable;

    protected $leaveRequest;

    public function __construct($leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable)
    {
        return ['database']; // Stockage en base de données
    }

    public function toDatabase($notifiable)
    {
        return [
            'leave_request_id' => $this->leaveRequest->id,
            'message' => 'Votre demande de congé a été approuvée',
            'start_date' => $this->leaveRequest->start_date,
            'end_date' => $this->leaveRequest->end_date
        ];
    }
}
