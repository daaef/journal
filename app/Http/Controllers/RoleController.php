<?php

namespace App\Http\Controllers;

use App\Repositories\Role\RoleContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    protected $repo;

    public function __construct(RoleContract $roleContract)
    {
        $this->repo = $roleContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->repo->getAll();
        return view('dashboard.admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // create role
        $role = $this->repo->create($request);
        if (!$role) {
            $notification = array(
                'message' => 'Role creation failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'Role created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('roles.index')->with($notification);

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
        $role = $this->repo->findByUuid($id);
        return view('dashboard.admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // update role
        $role = $this->repo->update($id, $request);

        if (!$role) {
            $notification = array(
                'message' => 'Role update failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'Role updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('roles.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = array(
            'message' => "Role can't be deleted. It has users assigned to it",
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
