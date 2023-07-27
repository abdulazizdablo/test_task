<?php

namespace App\Http\Middleware;

use App\Http\Requests\RegistrationRequest;
use Closure;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

      
        if($request->filled('phone_number')){

        User::create([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            //'access_token' => Str::random(60)
        ]);


        }
        return $next($request);
    }
}
