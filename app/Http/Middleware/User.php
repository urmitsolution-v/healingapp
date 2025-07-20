<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check()) {
    $user = Auth::user();

    if ($user->role !== 'user') {
        Auth::logout();
        return redirect('/sign-in')->with('error', 'Access restricted. Only users are allowed.');
    }

    if ($user->declearation !== 'Y') {
        Auth::logout();
        return redirect('/sign-in')->with('error', 'Please accept the declaration to continue.');
    }

    if ($user->is_block == 'Y' && $user->status !== 'approved') {
        Auth::logout();
    return redirect('/sign-in')->with('error', 'Your account is inactive. Please contact support.');
    }

    // All checks passed
    return $next($request);
}

// Not logged in
return redirect('/sign-in')->with('error', 'Please log in to continue.');
    }
}