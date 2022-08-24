<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        if (is_admin()) {
            return view('admin.dashboard');
        } else {
            return view('user.dashboard');
        }
        
    }
}
