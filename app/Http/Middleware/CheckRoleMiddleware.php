<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

  

  
    
class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        // Allow access to login page or if user is not logged in
        if (!$request->is('login') && !Auth::check()) {
            return redirect()->route('login');
        }

        // Check for required roles
        if (Auth::check() && !auth()->user()->hasAnyRole(explode('|', $roles))) {
            return redirect()->route('login'); // Redirect to login if roles do not match
        }

        return $next($request);
    }
}

