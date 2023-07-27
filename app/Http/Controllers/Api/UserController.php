<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserApiResource;
use App\Http\Requests\RegistrationRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //$user = User::find($id);

        return response()->json(
            new UserApiResource($user)

        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,

        ]);

        return response()->json(
            [

                'message' => 'You have been updated your information successfully'
            ]

        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
