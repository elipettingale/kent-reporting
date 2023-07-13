<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportReminder;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $clubs = [];

        foreach (config('clubs') as $club) {
            $user = User::query()
                ->where('club', $club)
                ->first();

            if ($request->input('status') === 'registered') {
                if (!$user) {
                    continue;
                }
            }

            if ($request->input('status') === 'not_registered') {
                if ($user) {
                    continue;
                }
            }

            $lastSeasonReport = null;
            $lastSeasonReminder = null;

            if ($user) {
                $lastSeasonReport = Report::query()
                    ->where('user_id', $user->id)
                    ->where('financial_year', now()->subYear()->format('Y'))
                    ->whereNotNull('submitted_at')
                    ->first();

                $lastSeasonReminder = ReportReminder::query()
                    ->where('user_id', $user->id)
                    ->where('financial_year', now()->subYear()->format('Y'))
                    ->whereNotNull('sent_at')
                    ->orderByDesc('created_at')
                    ->first();
            }

            $clubs[] = (object) [
                'name' => $club,
                'user_id' => $user?->id ?? null,
                'status' => $user ? 'registered' : 'not_registered',
                'email' => $user->email ?? null,
                'notes' => $user->notes ?? null,
                'last_season' => (object) [
                    'report' => $lastSeasonReport,
                    'reminder' => $lastSeasonReminder
                ]
            ];
        }

        return view('admin.clubs', [
            'clubs' => $clubs
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user->fill($request->all());
        $user->save();

        return back();
    }
}
