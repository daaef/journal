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
        dd(' User Dashboard');
        return view('layouts.master');
    }
}
