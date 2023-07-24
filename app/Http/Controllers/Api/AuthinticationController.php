<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthinticationController extends Controller
{
    public function register(RegistrationRequest $request)
    {


      if($request->has('email')){


       $verfication_code =  mt_rand(1000,9999);
      }

  $user = User::create([

'first_name' => $request->first_name,
'last_name' => $request->last_name,
'email' => $request->email,
'password' => Hash::make($request->password)




  ]);


  return reponse()->json([



  ])


    }


    public function create(array $data)
    {
    }


    public function login(LoginRequest $request)
    {

      Auth::attempt($credentials);
    }
}
