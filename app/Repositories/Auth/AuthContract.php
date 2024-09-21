<?php
namespace App\Repositories\Auth;
interface AuthContract {
    public function login($request);
    public function forgotPassword($request);
    public function resetPassword($request);
}
