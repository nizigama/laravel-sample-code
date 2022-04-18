<?php

use App\Http\Controllers\App\Authentication;
use App\Http\Controllers\App\Cart;
use App\Http\Controllers\App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("auth")->group(function () {

    Route::post("register", [Authentication::class, "register"]);
    Route::post("login", [Authentication::class, "signin"]);
    Route::get("logout", [Authentication::class, "logout"]);
});

Route::prefix("app")->group(function(){

    Route::get("products", [Products::class, "index"]);
    Route::post("cart/add", [Cart::class, "addToCart"]);
});
