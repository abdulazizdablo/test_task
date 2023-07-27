<?php

use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\Users\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/show', [UserController::class, 'show']);
Route::get('/users-products', [UsersController::class])->name('users.products');

Route::middleware('is_admin')->group(function () {


    Route::post('/assign-product', [ProductController::class, 'assignProduct'])->name('products.assign-user');
    Route::resource('/users', [UsersController::class]);
    Route::resource('/products', [ProductController::class]);
});
