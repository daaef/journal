<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Journal\JournalContract;
use Illuminate\Support\Facades\Auth;

class ReviewerDashboardController extends Controller
{
    protected $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JournalContract $journalContract)
    {
        $this->repo = $journalContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        // dd(auth()->user()->hasRole('Reviewer'));
        $reviewer = auth()->user();
        // $journals = $reviewer->reviews()->with('journal')->get();
        $user = auth()->user();
//        $journals = $this->repo->getJournalsForReviewer($user->id);
        // dd($journals);
        $reviewerId = Auth::id();
        $pendingJournals = $this->repo->getPendingApprovedJournals()->count();
        $approvedJournals = $this->repo->getApprovedJournals()->count();
        $journalsInProgress = $this->repo->getJournalsInProgress()->count();
        $declinedJournals = $this->repo->getRejectedJournals()->count();
        $journals = $this->repo->getPendingApprovedJournalsForReviewer($reviewerId);

        return view('dashboard.reviewer.dashboard', compact('pendingJournals', 'approvedJournals', 'journalsInProgress', 'declinedJournals', 'journals'));
    }
}
