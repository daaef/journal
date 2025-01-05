<?php

namespace App\Http\Controllers;

use App\Mail\ManuscriptSubmissionNotification;
use App\Mail\SendReviewerInvitationNotification;
use App\Models\User;
use App\Repositories\Category\CategoryContract;
use App\Repositories\DislikeJournal\DislikeJournalContract;
use App\Repositories\Journal\JournalContract;
use App\Repositories\LikeJournal\LikeJournalContract;
use App\Repositories\Reviewer\ReviewerContract;
use App\Repositories\SubCategory\SubCategoryContract;
use App\Repositories\User\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JournalController extends Controller
{

    protected $repo;
    protected $categoryRepo;
    protected $subCategoryRepo;
    protected $likeJournalRepo;
    protected $dislikeJournalRepo;
    protected $userRepo;
    protected $reviewerRepo;

    public function __construct(
        JournalContract $journalContract,
        CategoryContract $categoryContract,
        SubCategoryContract $subCategoryContract,
        LikeJournalContract $likeJournalContract,
        DislikeJournalContract $dislikeJournalContract,
        UserContract $userContract,
        ReviewerContract $reviewerContract
    ) {
        $this->repo = $journalContract;
        $this->categoryRepo = $categoryContract;
        $this->subCategoryRepo = $subCategoryContract;
        $this->likeJournalRepo = $likeJournalContract;
        $this->dislikeJournalRepo = $dislikeJournalContract;
        $this->userRepo = $userContract;
        $this->reviewerRepo = $reviewerContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepo->getAll();
        $journals = $this->repo->getAll();
        $regions = globalRegions();
        // dd($regions);
        $languages = journalLanguages();
        return view('journals', compact('journals', 'regions', 'categories', 'languages'));
    }

    public function searchJournal(Request $request)
    {
        $journals = $this->repo->getAll();
        $categories = $this->categoryRepo->getAll();

        if ($request->search) {
            $journals = $this->repo->searchJournal($request);
        }
        $regions = globalRegions();
        return view('journals', compact('journals', 'categories', 'regions'));
    }

    public function likeJournal(Request $request)
    {
        if (!auth()->check()) {
            $notification = array(
                'message' => 'You need to login to download the journal.',
                'alert-type' => 'warning'
            );

            // User is not authenticated, redirect to login page
            return redirect()->route('login')->with($notification);
        }
        // dd($request->all(), 'likeJournal');
        // validate user id
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //check if user has already liked the journal
        $check = $this->likeJournalRepo->checkIfUserHasLikedJournal($request->journal_id, $request->user_id);
        // dd($check);
        if ($check) {
            $notification = array(
                'message' => 'You have already liked this journal',
                'alert-type' => 'info'
            );
            return redirect()->back()->with($notification);
        }

        $journal = $this->likeJournalRepo->likeJournal($request->journal_id, $request->user_id);
        // dd($journal);
        if ($journal) {
            $notification = array(
                'message' => 'Journal Liked successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $notification = array(
            'message' => 'Error Liking journal',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function dislikeJournal(Request $request)
    {
        if (!auth()->check()) {
            $notification = array(
                'message' => 'You need to login to download the journal.',
                'alert-type' => 'error'
            );

            // User is not authenticated, redirect to login page
            return redirect()->route('login')->with($notification);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'journal_id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //check if user has already liked the journal
        $check = $this->dislikeJournalRepo->checkIfUserHasLikedJournal($request->journal_id, $request->user_id);

        if ($check) {
            $notification = array(
                'message' => 'You have already disliked this journal',
                'alert-type' => 'info'
            );
            return redirect()->back()->with($notification);
        }

        $journal = $this->likeJournalRepo->dislikeJournal($request->journal_id, $request->user_id);

        if ($journal) {
            $notification = array(
                'message' => 'Journal disliked successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $notification = array(
            'message' => 'Error disliking journal',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journals.create');
    }


    public function creatManuscript()
    {
        $regions = globalRegions();
        $languages = journalLanguages();
        $categories = $this->categoryRepo->getAll();
        $subcategories = $this->subCategoryRepo->getAll();
        $users = User::all();
        return view('user.submit-manuscript', compact('regions', 'languages', 'categories', 'subcategories', 'users'));
    }


    public function submitManuscript(Request $request)
    {
        // dd($request->all());
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



//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }

        $journal = $this->repo->submitManuscript($request);

        if ($journal) {
            // Send email notification to the author
            Mail::to(auth()->user()->email)->send(new ManuscriptSubmissionNotification(auth()->user(), $journal, 'Author'));

            // Send email notification to the admin, editor in chief, and managing editor
            $roles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Desk Editor'];
            $users = User::role($roles)->get();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new ManuscriptSubmissionNotification($user, $journal, $user->getRoleNames()->first()));
            }


            $notification = array(
                'message' => 'Manuscript Submitted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('user.submissions')->with($notification);
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

    public function userSubmissions()
    {
        $journals = $this->repo->getUserSubmissions(auth()->user()->id);
        return view('user.submissions', compact('journals'));
    }

    /**
     * Display the specified resource.
     */
    public function showJournal(string $slug)
    {

        $journal = $this->repo->findBySlug($slug);
        $comments = $journal->comments()->with('user')->get();
        return view('view-abstract', compact('journal','comments'));
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

    public function pendingApproval()
    {
        $journals = $this->repo->getPendingApprovedJournals();
        return view('dashboard.editor.journals.showPendingApproval', compact('journals'));
    }


    public function previewJournal(string $uuid)
    {
        // return "dsdsds";
        $journal = $this->repo->findByUuid($uuid);
        $reviewers = $this->userRepo->getReviewers();
        // dd($reviewers);
        $assignedReviewers = $journal->reviewers()->with('reviewer')->get();
        $comments = $journal->comments()->with('user')->get();
        return view('dashboard.editor.journals.journalPreview', compact('journal', 'reviewers', 'assignedReviewers', 'comments'));
    }

    public function reviewerPreviewJournal(string $uuid)
    {
        $journal = $this->repo->findByUuid($uuid);
        $reviewers = $this->userRepo->getReviewers();
        // dd($reviewers);
        $assignedReviewers = $journal->reviewers()->with('reviewer')->get();
        $comments = $journal->comments()->with('user')->get();
        return view('dashboard.reviewer.journals.journalPreview', compact('journal', 'reviewers', 'assignedReviewers', 'comments'));
    }

    public function SaveJournalReviewers(Request $request, string $uuid)
    {

        $journal = $this->reviewerRepo->SaveJournalReviewers($request, $uuid);
        if ($journal) {
            // Send email notification to each reviewer
            foreach ($request->reviewers as $reviewerUuid) {
                $reviewer = User::where('uuid', $reviewerUuid)->first();
                Mail::to($reviewer->email)->send(new SendReviewerInvitationNotification($reviewer, $journal));
            }

            $notification = array(
                'message' => 'Reviewers saved successfully and email notifications sent',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            'message' => 'Error saving reviewers',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function approveJournal(Request $request)
    {
        $uuid = $request->journal_uuid;

        $journal = $this->repo->approveJournal($uuid);

        if ($journal) {
            $notification = array(
                'message' => 'Journal Approved successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $notification = array(
            'message' => 'Error Approving Journal',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function approveJournalWithComment(Request $request)
    {
        // dd($request->all());
        // validate request
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // return $request->all();

        $uuid = $request->journal_uuid;

        $journal = $this->repo->approveJournalWithComment($uuid, $request);

        if ($journal) {
            $notification = array(
                'message' => 'Journal Approved successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $notification = array(
            'message' => 'Error Approving Journal',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Request changes to a journal by an editor
    */
    public function requestChange(Request $request, $journal_id)
    {
        $validated = $request->validate([
            'changes' => 'required|array',
            'changes.*.field' => 'required|string',
            'changes.*.suggested_change' => 'required|string',
            'changes.*.comment' => 'nullable|string',
        ]);

        $editorId = auth()->id();

        $journal = $this->repo->requestChange($journal_id, $validated['changes'], $editorId);

        return response()->json([
            'success' => true,
            'message' => 'Change requests submitted successfully.',
            'data' => $journal,
        ], 200);
    }

    /**
     * Update a journal by the author based on change requests.
     */
    public function authorUpdate(Request $request, $journalId)
    {
        $validated = $request->validate([
            'updated_fields' => 'required|array',
        ]);

        $authorId = auth()->id();

        $journal = $this->repo->authorUpdate($journalId, $validated['updated_fields'], $authorId);

        return response()->json([
            'success' => true,
            'message' => 'Journal updated successfully based on change requests.',
            'data' => $journal,
        ], 200);
    }

    public function approvedJournals()
    {
        $journals = $this->repo->getApprovedJournals();
        return view('dashboard.editor.journals.showApprovedJournals', compact('journals'));
    }

    public function inProgressJournals()
    {
        $journals = $this->repo->getJournalsInProgress();
        return view('dashboard.editor.journals.showInProgressJournals', compact('journals'));
    }

    public function rejectedJournals()
    {
        $journals = $this->repo->getRejectedJournals();
        return view('dashboard.editor.journals.showRejectedJournals', compact('journals'));
    }

    public function reviewedJournals()
    {
        $journals = $this->repo->getJournalsReviewed();
        return view('dashboard.editor.journals.showReviewedJournals', compact('journals'));
    }

    public function reviewerApprovedJournals()
    {
        $journals = $this->repo->getApprovedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showApprovedJournals', compact('journals'));
    }

    public function reviewerPendingApproval()
    {
        $journals = $this->repo->getPendingApprovedJournalsForReviewer();
        // dd($journals);
        return view('dashboard.reviewer.journals.showPendingApproval', compact('journals'));
    }

    public function reviewerInProgressJournals()
    {
        $journals = $this->repo->getInProgressJournalsForReviewer();
        return view('dashboard.reviewer.journals.showInProgressJournals', compact('journals'));
    }

    public function reviewerRejectedJournals()
    {
        $journals = $this->repo->getDeclinedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showRejectedJournals', compact('journals'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
