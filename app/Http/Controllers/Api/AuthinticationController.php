<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class AuthinticationController extends Controller
{


  public function register(RegistrationRequest $request)



  {



    $user = User::create(


      array_merge(
        $request->validated(),
        ['password' => Hash::make($request->password)]
      )
    );


    if (!$user->phone_number) {


      $user->sendEmailVerificationNotification();

      return response()->json([
        'message' => "Verfiaction Code has been sent to your email inbox please confirm it"


      ]);
    }




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


    if ($user) {


      $user->markEmailAsVerified();
      return response()->json([
        'message' => 'Account activated',
        'headers' => [

          'Accept' => 'application/json',
        ]

      ]);
    } else {
      return response()->json([
        'message' => 'Invalid verification code',
        'headers' => [

          'Accept' => 'application/json',
        ]

      ], 401);
    }
  }




  public function login(LoginRequest $request)
  {
    $credentials = $request->validated();


    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Unauthorized',
        'headers' => [

          'Accept' => 'application/json',
        ]

      ], 401);
    } else {

      return response()->json([
        'message' => 'You have been logged in succefuly',
        'headers' => [

          'Accept' => 'application/json',
        ]

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

    $user =  User::where('email', $request->email)->first();

    Auth::login($user);

    //$user = User::where(Hash::check($request->old_password))
    #Match The Old Password
    if (!Hash::check($request->old_password, Auth::user()->password)) {
      return response()->json([
        'message' => 'Incorrect Confirmed Password Please check the entered password',
        'headers' => [

          'Accept' => 'application/json',
        ]

      ]);
    }


    #Update the new Password
    User::whereId(Auth::user()->id)->update([
      'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
      'message' => 'Password changed successfully!',
      'headers' => [

        'Accept' => 'application/json',
      ]

    ]);
  }


  public function forgotPassword(Request $request)
  {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
      $request->only('email')
    );
    //  $status === Password::RESET_LINK_SENT

    if ($status === Password::RESET_LINK_SENT) {

      return response()->json([
        'message' => 'Verfication Link has been sent to your email',
        'headers' => [

          'Accept' => 'application/json',
        ]
      ]);
    }
  }


  public function resetPassword(Request $request)
  {

    $request->validate([

      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation',),
      function (User $user, string $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ]);

        $user->save();

        event(new PasswordReset($user));
      }
    );


    return response()->json([
      'message' => 'Your Password has been changed successfully',
      'headers' => [

        'Accept' => 'application/json',
      ]

    ]);
  }
}
