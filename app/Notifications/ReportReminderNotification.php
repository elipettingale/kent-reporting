<?php

namespace App\Notifications;

use App\Models\ReportReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportReminderNotification extends Notification
{
    private $messageBefore;
    private $messageAfter;
    private $status;

    public function __construct($messageBefore, $messageAfter, $status)
    {
        $this->messageBefore = $messageBefore;
        $this->messageAfter = $messageAfter;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.report-reminder', [
            'user' => $notifiable,
            'messageBefore' => $this->messageBefore,
            'messageAfter' => $this->messageAfter,
            'status' => $this->status
        ]);
    }
}
