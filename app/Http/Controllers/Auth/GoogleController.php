<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
                Session::flash('google_user', 'Este correo está registrado, por favor valida tu contraseña.');
                return redirect()->route('login');
            } else {
                return redirect()->route('register');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Ocurrió un error al iniciar sesión con Google');
        }
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $googleUser = Session::get('google_user');

        if (!$googleUser) {
            return redirect()->route('login')->with('error', 'Error al validar usuario de Google');
        }

        $user = User::where('email', $googleUser['email'])->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            Session::forget('google_user');

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['password' => 'La contraseña no coincide con la cuenta de Google.']);
    }
}
