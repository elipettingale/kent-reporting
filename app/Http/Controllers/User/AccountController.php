<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAccountRequest;

class AccountController extends Controller
{
    public function show()
    {
        return view('user.account', [
            'user' => auth()->user()
        ]);
    }

    public function update(UpdateAccountRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->all());
        $user->save();

        return redirect()->back();
    }
}
