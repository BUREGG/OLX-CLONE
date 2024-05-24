<?php

use App\Events\Message;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllproductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\GeoCodeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PusherController;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

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
    Route::get('/myaccount', [ProductController::class, "myProducts"])->name("index");
    Route::post('/addproduct', [ProductController::class, "store"])->name("addproduct");
    Route::get('/favorite', [ProductController::class, "myFavorite"])->name("myfavorite");
    Route::delete('/delete/{product}',[ProductController::class, "destroy"])->name("product.delete");
    Route::get('/editproduct/{product}',[ProductController::class, "edit"])->name("product.edit");
    Route::put('/updateproduct/{product}',[ProductController::class, "update"])->name("product.update");
    Route::put('/refresh/{product}',[ProductController::class, "refresh"])->name("product.refresh");
    Route::put('status/{product}', [ProductController::class, "status"])->name('product.status');
    Route::get('editprofile', [App\Http\Controllers\UserController::class, "editProfile"])->name('editprofile');
    Route::put('editprofilepost', [App\Http\Controllers\UserController::class, "editProfilePost"])->name('editprofile.post');
    Route::get('chart', [ChartController::class, "chart"])->name('chart');

Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
Route::post('/conversations', [ConversationController::class, 'create'])->name('conversations.create');
Route::get('/conversations/start/{id}', [ConversationController::class, 'store'])->name('conversations.start');

});
Route::get('/', [CategoryController::class, 'getCategory'])->name("homepage");
Route::get('/product', [ProductController::class, 'displayAllProduct'])->name('product.display');
Route::get('/productdetails/{id}', [ProductController::class, 'productDetails'])->name('productdetails');
Route::get('category/{id}', [ProductController::class, 'category'])->name('category');
Route::get('category/{id}/filtr', [ProductController::class, 'filtrCategory'])->name('filtrcategory');
Route::get('fiteredproducts', [ProductController::class, 'filtr'])->name('filtr');
Route::post('/addfavorite/{id}', [ProductController::class, "favorite"])->name("addfavorite");
Route::post('/deletefavorite/{id}', [ProductController::class, "deleteFavorite"])->name("deletefavorite");
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/filteredsearch', [ProductController::class, 'searchFiltr'])->name('products.searchfiltr');



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
