<?php

namespace App\Http\Controllers;

use App\Repositories\Journal\JournalContract;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $journalsRepo;

    public function __construct(JournalContract $journalContract)
    {
        $this->journalsRepo = $journalContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = $this->journalsRepo->getAll()->count();
        $journalsApproved = $this->journalsRepo->getAll()->where('approval_status', 'approved')->count();
        $journalsPending = $this->journalsRepo->getAll()->where('approval_status', 'pending')->count();
        $journalsRejected = $this->journalsRepo->getAll()->where('approval_status', 'declined')->count();
        // dd($journals);
        return view('dashboard.admin.dashboard', compact('journals', 'journalsApproved', 'journalsPending', 'journalsRejected'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
