<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
    $users = User::with('products')->get();
return UserResource::collection($users);   
 }
 public function store(StoreUserRequest $request)
 {
    $user = User::create($request->all());
        return new UserResource($user);
    
 }

}
