<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('secret'),
                ]);

                Auth::login($user);
            }
            return redirect()->route('Dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Ocurrió un error al iniciar sesión con Google');
        }
    }
}
