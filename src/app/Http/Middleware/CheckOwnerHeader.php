<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str; 

class CheckOwnerHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $owner = $request->header('X-Owner', null);

        if (!$owner || !Str::isUuid($owner)) {
            return response()->json([
                'error' => 'Invalid or missing X-Owner header'
            ], 400);
        }

        $request->merge(['owner' => $owner]);

        return $next($request);
    }
}
