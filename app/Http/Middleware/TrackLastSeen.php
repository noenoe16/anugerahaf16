<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            // Update every 60 seconds at most
            $last = $request->user()->last_seen_at;
            if ($last === null || now()->diffInSeconds($last) > 60) {
                $request->user()->forceFill(['last_seen_at' => now()])->save();
            }
        }

        return $next($request);
    }
}
