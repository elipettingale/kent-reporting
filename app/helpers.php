<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

function is_admin(): bool {
    return Auth::user()->is_admin;
}

function record_log($key, $replace)
{
    Log::create([
        'key' => "log.$key",
        'replace' => $replace
    ]);
}
