<?php
namespace App\Repositories\Registration;
use App\Repositories\Registration\RegistrationContract;
use App\Models\User;
use App\Notifications\RegistrationNotification;
use Illuminate\Support\Facades\Hash;

class EloquentRegistrationRepository implements RegistrationContract {
    public function create($request) {
        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole('Author');

        $user->notify(new RegistrationNotification($user));
        return $user;
    }

    public function verifyAcount($request)
    {

    }
}
