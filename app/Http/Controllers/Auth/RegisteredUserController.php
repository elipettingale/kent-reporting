<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LogEvent;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'club' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // todo: custom club validation (not already registered, with message)
        // todo: if club already registered, log special event

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'club' => $request->club,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        record_log(LogEvent::REGISTERED, [
            'user' => $user->name,
            'club' => $user->club
        ]);

        Auth::login($user);

        // todo: should be the current year (but they might register early BEFORE new year)
        $now = Carbon::createFromDate(2023, 1, 1);

        Report::create([
            'user_id' => $user->id,
            'financial_year' => $now->year,
            'form_version' => config('form.version'),
            'due_at' => $now->endOfYear()
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
