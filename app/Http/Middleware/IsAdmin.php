<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!is_admin()) {
            abort(404);
        }

        return $next($request);
    }
}
