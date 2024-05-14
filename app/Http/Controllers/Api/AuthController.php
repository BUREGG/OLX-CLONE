<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'email',
                'required'

            ],
            'password' => [
                'required'
            ]

            ]);

            $credentials = request(['email', 'password']);
            if(!auth()->attempt($credentials)){
                return response()->json([
                    'message' => 'Given data is valid',
                    'errors' => [
                        'password' => [
                            'Invalid credentials'
                        ],
                    ]
                    ], status: 422);
            }

            $user = User::where('email', $request->email)->first();
            $authToken = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'access_token' =>$authToken,
            ]);
        
    }
}
