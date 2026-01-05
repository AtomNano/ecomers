<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow both admin and owner roles to access admin routes
        // Owner is the highest role and should have all admin privileges
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'owner'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}
