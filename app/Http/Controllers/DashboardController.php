<?php

namespace App\Http\Controllers;

use App\Models\Journal;
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
//        dd(' User Dashboard');
        $journals = Journal::all();
        return view('user.dashboard', compact('journals'));
    }
}
