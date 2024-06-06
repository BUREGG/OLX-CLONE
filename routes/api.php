<?php

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

//TODO route groupa z middleware auth:sanctum i w tym caly routing rest api

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index'])->name('api.products');
Route::get('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show'])->name('api.show.product');
Route::get('lists/products', [\App\Http\Controllers\Api\ProductController::class, 'list'])->name('api.list.products');
Route::get('users', [\App\Http\Controllers\Api\UserController::class, 'index'])->name('api.user.product');
Route::post('users', [\App\Http\Controllers\Api\UserController::class, 'store'])->name('api.create.user');
Route::put('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum')->name('api.update.product'); 
Route::delete('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'destroy'])->middleware('auth:sanctum')->name('api.delete.product');
Route::post('login',[\App\Http\Controllers\Api\AuthController::class, 'login'] );
Route::get('myproducts', [\App\Http\Controllers\Api\ProductController::class, 'myProducts'])->middleware('auth:sanctum')->name('api.my.products');
Route::post('createproduct', [\App\Http\Controllers\Api\ProductController::class, 'store'])->middleware('auth:sanctum')->name('api.create.product');
