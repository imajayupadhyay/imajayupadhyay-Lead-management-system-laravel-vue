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
        // Check if counselor is authenticated using counselor guard
        if (!auth()->guard('counselor')->check()) {
            return redirect()->route('login')->with('error', 'Access denied. Counselor privileges required.');
        }

        // Check if counselor account is active
        if (!auth()->guard('counselor')->user()->is_active) {
            auth()->guard('counselor')->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        return $next($request);
    }
}