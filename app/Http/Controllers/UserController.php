<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserContract;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $repo;

    public function __construct(UserContract $userContract)
    {
        $this->repo = $userContract;
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
        return view('dashboard.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
