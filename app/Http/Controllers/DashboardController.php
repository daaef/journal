<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $repo;

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleNames();
        $permissions = $user->getPermissionsViaRoles();
        // dd($role, $permissions);
        return view('layouts.master');
    }
}
