<?php

use App\Models\User;
use Illuminate\Http\Request;
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

    return [
        'exists' => true,
        'hint' => substr($user->email, 0, 8)
    ];
});
