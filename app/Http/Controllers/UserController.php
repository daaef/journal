<?php

namespace App\Http\Controllers;

use App\Repositories\Role\RoleContract;
use App\Repositories\User\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $repo;
    protected $roleRepo;

    public function __construct(UserContract $userContract, RoleContract $roleContract)
    {
        $this->repo = $userContract;
        $this->roleRepo = $roleContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->repo->getAll();
        return view('dashboard.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles  = $this->roleRepo->getAll();
        return view('dashboard.admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'country' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->repo->create($request);

        if (!$user) {
            $notification = array(
                'message' => 'User creation failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'User created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $user = $this->repo->findByUUID($uuid);
        // dd($user);
        return view('user.settings', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'country' => 'required',
            'password' => 'nullable|between:8,20',
            'confirm_password' => 'nullable|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find user
        $user = $this->repo->findByUUID($uuid);

        if (!$user) {
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        // check if password is not empty
        if (!empty($request->password)) {
            //check if password is not the same as the old password
            if (!Hash::check($request->old_password, $user->password)) {
                $notification = array(
                    'message' => 'Password did not match',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }

        }

        $user = $this->repo->update($request, $uuid);

        if (!$user) {
            $notification = array(
                'message' => 'User creation failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'Account updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
