<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Check if the user has the 'admin' role
            if (Auth::user()->role == 'admin') {
                return $next($request);
            } else {
                return redirect('/')->with('error', 'Access denied: Admin role not detected');
            }
        }
    
        // If the user is not logged in, redirect to the login page
        return redirect('/login')->with('error', 'You must be logged in to access this page');
    }
    
}
