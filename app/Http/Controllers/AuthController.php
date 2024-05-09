<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function chat()
    {
        return view('chat');
    }
    function loginPost(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'password' => [
                'required'
                ]
        ]);
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            return (redirect()->intended(route('homepage')));
        }
        return redirect(route('login'))->with("error", "login failed");
    }
    function registerPost(Request $request)
    {
        $request->validate([
            'name' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:7'
            ],
            'phone_number' => [
                'required',
                'digits:9'
            ]
        ]);
        $userExists = User::where('email', $request->email)->exists();
        if($userExists)
        {
            return redirect(route('login'))->with("error", "Podany email istnieje już w bazie");
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $credentials = $request->only("email", "password");
        $user->assignRole('User');

        if ($user->save() && Auth::attempt($credentials)) {
            return redirect()->intended(route('homepage'))->with("success", "user created succesfully");
        }else
        return redirect(route('register'))->with("error", "Failed to create user");
    }
    public function logout()
    {
        FacadesSession::flush();

        Auth::logout();

        return redirect('login');
    }
}
