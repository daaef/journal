<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\AuthContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
            $user->last_login_at = now();
            $user->save();

            // dd('It work');
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
                $notification = array(
                    'message' => 'The provided email does not exist in our records.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->repo->forgotPassword($request);

            $notification = array(
                'message' => 'Password reset link has been sent to your email.',
                'alert-type' => 'success'
            );
            return redirect()->route('auth.success_reset_request.get')->with($notification);
            // return redirect()->back()->with($notification);
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

            // dd($request->all());

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
            // return redirect()->route('auth.login')->with($notification);
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
