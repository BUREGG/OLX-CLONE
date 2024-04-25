<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {

        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        $googleuser = Socialite::driver('google')->user();
//dd($googleuser);
$user = User::updateOrCreate([
    'google_id' => $googleuser->id,
], [
    'name' => $googleuser->name,
    'email' => $googleuser->email,
    'google_token' => $googleuser->token,
    'google_refresh_token' => $googleuser->refreshToken,
]);

Auth::login($user);
return redirect('/');

    }
}
