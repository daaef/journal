<?php

namespace App\Http\Controllers;

use App\Repositories\Journal\JournalContract;
use Illuminate\Http\Request;

class EditorDashboardController extends Controller
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
        // dd(auth()->user()->hasRole('Editor'));
        $pendingJournals = $this->repo->getPendingApprovedJournals()->count();
        $approvedJournals = $this->repo->getApprovedJournals()->count();
        $journalsInProgress = $this->repo->getJournalsInProgress()->count();
        $declinedJournals = $this->repo->getRejectedJournals()->count();
        // dd($pendingArticles);
        return view('dashboard.editor.dashboard', compact('pendingJournals', 'approvedJournals', 'journalsInProgress', 'declinedJournals'));
    }
}
