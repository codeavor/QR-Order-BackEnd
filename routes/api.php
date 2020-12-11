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
/** tha prepei na valo enan role px kitchen gia na diaxirizete tin kouzina */
Route::middleware('auth.role:customer,service')->apiResource('menu', 'Menu\MenuController')->only(['index', 'show']);
Route::middleware('auth.role:customer,service')->apiResource('cart', 'ShoppingCart\CartController')->only(['show', 'update', 'destroy']);
Route::middleware('auth.role:customer,service')->apiResource('order_item', 'OrderItem\OrderItemController')->only(['store','update', 'destroy']);
Route::middleware('auth.role:kitchen,service')->apiResource('orders', 'ShoppingCart\CartController')->only(['index']);
Route::post('auth/login', ['uses' => 'Auth\AuthController@login', 'as' => 'api_login']);
Route::post('auth/register', ['uses' => 'Auth\AuthController@register', 'as' => 'api_register']);
Route::post('auth/logout', ['uses' => 'Auth\AuthController@logout', 'as' => 'api_logout']);
Route::middleware('auth.role:service')->post('auth/refresh', ['uses' => 'Auth\AuthController@getToken', 'as' => 'api_refresh']);

