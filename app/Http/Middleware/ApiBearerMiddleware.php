<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiBearerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    
        $bearerToken = $request->bearerToken();

        if ($bearerToken === null) {
            return response()->json(['error' => 'Bearer Token not found.'], 401);
        }

        try {
            Auth::authenticate($bearerToken);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid Bearer Token.'], 401);
        }

        return $next($request);

    }
}
