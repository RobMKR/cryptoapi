<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @param null $version
     * @return mixed
     */
    public function handle($request, Closure $next, $version = null)
    {
        // The $version parameter is our api version,
        // We can do anything what we want based on version
        // For example attach headers based on version

        return $next($request);
    }
}
