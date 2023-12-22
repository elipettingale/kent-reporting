<?php

use App\Enums\LogEvent;
use App\Mail\TestEmail;
use App\Models\Report;
use App\Models\ReportReminder;
use App\Models\User;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use ZxcvbnPhp\Zxcvbn;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('password-strength', function (Request $request) {
    $value = $request->get('password');

    $analysis = (new Zxcvbn())->passwordStrength($value);

    return [
        'success' => true,
        'score' => $analysis['score'] + 1
    ];
});

Route::get('club-registered', function (Request $request) {
    $club = $request->input('club');

    $user = User::query()
        ->where('club', $club)
        ->first();

    if (!$user) {
        return [
            'exists' => false
        ];
    }

    record_log(LogEvent::TRIED_TO_REREGISTER, [
        'club' => $club
    ]);

    return [
        'exists' => true,
        'hint' => substr($user->email, 0, 8)
    ];
});

Route::post('send-reminder', function (Request $request) {
    $user = User::findOrFail($request->input('user_id'));
    $financialYear = now()->subYear()->format('Y');

    $reminder = ReportReminder::create([
        'user_id' => $user->id,
        'financial_year' => $financialYear
    ]);

    $reminder->send();

    return [
        'success' => true,
        'sent_at' => now()->format('d/m/Y')
    ];
});

Route::post('send-reminders', function (Request $request) {
    $reminderService = new ReminderService(
        $request->input('message_before'),
        $request->input('message_after')
    );

    $forSeason = $request->input('for_season');

    $reminders = [];

    foreach (config('clubs') as $club) {
        $user = User::query()
            ->where('club', $club)
            ->first();

        if (!$user) {
            continue;
        }

        $completed = Report::query()
            ->where('user_id', $user->id)
            ->where('financial_year', $forSeason)
            ->whereNotNull('submitted_at')
            ->exists();

        if ($completed) {
            continue;
        }

        $reminderService->remind($user, $forSeason);
        $reminders[] = $club;
    }

    return [
        'success' => true,
        'reminders_sent' => count($reminders)
    ];
});
