<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Serviecs\CodeGeneratorService;
use CodeGeneratorService as GlobalCodeGeneratorService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthinticationController extends Controller
{

  public function __construct()
  {

    // $this->middleware('registration_type');


  }

  public function register(RegistrationRequest $request)



  {









    /* if (!$request->filled('phone_number')) {

      $user = User::create([

        //array_merge($request->except('password'),
         //['password' => Hash::make($request->password)]),

         //$request->all()


        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
         'email' => $request->email,
        'password' => Hash::make($request->password),




      ]);
      event(new UserRegistered($user));

  
    } else


      $user = User::create([

        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        //'phone_number' => $request->phone_number,
        'password' => Hash::make($request->password),
        //'access_token' => Str::random(60)




      ]);

/*

$user = User::create([


  'first_name' => $request->first_name,
  'last_name' => $request->last_name,
  'email' => $request->email,
  //'phone_number' => $request->phone_number,
  'password' => Hash::make($request->password),
  //'access_token' => Str::random(60)
]);

   
event(new UserRegistered($user));

    $verfication_code =  mt_rand(1000, 9999);


*/

    /*User::create([$request->except('password')->
merge(['password' => Hash::make($request->password)])


]);*/



    //dd(  array_merge(
    //$request->all(),
    // ['password' => Hash::make($request->password)]
    //));






    $user = User::create(


      array_merge(
        $request->validated(),
        ['password' => Hash::make($request->password)]
      )
    );


    if (!$user->phone_number) {
      //event(new UserRegistered($user));
      // $code =  mt_rand(1000, 9999);


      /* Mail::raw("Hi, welcome user! Please confirm this code $code ", function ($message) {
        $message->to('abooddablo@gmail.com')
          ->subject("ggll");
      });*/

      $user->sendEmailVerificationNotification();

      //    $user->update();




      return response()->json([
        'message' => "Verfiaction Code has been sent to your email inbox please confirm it"


      ]);


      //return redirect()->action('Api\AuthinticationController@confirmCode');

      /*if($code->checkConfirmedCode($request->code)){


  
}*/
    }

    //  if($request->has('code') &&  $request->code === $code_service->verfication_code){


    Auth::login($user);
    return response()->json([
      'success' => true,
      'message' => 'You have been succefully registered',
      'headers' => [

        'Accept' => 'application/json',
      ]

    ]);
  }









  public function confirmCode(Request $request)
  {
    $code = $request->code;

    $user = User::where('activation_code', $code)->first();



    /*if (is_null($user)) {


      return response()->json([

        'message' => 'The activation code is not Correct'

      ], 403);
    } else {



      $user->update(['is_verified' => true]);
      return response()->json([

        'message' => 'Regestraion Process is completed'

      ], 201);
    }

*/
    if ($user) {


      $user->markEmailAsVerified();
      return response()->json([
        'message' => 'Account activated',
      ]);
    } else {
      return response()->json([
        'message' => 'Invalid verification code',
      ], 401);
    }
  }




  public function login(LoginRequest $request)
  {
    $credentials = $request->validated();


    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Unauthorized',
      ], 401);
    } else {

      return response()->json([
        'message' => 'You have been logged in succefuly',
      ]);
    }
  }




  public function updatePassword(Request $request)
  {


    
    # Validation
    $request->validate([
      'email' => 'required',
      'old_password' => 'required',
      'new_password' => 'required|confirmed',
    ]);

    $user =  User::where('email',$request->email)->first();

    Auth::login($user);

//$user = User::where(Hash::check($request->old_password))
    #Match The Old Password
    if (!Hash::check($request->old_password, Auth::user()->password)) {
      return response()->json([
        'message' => 'Incorrect Confirmed Password Please check the entered password',
      ]);
    }


    #Update the new Password
    User::whereId(Auth::user()->id)->update([
      'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
      'message' => 'Password changed successfully!',
    ]);

  }


  public function forgotPassword(){
$user = User




  }
}
