<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Check if the user is logged in and has the 'admin' role
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Continue with the request if the user is an admin
            return $next($request);
        }

        // If the user is not an admin, deny access
        return redirect('/')->with('error', 'Access denied: Admin role not detected');
    }
}
