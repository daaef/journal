<?php

namespace App\Repositories\Auth;

use App\Notifications\ResetPasswordNotification;
use App\Repositories\Auth\AuthContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $email = $request->email;
        $token = Str::random(64);

        // Check if a password reset token already exists for the user
        $existingToken = DB::table('password_reset_tokens')->where('email', $email)->first();
        if ($existingToken) {
            // If a token exists, update it
            DB::table('password_reset_tokens')->where('email', $email)->update([
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        } else {
            // If no token exists, create a new one
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        // return $user->notify(new ResetPasswordNotification($user, $token));
    }

    public function resetPassword($request)
    {
        $token = $request->token;
        $password = $request->password;

        // Find the user associated with the token
        $user = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$user) {
            return false; // Token not found
        }

        // Update the user's password
        $user = User::where('email', $user->email)->first();
        $user->password = Hash::make($password);
        $user->save();

        // Delete the token after password reset
        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return true;
    }
}
