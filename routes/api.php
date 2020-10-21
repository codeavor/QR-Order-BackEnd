<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.role:customer')->apiResource('menu', 'Menu\MenuController')->only(['index', 'show']);
Route::middleware('auth.role:customer')->apiResource('cart', 'ShoppingCart\CartController')->only(['show', 'update', 'destroy']);
Route::middleware('auth.role:customer')->apiResource('order_item', 'OrderItem\OrderItemController')->only(['store','update', 'destroy']);
Route::post('auth/login', ['uses' => 'AuthController@login', 'as' => 'api_login']);
Route::post('auth/register', ['uses' => 'AuthController@register', 'as' => 'api_register']);
Route::post('auth/logout', ['uses' => 'AuthController@logout', 'as' => 'api_logout']);
Route::middleware('auth.role:service')->post('auth/refresh', ['uses' => 'AuthController@getToken', 'as' => 'api_refresh']);

