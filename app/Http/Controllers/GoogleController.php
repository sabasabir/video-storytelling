<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $googleUser->user['given_name'] ?? '',
                    'last_name'  => $googleUser->user['family_name'] ?? '',
                    'email'      => $googleUser->getEmail(),
                    'password'   => bcrypt(Str::random(16)), // random password
                ]
            );

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Google login failed, try again.']);
        }
    }
}
