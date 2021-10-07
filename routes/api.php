<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthorController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [UserController::class, 'login']);
Route::post('userLogin', [UserController::class, 'userLogin']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
Route::group(['prefix'=>'/'],function(){

    Route::resource('users',UserController::class);
    Route::resource('products',ProductController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('authors',AuthorController::class);
    Route::resource('orders',OrderController::class);

    // option
    // Route::get('customers',[UserController::class,'customers']);

    // search
    Route::get('products-search',[ProductController::class, 'search']);
    Route::get('categories-search',[CategoryController::class, 'search']);
    Route::get('authors-search',[AuthorController::class, 'search']);
    Route::get('orders-search',[OrderController::class, 'search']);
    // Route::get('users-search',[CustomersController::class, 'search']);

});
