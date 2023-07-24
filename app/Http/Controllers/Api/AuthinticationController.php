<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthinticationController extends Controller
{
  public function register(RegistrationRequest $request)



  {

    if (!$request->has('phone_number')) {

      $user = User::create([

        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        // 'phone_number' =>$request->phone_number,
        'password' => Hash::make($request->password)




      ]);
      event(new Registered($user));
    } else


      $user = User::create([

        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'password' => Hash::make($request->password)




      ]);




    $verfication_code =  mt_rand(1000, 9999);



    $user->access_token = Str::random(30);
    $user->save;
    return response()->json([
      'success' => true,
      'message' => 'You have been succefully registered'


    ], 200);
  }


  public function create(array $data)
  {
  }


  public function login(LoginRequest $request)
  {
$credentials = $request->validated();


   if( Auth::attempt($credentials)){

Auth::login();


   }
else{

  abort('Invailed credintals Please make sure of the information provided',403);
}


  
  }
}
