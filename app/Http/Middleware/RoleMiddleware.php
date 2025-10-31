<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requiredRoles = func_get_args();
        // args: ($request, $next, 'admin', 'user', ...)
        array_shift($requiredRoles); // remove $request
        array_shift($requiredRoles); // remove $next

        if (! $request->user()) {
            abort(403);
        }

        if (empty($requiredRoles)) {
            return $next($request);
        }

        if (! in_array($request->user()->role, $requiredRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
