<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiBearerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->bearerToken()) {

            return response()->json([
                'message' => 'Please Check the  provided Bearer Token'

            ], 403);
        }
        

        return $next($request);
    }
}
