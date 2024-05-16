<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllproductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GeoCodeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PermissionController;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware("auth")->group(function () {
    Route::view('/chat', "chat")->name("chat");
    Route::view('/favorite', "favorite")->name("favorite");
    Route::view('/myaccount', "myproducts")->name("myaccount");
    Route::view('/addproduct', "addproduct")->name("addproduct");
    Route::get('/myaccount', [ProductController::class, "myproducts"])->name("index");
    Route::post('/addproduct', [ProductController::class, "store"])->name("addproduct");
    Route::get('/favorite', [ProductController::class, "myfavorite"])->name("myfavorite");
    Route::delete('/delete/{product}',[ProductController::class, "destroy"])->name("product.delete");
    Route::get('/editproduct/{id}',[ProductController::class, "edit"])->name("product.edit");
    Route::put('/updateproduct/{id}',[ProductController::class, "update"])->name("product.update");
    Route::put('/refresh/{id}',[ProductController::class, "refresh"])->name("product.refresh");



});
Route::get('/', [CategoryController::class, 'getCategory'])->name("homepage");
Route::get('/product', [ProductController::class, 'DisplayAllProduct'])->name('product.display');
Route::get('/productdetails/{id}', [ProductController::class, 'productDetails'])->name('productdetails');
Route::get('category/{id}', [ProductController::class, 'category'])->name('category');
Route::get('category/{id}/filtr', [ProductController::class, 'filtrCategory'])->name('filtrcategory');
Route::get('fiteredproducts', [ProductController::class, 'filtr'])->name('filtr');
Route::post('/addfavorite/{id}', [ProductController::class, "favorite"])->name("addfavorite");
Route::post('/deletefavorite/{id}', [ProductController::class, "deletefavorite"])->name("deletefavorite");
Route::get('api/products', [\App\Http\Controllers\Api\ProductController::class, 'index']); 
Route::get('api/products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show']); 







Route::group(['middleware' => ['role:super-admin|admin']], function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    Route::resource('users', App\Http\Controllers\UserController::class);
});

Route::get('login', [AuthController::class, "login"])->name('login');
Route::post('login', [AuthController::class, "loginPost"])->name('login.post');
Route::get('register', [AuthController::class, "register"])->name('register');
Route::post('register', [AuthController::class, "registerPost"])->name('register.post');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout',  [AuthController::class, "logout"])->name('logout');
});
Route::get('/auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.auth');
Route::get('/auth/callback', [GoogleAuthController::class, 'callback'])->name('google.back');

Route::get('/test', [ProductController::class, 'test']);


Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost'])->name('password.post');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('password.resetpost');
