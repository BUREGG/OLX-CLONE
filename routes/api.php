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

Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index']); // product_list
Route::get('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show']); 
Route::get('lists/products', [\App\Http\Controllers\Api\ProductController::class, 'list']) ;
Route::get('users', [\App\Http\Controllers\Api\UserController::class, 'index']);
Route::post('users', [\App\Http\Controllers\Api\UserController::class, 'store']);
Route::put('product/{product}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum'); 
Route::delete('product/{product}', [\App\Http\Controllers\Api\ProductController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('login',[\App\Http\Controllers\Api\AuthController::class, 'login'] );
Route::get('myproducts', [\App\Http\Controllers\Api\ProductController::class, 'myProducts'])->middleware('auth:sanctum');
Route::post('createproduct', [\App\Http\Controllers\Api\ProductController::class, 'store'])->middleware('auth:sanctum');
