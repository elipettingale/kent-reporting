<?php

namespace App\Services;

use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportReminderNotification;
use App\Repositories\ReportRepository;

class ReminderService
{
    private $messageBefore;
    private $messageAfter;

    public function __construct($messageBefore, $messageAfter)
    {
        $this->messageBefore = $messageBefore;
        $this->messageAfter = $messageAfter;
    }

    public function remind(User $user, $financialYear)
    {
        $status = financialYearToSeason($financialYear) . ' Season: ';

        $reportExists = Report::query()
            ->where('user_id', $user->id)
            ->where('financial_year', $financialYear)
            ->exists();

        if ($reportExists) {
            $status .= 'Started, Not Complete';
        } else {
            $status .= 'Not Started';
        }

        $user->notify(
            new ReportReminderNotification($this->messageBefore, $this->messageAfter, $status)
        );

        return true;
    }
}
