<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
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

            $lastYearReport = null;
            $thisYearReport = null;

            if ($user) {
                $lastYearReport = Report::query()
                    ->where('user_id', $user->id)
                    ->where('financial_year', now()->subYear()->format('Y'))
                    ->whereNotNull('submitted_at')
                    ->first();

                $thisYearReport = Report::query()
                    ->where('user_id', $user->id)
                    ->where('financial_year', now()->format('Y'))
                    ->whereNotNull('submitted_at')
                    ->first();
            }

            $clubs[] = (object) [
                'name' => $club,
                'user_id' => $user?->id ?? null,
                'status' => $user ? 'registered' : 'not_registered',
                'email' => $user->email ?? null,
                'last_year_report_submitted_at' => $lastYearReport?->submitted_at?->format('d/m/Y') ?? null,
                'this_year_report_submitted_at' => $thisYearReport?->submitted_at?->format('d/m/Y') ?? null,
            ];
        }

        return view('admin.clubs', [
            'clubs' => $clubs
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user->email = $request->input('email');
        $user->save();

        return back();
    }
}
