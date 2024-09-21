<?php

namespace App\Repositories\Auth;

use App\Notifications\ResetPasswordNotification;
use App\Repositories\Auth\AuthContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EloquentAuthRepository implements AuthContract
{
    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->last_login_at = now();
            $user->save();
            request()->session()->regenerate();
            return true;
        }
        return false;
    }

    public function forgotPassword($request)
    {
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = User::where('email', $request->email)->first();
        return $user->notify(new ResetPasswordNotification($user, $token));
    }
}
