<?php

use Illuminate\Support\Facades\Auth;

function is_admin(): bool {
    return Auth::user()->is_admin;
}
