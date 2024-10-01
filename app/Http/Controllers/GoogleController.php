<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\LoginNotification;
use App\Notifications\WelcomeNotification;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        // dd($googleUser);
        $user = User::where('email', $googleUser->email)->first();
        if (!$user) {
            $user = User::create([
                'fullname' => $googleUser->name,
                'username' => $googleUser->email,
                'email' => $googleUser->email,
                'password' => Hash::make(rand(100000, 999999)),
                'avatar' => $googleUser->avatar,
            ]);
            $user->assignRole('Author');
            $user->markEmailAsVerified();

            $user->notify(new WelcomeNotification($user));
        }

        Auth::login($user);
        $user = Auth::user();
        $user->last_login_at = now();
        $user->save();

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }

        //If user is an editor
        if ($user->hasRole('Editor')) {
            return redirect()->route('editor.dashboard');
        }

        //If user is an author
        if ($user->hasRole('Author')) {
            return redirect()->route('dashboard');
        }
        
        // Send Login Notification
        $clientIP = request()->ip();
        $userAgent = request()->userAgent();
        // dd($userAgent);
        $user->notify(new LoginNotification($user, $clientIP, $userAgent));
        return redirect()->route('dashboard');
    }
}
