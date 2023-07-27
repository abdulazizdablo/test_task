<?php

use App\Http\Controllers\Api\AuthinticationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('bearer_token')->group(function () {
    Route::post('register', [AuthinticationController::class, 'register']);
    Route::post('login', [AuthinticationController::class, 'login']);
    Route::post('change-password', [AuthinticationController::class, 'updatePassword']);
    Route::get('show/{user}', [UserController::class, 'show']);
    Route::put('update/{user}', [UserController::class, 'update']);

});
