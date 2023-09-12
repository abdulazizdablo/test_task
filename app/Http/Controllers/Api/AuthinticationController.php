<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ActivationCodeRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdatePasswordRequest;
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

      $request->validated() +
        ['password' => Hash::make($request->password)]

    );


    if (!$user->phone_number) {

      $user->sendEmailVerificationNotification();

      return response()->json([
        'success' => true,
        'message' => "Verfiaction Code has been sent to your email inbox please confirm it",
        'data' => route('/verify-code')

      ]);
    }





    return response()->json([

      'success' => true,
      'message' => 'You have been successfully registered',

      'headers' => [

        'Accept' => 'application/json',
      ]

    ]);
  }




  public function confirmCode(ActivationCodeRequest $request)
  {
    $activation_code = $request->user()->code;

    try {
      $user = User::where('activation_code', $activation_code)->first();

      if ($user) {
        $user->markEmailAsVerified();
        return response()->json([

          'success' => true,
          'message' => 'Account activated',
          'data' => route('/index'),

          'headers' => [
            'Accept' => 'application/json',
          ]
        ]);
      } else {
        throw new \Exception('Invalid verification code');
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'headers' => [
          'Accept' => 'application/json',
        ]
      ], 401);
    }
  }




  public function login(LoginRequest $request)
  {
    $credentials = $request->validated();

    if (Auth::attempt($credentials)) {
      $token = Auth::user()->createToken('Personal Access Token')->accessToken;
      return response()->json([
        'success' => true,
        'message' => 'You have been logged in successfully',
        'token' => $token
      ]);
    } else {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
  }



  public function updatePassword(UpdatePasswordRequest $request)
  {



    # Validation

    $user = $request->user();




    if (!Hash::check($request->old_password, $user->password)) {
      return response()->json([
        'success' => false,
        'message' => 'Incorrect Confirmed Password Please check the entered password',
        'headers' => [

          'Accept' => 'application/json',
        ]

      ]);
    } else {

      User::whereId($user->id)->update([
        'password' => Hash::make($request->new_password)
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Password changed successfully!',
        'headers' => [

          'Accept' => 'application/json',
        ]


      ]);
    }
  }


  public function forgotPassword(ForgetPasswordRequest $request)
  {

    $status = Password::sendResetLink(
      $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
      return response()->json([
        'success' => true,
        'message' => 'Verfication Link has been sent to your email',
        'headers' => [
          'Accept' => 'application/json',
        ]
      ]);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'An error occurred. Please try again later.',
        'headers' => [
          'Accept' => 'application/json',
        ]
      ], 400);
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
      'success' => true,
      'message' => 'Your Password has been changed successfully',
      'headers' => [

        'Accept' => 'application/json',
      ]

    ]);
  }
}
