<?php

namespace App\Http\Controllers;

use App\Repositories\Registration\RegistrationContract;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

    protected $repo;

    public function __construct(RegistrationContract $registrationContract)
    {
        $this->repo = $registrationContract;
    }


    /**
     * Display a listing of the resource.
     */
    public function getRegister()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('auth.register');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'country' => 'required',
            'institution' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = $this->repo->create($request);

            if($user) {
                $notification = array(
                    'message' => 'Successfully Registered',
                    'alert-type' => 'success'
                );
                return redirect()->route('auth.activate')->with($notification)->with('user_email', $user->email);
            }

        } catch (\Throwable $th) {
            //throw $th;
            $notification = array(
                'message' => 'An Error Occured',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    // Activate Account
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            // 'id' => 'required',
            'code' => 'required',
        ]);

        // dd($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = $this->repo->verifyAcount($request);
            if($user) {
                $notification = array(
                    'message' => 'Account Activated Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('auth.login.get')->with($notification);
            }

        } catch (\Throwable $th) {
            //throw $th;
            $notification = array(
                'message' => 'An Error Occured',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    //show actination page
    public function showActivationPage()
    {
        return view('auth.activate');
    }



}
