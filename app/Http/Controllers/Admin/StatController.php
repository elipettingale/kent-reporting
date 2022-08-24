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

        $reports = Report::query()
            ->where('user_id', $user->id)
            ->orderBy('financial_year', 'desc')
            ->get();

        $years = [];

        foreach ($reports as $report) {
            $years[$report->financial_year] = [
                'status' => $report->status(),
                'stats' => [
                    'Total Assets' => '£1000'
                ]
            ];

            // todo: stats can be dependant on the version, pulled from a config here in php (no need for the js to calculate them all)
        }

        return [
            'success' => true,
            'id' => $user->id,
            'years' => $years
        ];
    }
}
