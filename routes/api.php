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

Route::apiResource('menu', 'Menu\MenuController')->only(['index', 'show']);
Route::apiResource('cart', 'ShoppingCart\CartController')->only(['show', 'update', 'destroy']);
Route::apiResource('order_item', 'OrderItem\OrderItemController')->only(['store','update', 'destroy']);
Route::post('auth/login', ['uses' => 'AuthController@login', 'as' => 'api_login']);
Route::post('auth/register', ['uses' => 'AuthController@register', 'as' => 'api_register']);
//Route::get('umbrella_{id}', 'Umbrella\UmbrellaController@umbrellaById')->name('specific_umbrella');

