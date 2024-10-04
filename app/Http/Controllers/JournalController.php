<?php

namespace App\Http\Controllers;

use App\Repositories\Journal\JournalContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JournalController extends Controller
{

    protected $repo;
    public function __construct(JournalContract $journalContract)
    {
        $this->repo = $journalContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = $this->repo->getAll();
        return view('journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journals.create');
    }


    public function creatManuscript() {
        $regions = africanRegions();
        $languages = journalLanguages();
        return view('user.submit-manuscript', compact('regions', 'languages'));
    }


    public function submitManuscript(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'country' => 'required',
            'journal_language' => 'required',
            'abstract' => 'required',
            'manuscripts' => 'required',
            'file' => 'required|mimes:pdf|max:10000',
            'accept' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $journal = $this->repo->submitManuscript($request);

        if($journal) {
            $notification = array(
                'message' => 'Manuscript Submitted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('journals.index')->with($notification);
        }

        $notification = array(
            'message' => 'Error submitting Manuscript',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->repo->create($request);

        $notification = array(
            'message' => 'Journal Created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('journals.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = $this->repo->findById($id);
        return view('journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $journal = $this->repo->findById($id);
        return view('journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->repo->update($request, $id);

        $notification = array(
            'message' => 'Journal Updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('journals.index')->with($notification);
    }

    public function pendingApproval() {
        $journals = $this->repo->getPendingApprovedJournals();
    }


    public function approvedJournals() {
        $journals = $this->repo->getApprovedJournals();
        return view('journals.approvedJournals', compact('journals'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
