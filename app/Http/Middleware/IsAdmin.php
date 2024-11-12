<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has admin privileges
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Redirect or abort if not an admin
        return redirect('/')->with('error', 'Access denied');
    }
}
