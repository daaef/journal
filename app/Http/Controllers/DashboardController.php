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
        // Get user's published/collection journals and submitted manuscripts
        $myCollections = auth()->user()->myJournalCollections()->get();
        $mySubmissions = Journal::where('user_id', auth()->user()->id)
            ->with(['reviewers', 'category'])
            ->withCount('reviewers')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact('myCollections', 'mySubmissions'));
    }
}
