<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard')->with('info', 'You are already logged in!');
        }

        return $next($request);
    }
}