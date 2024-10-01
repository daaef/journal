<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use App\Models\User;
use App\Repositories\Auth\AuthContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RegistrationNotification;
use App\Notifications\LoginNotification;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $repo;

    public function __construct(AuthContract $authContract)
    {
        $this->repo = $authContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('auth.login');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            $notification = array(
                'message' => $validator,
                'alert-type' => 'error'
            );
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Auth::attempt($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate the session ID
            $user = Auth::user();

            $loggedUser = User::find($user->id);
            $code = random_int(100000, 999999);

            // Check if user is verified
            if (!$loggedUser->hasVerifiedEmail()) {

                // Get user activation record
                $activation = Activation::where('email', $loggedUser->email)->first();
                // Check if activation record exists
                if ($activation) {
                    $loggedUser->activation()->update([
                        'email' => $loggedUser->email,
                        'code' => $code,
                        'uuid' => Str::uuid(),
                    ]);
                } else {
                    // Create activation record
                    $loggedUser->activation()->create([
                        'email' => $loggedUser->email,
                        'code' => $code,
                        'uuid' => Str::uuid(),
                    ]);
                }

                $loggedUser->notify(new RegistrationNotification($user));

                $notification = array(
                    'message' => 'Your account is not activated. Please check your email for activation link.',
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }

            $user->last_login_at = now();
            $user->save();

            // Send Login Notification
            $clientIP = request()->ip();
            $userAgent = request()->userAgent();
            // dd($userAgent);
            $user->notify(new LoginNotification($user, $clientIP, $userAgent));

            //If user is an admin
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

            //If user is an author
            if ($user->hasRole('Publisher')) {
                return redirect()->route('dashboard');
            }

            $notification = array(
                'message' => 'Logged in successfully',
                'alert-type' => 'success'
            );
            return redirect()->intended('dashboard')->with($notification);
        }

        $notification = array(
            'message' => 'The provided credentials do not match our records.',
            'alert-type' => 'error'
        );
        return back()->with($notification)->withInput();
    }


    public function forgotPassword(Request $request)
    {

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->repo->forgotPassword($request);

            $notification = array(
                'message' => 'Password reset link has been sent to your email.',
                'alert-type' => 'success'
            );
            return redirect()->route('auth.forgot-password-success.get')->with($notification);
        }

        return view('auth.forgot');
    }

    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                $notification = array(
                    'message' => 'The provided credentials do not match our records.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->repo->resetPassword($request);

            $notification = array(
                'message' => 'Password has been reset successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('auth.success_reset.get')->with($notification);
        }

        return view('auth.reset');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
