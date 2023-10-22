<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportReminder;
use App\Models\User;
use App\Repositories\ReportRepository;
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

            $reports = [];

            if ($user) {
                // between start year and this year?

                $reports[2022] = ReportRepository::getByUserAndYear($user, 2022);
                $reports[2023] = ReportRepository::getByUserAndYear($user, 2023);
            }

            $clubs[] = (object) [
                'name' => $club,
                'user_id' => $user?->id ?? null,
                'user_name' => $user?->name ?? null,
                'status' => $user ? 'registered' : 'not_registered',
                'email' => $user->email ?? null,
                'notes' => $user->notes ?? null,
                'reports' => (object) $reports
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
