<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    public function redirigirGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function manejarGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();

        if(!$user)
        {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(str_random(16)),
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
