<?php

namespace App\Services;

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

    public function remind(User $user)
    {
        $reports = [
            '21/22' => ReportRepository::getByUserAndYear($user, 2022),
            '22/23' => ReportRepository::getByUserAndYear($user, 2023)
        ];

        $breakdown = [];

        foreach ($reports as $year => $report) {
            if (!$report) {
                $breakdown[$year] = 'Not Started';
            }

            if ($report && !$report->isComplete()) {
                $breakdown[$year] = 'Started, Not Complete';
            }
        }

        if (count($breakdown) === 0) {
            return false;
        }

        $user->notify(
            new ReportReminderNotification($this->messageBefore, $this->messageAfter, $breakdown)
        );

        return true;
    }
}
