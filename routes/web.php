<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

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
Route::middleware("auth")->group(function(){
    Route::view('/', "welcome")->name("home");
    Route::view('/chat', "chat")->name("chat");
    Route::view('/favorite', "favorite")->name("favorite");
    Route::view('/myaccount', "myaccount")->name("myaccount");


   

});
Route::group(['middleware' => ['role:super-admin|admin']], function() {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

});
//Route::resource('permission', [PermissionController::class]);



Route::get('login', [AuthController::class, "login"])->name('login');
Route::post('login', [AuthController::class, "loginPost"])->name('login.post');

Route::get('register', [AuthController::class, "register"])->name('register');
Route::post('register', [AuthController::class, "registerPost"])->name('register.post');


Route::group(['middleware' => ['auth']], function() {
   
    Route::get('/logout',  [AuthController::class, "logout"])->name('logout.logout');
 });