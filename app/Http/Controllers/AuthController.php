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
    public function login(){
        return view('login');
    }
    public function register(){
        return view('register');
    }
    public function chat(){
        return view('chat');
    }
    function loginPost(Request $request){
        $request->validate([
            "email"=> "required",
            "password" => "required"
        ]);
        $credentials = $request->only("email","password");
        if(Auth::attempt($credentials)){
            return(redirect()->intended(route('home')));
        }
        return redirect(route('login'))->with("error", "login failed");

    }
    function registerPost(Request $request){
        $request->validate([
            "name"=> "required",
            "email"=> "required",
            "password" => "required"
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if($user->save()){
            return redirect(route('login'))->with("success", "user created succesfully");
        }
        return redirect(route('register'))->with("error","Failed to create user");
    }
    public function logout()
    {
        FacadesSession::flush();
        
        Auth::logout();

        return redirect('login');
    }
}
