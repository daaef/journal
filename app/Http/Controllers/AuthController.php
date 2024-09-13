<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\AuthContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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


        if ($this->repo->login($request->all())) {
            return redirect()->intended('dashboard');
        }

        $notification = array(
            'message' => 'The provided credentials do not match our records.',
            'alert-type' => 'error'
        );
        return back()->with($notification)->onlyInput('username');
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
