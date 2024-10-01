<?php

namespace App\Http\Controllers;

use App\Repositories\Role\RoleContract;
use App\Repositories\User\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'fullname' => 'required',
            'username' => 'required',
            'email' => 'required',
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
