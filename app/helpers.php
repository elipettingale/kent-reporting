<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

function is_admin(): bool
{
    return Auth::user()->is_admin;
}

function record_log($key, $replace)
{
    Log::create([
        'key' => "log.$key",
        'replace' => $replace
    ]);
}

function financialYearToSeason($financialYear)
{
    $secondYear = (int) $financialYear;
    $firstYear = $secondYear - 1;

    return substr($firstYear, 2) . '/' . substr($secondYear, 2);
}
