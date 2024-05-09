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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index']); 
Route::get('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show']); 
Route::get('lists/products', [\App\Http\Controllers\Api\ProductController::class, 'list']) ;
Route::get('users', [\App\Http\Controllers\Api\UserController::class, 'index']); 
Route::post('users', [\App\Http\Controllers\Api\UserController::class, 'store']); 
Route::put('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'update']); 
Route::delete('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']); 

Route::post('products', [\App\Http\Controllers\Api\ProductController::class, 'store']); 