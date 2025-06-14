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
        $reviewer = Auth::user();
        $user = Auth::user();
        $reviewerId = Auth::id();
        
        // Use reviewer-specific methods that filter by assigned manuscripts only
        $pendingJournals = $this->repo->getPendingApprovedJournalsForReviewer()->total();
        $approvedJournals = $this->repo->getApprovedJournalsForReviewer()->total();
        $reviewedJournals = $this->repo->getReviewedJournalsForReviewer()->total();
        $journalsInProgress = $this->repo->getInProgressJournalsForReviewer()->total();
        $declinedJournals = $this->repo->getDeclinedJournalsForReviewer()->total();
        $journals = $this->repo->getPendingApprovedJournalsForReviewer($reviewerId);
        $allJournals = $this->repo->getJournalsForReviewer($reviewerId);

        return view('dashboard.reviewer.dashboard', compact('pendingJournals', 'approvedJournals', 'reviewedJournals', 'journalsInProgress', 'declinedJournals', 'journals', 'allJournals'));
    }
}
