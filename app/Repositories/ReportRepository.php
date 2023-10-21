<?php

namespace App\Repositories;

use App\Models\Report;
use App\Models\User;

class ReportRepository
{
    public static function getByUserAndYear(User $user, $financialYear)
    {
        return Report::query()
            ->where('user_id', $user->id)
            ->where('financial_year', $financialYear)
            ->first();
    }
}
