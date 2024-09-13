<?php
namespace App\Repositories\Auth;
use App\Repositories\Auth\AuthContract;
use Illuminate\Support\Facades\Auth;


class EloquentAuthRepository implements AuthContract {
    public function login($credentials) {
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return true;
        }
        return false;
    }
}
