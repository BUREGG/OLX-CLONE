<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\URL;
use PgSql\Lob;

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
        return redirect(route('login'))->with("error", "Logowanie nieudane");
    }
    function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'min:3',
                'max:20'
            ],
            'email' => [
                'required',
                'email'
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
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Niepoprawne dane');
        }
        $userExists = User::where('email', $request->email)->exists();
        if ($userExists) {
            return redirect(route('login'))->with('error', "Podany email istnieje już w bazie");
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
        } else
            return redirect(route('register'))->with("error", "Failed to create user");
    }
    public function logout()
    {
        FacadesSession::flush();

        Auth::logout();

        return redirect('login');
    }
    public function forgotPassword()
    {
        return view('forgot-password');
    }
    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ]
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgot-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset Password");
        });
        return redirect()->to(route('password.request'));
    }
    public function resetPassword($token, Request $request)
    {
        return view('new-password', compact('token'), ['request' => $request]);
    }
    public function resetPasswordPost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:7',
                'confirmed'
            ], 'password_confirmation' => [
                'required',
                'string',
                'min:7',
                'same:password'
            ]

        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Niepoprawne dane');
        }
        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();
        if ($updatePassword === null || $updatePassword->created_at === null) {
            return redirect()->back()->with('error', 'Niepoprawny e-mail');
        }
        $createdat = ($updatePassword->created_at);
        $now = Carbon::now();
        $diff = $now->diffInMinutes($createdat);
        if ($request->email != $updatePassword->email) {
            return redirect()->route('password.reset')->with('error', 'Niepoprawny e-mail');
        }
        if ($updatePassword === null || $updatePassword->token === null || $diff > 3) {
            return redirect()->route('password.request')->with('error', 'link wygasł');
        }
        if (!$updatePassword) {
            return redirect()->route('password.reset')->with("error", "invalid");
        }
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return redirect()->to(route('login'))->with("success", "haslo zostało zmienione");
    }
}
