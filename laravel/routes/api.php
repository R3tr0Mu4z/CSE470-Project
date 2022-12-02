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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('search', [App\Http\Controllers\RestaurantsList::class, 'search']);
Route::get('get-restaurant/{id}', [App\Http\Controllers\Restaurant::class, 'getForAPI']);
Route::get('get-food/{id}', [App\Http\Controllers\FoodItem::class, 'getFoodForAPI']);
Route::get('get-orders/', [App\Http\Controllers\OrdersList::class, 'getCustomerOrders']);
Route::get('get-order/{id}', [App\Http\Controllers\Order::class, 'getCustomerOrder']);
Route::post('place-order', [App\Http\Controllers\Order::class, 'placeOrder']);

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'Customer@login');
    Route::post('register', 'Customer@register');
    Route::post('logout', 'Customer@logout');
    Route::post('refresh', 'Customer@refresh');
    Route::post('me', 'Customer@me');
    Route::post('update', 'Customer@updateAPI');
});