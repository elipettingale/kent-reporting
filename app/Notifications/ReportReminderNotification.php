<?php

namespace App\Notifications;

use App\Models\ReportReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportReminderNotification extends Notification
{
    private $reportReminder;

    public function __construct(ReportReminder $reportReminder)
    {
        $this->reportReminder = $reportReminder;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $season = substr((int) $this->reportReminder->financial_year - 1, 2) . '/' . substr($this->reportReminder->financial_year, 2);

        return (new MailMessage)
            ->line("This is a reminder that you have yet to submit your accounts for the {$season} season.")
            ->action('Log In', route('login'))
            ->line('Please do so at your earliest convinience.');
    }
}
