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
            // dd($request->all());

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
                'message' => 'Password reset token has been sent to your email.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        return view('auth.forgot');
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
