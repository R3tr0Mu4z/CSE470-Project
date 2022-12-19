<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/restaurant-manager', [App\Http\Controllers\RestaurantManager::class, 'index']);
Route::get('/restaurant-manager/sign-in', [App\Http\Controllers\RestaurantManager::class, 'view_signIn']);
Route::post('/restaurant-manager/post', [App\Http\Controllers\RestaurantManager::class, 'post']);
Route::get('/owned-restaurants', [App\Http\Controllers\RestaurantManager::class, 'viewOwnedRestaurant']);
Route::get('/owned-restaurants-orders', [App\Http\Controllers\OwnedRestaurantsOrders::class, 'listOrders']);
Route::get('/add-restaurant', [App\Http\Controllers\RestaurantManager::class, 'addRestaurant']);
Route::get('/delete-restaurant/{id}', [App\Http\Controllers\Restaurant::class, 'deleteRestaurant']);
Route::get('/owned-restaurants/add-food/{id}', [App\Http\Controllers\Restaurant::class, 'addFoodItem']);
Route::get('/delete-food/{id}', [App\Http\Controllers\FoodItem::class, 'deleteFood']);
Route::get('/owned-restaurants/view-restaurant/{id}', [App\Http\Controllers\OwnedRestaurants::class, 'viewRestaurant']);
Route::post('/add-restaurant/post', [App\Http\Controllers\Restaurant::class, 'createRestaurant']);
Route::post('/add-food/post', [App\Http\Controllers\FoodItem::class, 'insertFood']);
Route::get('/edit-food/{id}', [App\Http\Controllers\FoodItem::class, 'editFood']);
Route::get('/edit-restaurant/{id}', [App\Http\Controllers\Restaurant::class, 'editRestaurant']);
Route::post('/update-restaurant/', [App\Http\Controllers\Restaurant::class, 'updateRestaurant']);
Route::post('/update-food/', [App\Http\Controllers\FoodItem::class, 'updateFood']);
Route::post('/mark-delivered', [App\Http\Controllers\Order::class, 'markDelivered']);
Route::post('/mark-cancelled', [App\Http\Controllers\Order::class, 'markCancelled']);


Route::get('/admin-manager', [App\Http\Controllers\AdministrativeManager::class, 'index']);
Route::get('/admin-manager/sign-in', [App\Http\Controllers\AdministrativeManager::class, 'view_signIn']);
Route::post('/admin-manager/post', [App\Http\Controllers\AdministrativeManager::class, 'post']);
Route::get('/admin/customers', [App\Http\Controllers\AdministrativeManager::class, 'viewCustomers']);
Route::get('/admin/customers/view/{id}', [App\Http\Controllers\CustomersList::class, 'viewCustomer']);
Route::get('/admin/customers/edit/{id}', [App\Http\Controllers\Customer::class, 'editCustomer']);
Route::get('/admin/customers/delete/{id}', [App\Http\Controllers\Customer::class, 'deleteCustomer']);
Route::get('/admin/managers', [App\Http\Controllers\AdministrativeManager::class, 'viewManagers']);
Route::get('/admin/managers/view/{id}', [App\Http\Controllers\ManagersList::class, 'viewManager']);
Route::get('/admin/managers/edit/{id}', [App\Http\Controllers\Manager::class, 'editManager']);
Route::get('/admin/managers/delete/{id}', [App\Http\Controllers\Manager::class, 'deleteManager']);
Route::get('/admin/restaurants', [App\Http\Controllers\AdministrativeManager::class, 'viewRestaurants']);
Route::get('/admin/restaurants/view/{id}', [App\Http\Controllers\RestaurantsList::class, 'viewRestaurant']);
Route::get('/admin/restaurants/edit/{id}', [App\Http\Controllers\Restaurant::class, 'editRestaurant']);
Route::get('/admin/restaurants/delete/{id}', [App\Http\Controllers\Restaurant::class, 'deleteRestaurant']);
Route::get('/admin/orders', [App\Http\Controllers\AdministrativeManager::class, 'viewOrders']);
Route::get('/admin/orders/view/{id}', [App\Http\Controllers\OrdersList::class, 'viewOrder']);
Route::get('/admin/orders/delete/{id}', [App\Http\Controllers\Order::class, 'deleteOrder']);
Route::post('/update-customer/', [App\Http\Controllers\Customer::class, 'updateCustomer']);
Route::post('/update-manager/', [App\Http\Controllers\Manager::class, 'updateManager']);
Route::get('/manager/logout', [App\Http\Controllers\Manager::class, 'logout']);