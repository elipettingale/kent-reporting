<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function show()
    {
        return view('admin.stats');
    }

    public function getClub(Request $request)
    {
        $club = $request->input('club');

        $user = User::where('club', $club)->first();

        if (!$user) {
            return [
                'success' => false
            ];
        }

        return [
            'success' => true,
            'id' => $user->id
        ];
    }
}
