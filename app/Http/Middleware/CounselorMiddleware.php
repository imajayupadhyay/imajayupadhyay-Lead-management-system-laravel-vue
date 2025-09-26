<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CounselorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is a counselor
        if (!auth()->check() || auth()->user()->role !== 'counselor') {
            return redirect()->route('login')->with('error', 'Access denied. Counselor privileges required.');
        }

        // Check if counselor account is active
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        return $next($request);
    }
}