<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Add routes that should bypass CSRF check for development
    ];

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // For development only - skip CSRF check
        if (env('APP_ENV') === 'local') {
            return $next($request);
        }

        // For production, use parent class
        return parent::handle($request, $next);
    }
}
