<?php

namespace App\Http\Controllers;

use App\Repositories\Registration\RegistrationContract;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

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
        return view('auth.register');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'country' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $user = $this->repo->create($request);
            if($user) {
                $notification = array(
                    'message' => 'Successfully Registered',
                    'alert-type' => 'success'
                );
                return redirect()->route('auth.success_activation.get')->with($notification);
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


}
