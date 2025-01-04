<?php
namespace App\Repositories\Registration;
use App\Repositories\Registration\RegistrationContract;
use App\Models\User;
use App\Notifications\RegistrationNotification;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EloquentRegistrationRepository implements RegistrationContract {
    public function create($request) {

        // Begin Database Transaction
        DB::beginTransaction();
        // dd($request->all());
        // Create User Record
        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->institution = $request->institution;
        $user->password = Hash::make($request->password);
        $user->uuid = Str::uuid();
        $user->save();

        // Assign Role
        $user->assignRole('Author');
        $code = authenticationCode(6);

        // Create Activation Record
        $user->activation()->create([
            'email' => $user->email,
            'code' => $code,
            'uuid' => Str::uuid(),
        ]);
        // dd($user);
        // Commit Database Transaction
        DB::commit();

        // Send Email Notification
        $user->notify(new RegistrationNotification($user));
        return $user;
    }

    public function verifyAcount($request)
    {
        // Find User
        $user = User::where('email', $request->email)->first();

        // Find Activation Record
        $activation = $user->activation;

        // dd($user, $activation, $request->code);
        // Verify Activation Code
        if ($activation->code == $request->code) {
            // Activate User Account
            $user->markEmailAsVerified();
            // Delete Activation Record
            $activation->delete();

            // Send Welcome Notification
            // $user->notify(new WelcomeNotification($user));
            return $user;
        }
        return false;
    }
}
