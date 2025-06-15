<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ManuscriptVersion;
use App\Notifications\ReviewSubmittedNotification;
use App\Repositories\Category\CategoryContract;
use App\Repositories\DislikeJournal\DislikeJournalContract;
use App\Repositories\Journal\JournalContract;
use App\Repositories\LikeJournal\LikeJournalContract;
use App\Repositories\Reviewer\ReviewerContract;
use App\Repositories\SubCategory\SubCategoryContract;
use App\Repositories\User\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        if (!Auth::check()) {
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
        if (!Auth::check()) {
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
        // Debug: Let's see what we're getting
        // dd($request->all());

        // Check if user has accepted review policy (either previously or in this request)
        $userHasAcceptedPolicy = Auth::user()->review_policy_accepted || $request->has('review_policy_accepted');

        if (!$userHasAcceptedPolicy) {
            $notification = array(
                'message' => 'Review policy acceptance is required. Please accept the JAPR Review Policy first.',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        // Build validation rules - review_policy_accepted is only required if user hasn't already accepted
        $validationRules = [
            'title' => 'required',
            'author' => 'required',
            'country' => 'required',
            'journal_language' => 'required',
            'abstract' => 'required',
            'manuscripts' => 'required|mimes:pdf|max:10000',
            'agree_japr_policy' => 'required|accepted'
        ];

        // Only require review_policy_accepted if user hasn't already accepted it
        if (!Auth::user()->review_policy_accepted) {
            $validationRules['review_policy_accepted'] = 'required|accepted';
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Please fill all required fields. ' . $validator->errors()->first(),
                'alert-type' => 'error'
            );
            return redirect()->back()->withErrors($validator)->with($notification)->withInput();
        }

        // Update user's review policy acceptance status if they're accepting it via the form
        // Only update if user hasn't already accepted the policy in the database
        if ($request->has('review_policy_accepted') && $request->review_policy_accepted) {
            $user = Auth::user();

            // Refresh user data to ensure we have the latest DB state
            $user->refresh();

            // Only update if user hasn't already accepted the policy
            if (!$user->review_policy_accepted) {
                $user->update([
                    'review_policy_accepted' => true,
                    'review_policy_accepted_at' => now()
                ]);

                // Optional: Log for debugging
                Log::info('User ' . $user->id . ' accepted review policy via form submission');
            }
            // If already accepted, we ignore the update (no action needed)
        }

        try {
            $journal = $this->repo->submitManuscript($request);

            if ($journal) {
                $notification = array(
                    'message' => 'Manuscript Submitted successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('user.submissions')->with($notification);
            }

            $notification = array(
                'message' => 'Error submitting Manuscript - Repository returned null',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Error submitting Manuscript: ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
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
        $journals = $this->repo->getUserSubmissionsWithDetails(Auth::id());
        return view('user.submissions', compact('journals'));
    }

    /**
     * Display the specified resource.
     */
    public function showJournal(string $slug)
    {
        $journal = $this->repo->findBySlug($slug);
        
        // Get general comments
        $comments = $journal->comments()->with('user')->get();
        
        // Get review comments specifically for the author (if user is the author)
        $authorReviewComments = collect();
        if (Auth::check() && Auth::user()->id === $journal->user_id) {
            $authorReviewComments = $journal->reviewers()
                ->whereNotNull('review_submitted_at')
                ->whereNotNull('comment')
                ->where('comment', '!=', '')
                ->with(['reviewer:id,fullname,email'])
                ->orderBy('review_submitted_at', 'desc')
                ->get();
        }
        
        return view('view-abstract', compact('journal', 'comments', 'authorReviewComments'));
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
     * Show the enhanced review form for Associate Editors (serves as both review and preview)
     */
    public function showEnhancedReviewForm(string $uuid, string $slug = null)
    {
        $journal = $this->repo->findByUUID($uuid);

        if (!$journal) {
            abort(404, 'Journal not found');
        }

        // Check if the current user is authorized to review this journal
        $user = Auth::user();
        if (!$user->hasRole(['Associate Editor', 'Desk Editor'])) {
            abort(403, 'Unauthorized to access enhanced review');
        }

        // Load relationships for the enhanced review view
        $journal->load(['author', 'category', 'sub_category', 'versions', 'reviewerAssignments.reviewer']);

        // Get the current user's existing review for this journal
        $existingReview = $journal->reviewerAssignments()
            ->where('user_id', Auth::id())
            ->first();

        // Get other reviewers' reviews for collaborative viewing (excluding current user)
        $otherReviews = $journal->reviewerAssignments()
            ->where('user_id', '!=', Auth::id())
            ->whereNotNull('comment')
            ->with('reviewer')
            ->get();

        // Define review criteria for structured assessment
        $reviewCriteria = [
            'originality' => 'Originality and Innovation',
            'methodology' => 'Methodology and Research Design',
            'significance' => 'Significance and Impact',
            'clarity' => 'Clarity and Presentation',
            'literature_review' => 'Literature Review',
            'data_analysis' => 'Data Analysis and Results'
        ];

        return view('dashboard.reviewer.journals.enhanced-review', compact('journal', 'existingReview', 'otherReviews', 'reviewCriteria'));
    }

    /**
     * Show enhanced review details for editors (Managing Editor and Editor-in-Chief)
     */
    public function showEnhancedReviewDetails(string $uuid)
    {
        $journal = $this->repo->findByUUID($uuid);
        
        if (!$journal) {
            abort(404, 'Journal not found');
        }

        // Check if user has permission to view review details
        if (!Auth::user()->hasAnyRole(['Managing Editor', 'Editor in Chief', 'Super Admin'])) {
            abort(403, 'Unauthorized to view review details');
        }

        // Load relationships for the review details view
        $journal->load([
            'reviewers' => function($query) {
                $query->whereNotNull('review_submitted_at')
                      ->with('user')
                      ->orderBy('review_submitted_at', 'desc');
            },
            'user',
            'category',
            'subCategory'
        ]);

        // Determine if current user can view confidential comments
        // Only Managing Editor, Editor in Chief, and Super Admin can see confidential comments
        $canViewConfidential = Auth::user()->hasAnyRole(['Managing Editor', 'Editor in Chief', 'Super Admin']);

        // Get all submitted reviews
        $reviews = $journal->reviewers()
            ->whereNotNull('review_submitted_at')
            ->with('user')
            ->orderBy('review_submitted_at', 'desc')
            ->get();

        return view('dashboard.editor.journals.enhanced-review-details', compact('journal', 'reviews', 'canViewConfidential'));
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


    public function reviewerPendingApproval()
    {
        // Use reviewer-specific method that filters by assigned manuscripts only
        $journals = $this->repo->getPendingApprovedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showPendingApproval', compact('journals'));
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
        // Validate that Associate Editors (reviewers) array exists and has 2-4 Associate Editors
        $validator = Validator::make($request->all(), [
            'reviewers' => 'required|array|min:2|max:4',
            'reviewers.*' => 'required|string|exists:users,uuid'
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Please select between 2-4 Associate Editors. ' . $validator->errors()->first(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Check for minimum and maximum limits with custom messages
        $reviewerCount = count($request->reviewers);
        if ($reviewerCount < 2) {
            $notification = array(
                'message' => 'Minimum of 2 Associate Editors required. Currently selected: ' . $reviewerCount,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        if ($reviewerCount > 4) {
            $notification = array(
                'message' => 'Maximum of 4 Associate Editors allowed. Currently selected: ' . $reviewerCount,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $journal = $this->reviewerRepo->SaveJournalReviewers($request, $uuid);
        if ($journal) {
            $notification = array(
                'message' => 'Associate Editors assigned successfully (' . $reviewerCount . ' Associate Editor' . ($reviewerCount > 1 ? 's' : '') . ' assigned)',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            'message' => 'Error assigning Associate Editors. Please try again.',
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


    public function approvedJournals()
    {
        $journals = $this->repo->getApprovedJournals();
        return view('dashboard.editor.journals.showApprovedJournals', compact('journals'));
    }

    public function reviewerApprovedJournals()
    {
        // Use reviewer-specific method that filters by assigned manuscripts only
        $journals = $this->repo->getApprovedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showApprovedJournals', compact('journals'));
    }

    /**
     * Accept journal invitation (reviewer response)
     */
    public function acceptJournal(Request $request)
    {
        try {
            $token = $request->get('token');

            if (!$token) {
                $notification = array(
                    'message' => 'Invalid invitation token.',
                    'alert-type' => 'error'
                );
                return redirect()->route('home')->with($notification);
            }

            // Find the reviewer by token
            $reviewer = \App\Models\Reviewer::where('token', $token)->first();

            if (!$reviewer) {
                $notification = array(
                    'message' => 'Invalid or expired invitation token.',
                    'alert-type' => 'error'
                );
                return redirect()->route('home')->with($notification);
            }

            // Update reviewer acceptance status
            $reviewer->is_accepted = true;
            $reviewer->token = null; // Clear token after use
            $reviewer->save();

            $notification = array(
                'message' => 'You have successfully accepted the review invitation.',
                'alert-type' => 'success'
            );

            // Redirect based on user authentication
            if (Auth::check() && Auth::user()->hasRole('Associate Editor')) {
                return redirect()->route('reviewer.dashboard')->with($notification);
            }

            return redirect()->route('home')->with($notification);

        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred while processing your request.',
                'alert-type' => 'error'
            );
            return redirect()->route('home')->with($notification);
        }
    }

    /**
     * Decline journal invitation (reviewer response)
     */
    public function declineJournal(Request $request)
    {
        try {
            $token = $request->get('token');

            if (!$token) {
                $notification = array(
                    'message' => 'Invalid invitation token.',
                    'alert-type' => 'error'
                );
                return redirect()->route('home')->with($notification);
            }

            // Find the reviewer by token
            $reviewer = \App\Models\Reviewer::where('token', $token)->first();

            if (!$reviewer) {
                $notification = array(
                    'message' => 'Invalid or expired invitation token.',
                    'alert-type' => 'error'
                );
                return redirect()->route('home')->with($notification);
            }

            // Update reviewer acceptance status
            $reviewer->is_accepted = false;
            $reviewer->token = null; // Clear token after use
            $reviewer->save();

            $notification = array(
                'message' => 'You have declined the review invitation.',
                'alert-type' => 'info'
            );

            return redirect()->route('home')->with($notification);

        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred while processing your request.',
                'alert-type' => 'error'
            );
            return redirect()->route('home')->with($notification);
        }
    }

    /**
     * Approve manuscript for publication (final editor decision)
     */
    public function approveForPublication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'comment' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $journal = $this->repo->approveForPublication($request->journal_uuid, $request->comment);

            if ($journal) {
                $notification = [
                    'message' => 'Manuscript approved for publication successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error approving manuscript for publication',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Reject manuscript (final editor decision)
     */
    public function rejectManuscript(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'reason' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $journal = $this->repo->rejectManuscript($request->journal_uuid, $request->reason);

            if ($journal) {
                $notification = [
                    'message' => 'Manuscript rejected successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error rejecting manuscript',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Request revisions from author (editor decision)
     */
    public function requestRevisions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'changes' => 'required|string|max:2000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $journal = $this->repo->requestRevisions($request->journal_uuid, $request->changes);

            if ($journal) {
                $notification = [
                    'message' => 'Revision request sent to author successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error requesting revisions',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Get journals reviewed by current user (for Associate Editors)
     */
    public function reviewedJournals()
    {
        $journals = $this->repo->getJournalsReviewed();
        return view('dashboard.editor.journals.showReviewedJournals', compact('journals'));
    }

    /**
     * Get in-progress journals (for Managing Editors/Editor in Chief)
     */
    public function inProgressJournals()
    {
        $journals = $this->repo->getJournalsInProgress();
        return view('dashboard.editor.journals.showInProgressJournals', compact('journals'));
    }

    /**
     * Get rejected journals
     */
    public function rejectedJournals()
    {
        $journals = $this->repo->getRejectedJournals();
        return view('dashboard.editor.journals.showRejectedJournals', compact('journals'));
    }

    /**
     * Get journals assigned to current Associate Editor for review
     */
    public function myAssignedReviews()
    {
        if (!Auth::user()->hasRole('Associate Editor')) {
            abort(403, 'Unauthorized');
        }

        $journals = $this->repo->getJournalsForReviewer(Auth::user()->id);
        return view('dashboard.reviewer.journals.myAssignedReviews', compact('journals'));
    }

    /**
     * Submit review comments and rating (Enhanced version for Associate Editors)
     */
    public function submitReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'comment' => 'required|string|max:5000',
            'rating' => 'required|integer|between:1,5',
            'recommendation' => 'required|in:accept,minor_revision,major_revision,reject',
            'criteria_ratings' => 'nullable|array',
            'criteria_ratings.*' => 'integer|between:0,5',
            'confidential_comments' => 'nullable|string|max:2000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if user has already submitted a review
        $journal = $this->repo->findByUUID($request->journal_uuid);
        $existingReview = $journal->reviewerAssignments()
            ->where('user_id', Auth::id())
            ->whereNotNull('review_submitted_at')
            ->first();

        if ($existingReview) {
            $notification = [
                'message' => 'You have already submitted a review for this manuscript.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Always finalize the review (no draft system)
        $result = $this->repo->submitReview(
            $request->journal_uuid,
            Auth::id(),
            $request->comment,
            $request->rating,
            $request->recommendation,
            $request->criteria_ratings ?? [],
            $request->confidential_comments,
            true // Always finalize
        );

        if ($result) {
            // Get the author User model safely
            $author = null;
            
            // Try to get the User model through relationship or direct lookup
            if ($journal->user_id) {
                $author = User::find($journal->user_id);
            }
            
            $reviewer = Auth::user();

            // Send notifications only if we have a valid User object
            try {
                if ($author && $author instanceof User && $author->email) {
                    $author->notify(new ReviewSubmittedNotification(
                        $journal,
                        $reviewer,
                        $request->rating,
                        $request->recommendation
                    ));
                } else {
                    Log::warning('Could not send review notification: Invalid author object', [
                        'journal_id' => $journal->id,
                        'user_id' => $journal->user_id,
                        'author_type' => gettype($journal->author ?? 'null')
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send review notification: ' . $e->getMessage());
            }

            $notification = [
                'message' => 'Review submitted successfully and author has been notified',
                'alert-type' => 'success'
            ];

            return redirect()->route('reviewer.dashboard')->with($notification);
        }

        $notification = [
            'message' => 'Error submitting review',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Upload revised manuscript version (for Authors)
     */
    public function uploadRevision(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'revision_file' => 'required|mimes:pdf|max:10000',
            'revision_notes' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $result = $this->repo->uploadRevision(
            $request->journal_uuid,
            $request->file('revision_file'),
            $request->revision_notes,
            Auth::id()
        );

        if ($result) {
            $notification = [
                'message' => 'Revised manuscript uploaded successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error uploading revised manuscript',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show version history for a manuscript
     */
    public function versionHistory($uuid)
    {
        $journal = $this->repo->findByUUID($uuid);

        if (!$journal) {
            abort(404, 'Manuscript not found');
        }

        // Check access permissions
        if (!$this->canAccessManuscript($journal)) {
            abort(403, 'Unauthorized access');
        }

        $versionHistory = $this->repo->getVersionHistory($uuid);

        return view('dashboard.shared.version-history', compact('journal', 'versionHistory'));
    }

    /**
     * Compare two versions of a manuscript
     */
    public function compareVersions(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'version1' => 'required|integer|exists:manuscript_versions,id',
            'version2' => 'required|integer|exists:manuscript_versions,id|different:version1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $journal = $this->repo->findByUUID($uuid);

        if (!$journal) {
            abort(404, 'Manuscript not found');
        }

        // Check access permissions
        if (!$this->canAccessManuscript($journal)) {
            abort(403, 'Unauthorized access');
        }

        $comparison = $this->repo->compareVersions($uuid, $request->version1, $request->version2);

        return view('dashboard.shared.version-comparison', compact('journal', 'comparison'));
    }

    /**
     * Show detailed view of a specific version
     */
    public function showVersion($uuid, $versionId)
    {
        $journal = $this->repo->findByUUID($uuid);

        if (!$journal) {
            abort(404, 'Manuscript not found');
        }

        // Check access permissions
        if (!$this->canAccessManuscript($journal)) {
            abort(403, 'Unauthorized access');
        }

        $versionDetails = $this->repo->getVersionDetails($versionId);

        // Verify this version belongs to the journal
        if ($versionDetails['journal']['uuid'] !== $uuid) {
            abort(404, 'Version not found for this manuscript');
        }

        return view('dashboard.shared.version-details', compact('journal', 'versionDetails'));
    }

    /**
     * Revert manuscript to a previous version
     */
    public function revertToVersion(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'version_id' => 'required|integer|exists:manuscript_versions,id',
            'confirm' => 'required|accepted'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $journal = $this->repo->findByUUID($uuid);

        if (!$journal) {
            abort(404, 'Manuscript not found');
        }

        // Check if user can revert (typically only authors and senior editors)
        if (!Auth::user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) &&
            $journal->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to revert this manuscript');
        }

        try {
            $newVersion = $this->repo->revertToVersion($uuid, $request->version_id, Auth::id());

            $notification = [
                'message' => 'Manuscript successfully reverted to previous version',
                'alert-type' => 'success'
            ];

            return redirect()->route(
                Auth::user()->hasAnyRole(['Editor in Chief', 'Managing Editor'])
                    ? 'editor.journals.preview'
                    : 'user.manuscripts.versions',
                [$uuid, $journal->slug ?? 'manuscript']
            )->with($notification);

        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error reverting manuscript: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Helper method to check if user can access manuscript
     */
    private function canAccessManuscript($journal)
    {
        $user = Auth::user();

        // Authors can access their own manuscripts
        if ($journal->user_id === $user->id) {
            return true;
        }

        // Editors can access manuscripts
        if ($user->hasAnyRole(['Editor in Chief', 'Managing Editor', 'Associate Editor'])) {
            return true;
        }

        // Reviewers can access assigned manuscripts
        if ($journal->reviewers()->where('user_id', $user->id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Show the review policy document
     */
    public function showReviewPolicy()
    {
        return view('policies.review-policy');
    }

    /**
     * Accept the review policy
     */
    public function acceptReviewPolicy(Request $request)
    {
        try {
            $user = Auth::user();

            $user->update([
                'review_policy_accepted' => true,
                'review_policy_accepted_at' => now(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Review policy accepted successfully'
                ]);
            }

            $notification = array(
                'message' => 'Review policy accepted successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error accepting review policy: ' . $e->getMessage()
                ], 500);
            }

            $notification = array(
                'message' => 'Error accepting review policy: ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Decline the review policy
     */
    public function declineReviewPolicy(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'You must accept the review policy to submit manuscripts'
            ]);
        }

        $notification = array(
            'message' => 'You must accept the review policy to submit manuscripts',
            'alert-type' => 'warning'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Get rejected journals for current reviewer (Associate Editor)
     */
    public function reviewerRejectedJournals()
    {
        // Use reviewer-specific method that filters by assigned manuscripts only
        $journals = $this->repo->getDeclinedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showRejectedJournals', compact('journals'));
    }

    /**
     * Get in-progress journals for current reviewer (Associate Editor)
     */
    public function reviewerInProgressJournals()
    {
        // Use reviewer-specific method that filters by assigned manuscripts only
        $journals = $this->repo->getInProgressJournalsForReviewer();
        return view('dashboard.reviewer.journals.showInProgressJournals', compact('journals'));
    }

    /**
     * Get reviewed journals for current reviewer (Associate Editor)
     */
    public function reviewerReviewedJournals()
    {
        // Use reviewer-specific method that filters by assigned manuscripts only
        $journals = $this->repo->getReviewedJournalsForReviewer();
        return view('dashboard.reviewer.journals.showReviewedJournals', compact('journals'));
    }

    /**
     * Get manuscripts ready for Managing Editor notice (JAPR Workflow)
     */
    public function readyForNotice()
    {
        $journals = $this->repo->getJournalsReadyForNotice();
        return view('dashboard.editor.journals.showReadyForNotice', compact('journals'));
    }

    /**
     * Send approval notice (Managing Editor)
     */
    public function sendApprovalNotice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'comment' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $journal = $this->repo->sendApprovalNotice($request->journal_uuid, $request->comment);

            if ($journal) {
                $notification = [
                    'message' => 'Approval notice sent successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error sending approval notice',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Send decline notice (Managing Editor)
     */
    public function sendDeclineNotice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_uuid' => 'required',
            'reason' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $journal = $this->repo->sendDeclineNotice($request->journal_uuid, $request->reason);

            if ($journal) {
                $notification = [
                    'message' => 'Decline notice sent successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $notification = [
            'message' => 'Error sending decline notice',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }
}
