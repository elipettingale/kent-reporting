<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;

class DashboardController extends Controller
{
    public function show()
    {
        if (!is_admin()) {
            return view('user.dashboard');
        }


        $logs = Log::query()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
       
        return view('admin.dashboard', [
            'logs' => $logs
        ]);
    }
}
