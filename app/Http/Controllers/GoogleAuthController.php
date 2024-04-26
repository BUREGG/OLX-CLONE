<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\Console\Input\Input;

class GoogleAuthController extends Controller
{
    public function redirect()
    {

        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();
        //dd($googleuser);
        $user = User::where('email', $googleUser->email)->first();


        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);
        }

        return redirect('/');
    }
}
