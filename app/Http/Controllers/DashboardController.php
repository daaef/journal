<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
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
        // $journals = Journal::all();
        $journals = auth()->user()->myJournalCollections()->get();
        return view('user.dashboard', compact('journals'));
    }
}
