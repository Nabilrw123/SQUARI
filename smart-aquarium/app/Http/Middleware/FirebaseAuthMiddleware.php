<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Allow only users authenticated via Firebase (e.g., role 'vip_user').
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'vip_user') {
            return redirect()->route('login')->with('error', 'Access denied. Please login with Firebase account.');
        }

        return $next($request);
    }
}
