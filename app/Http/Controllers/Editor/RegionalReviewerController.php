<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\User;
use App\Services\ExpertiseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionalReviewerController extends Controller
{
    protected $expertiseService;

    public function __construct(ExpertiseService $expertiseService)
    {
        $this->expertiseService = $expertiseService;
    }

    /**
     * Show regional reviewer assignment interface
     */
    public function showRegionalAssignment($journalUuid)
    {
        $journal = Journal::with(['category', 'author', 'reviewers.user'])->where('uuid', $journalUuid)->firstOrFail();
        
        // Get optimal reviewers based on regional expertise and research interests
        $optimalReviewers = $this->expertiseService->getOptimalReviewers($journal, 10);
        
        // Get all available Associate Editors
        $allReviewers = User::role('Associate Editor')
            ->where('available_for_review', true)
            ->orderBy('fullname')
            ->get();
        
        // Get already assigned reviewers
        $assignedReviewers = $journal->reviewers()->with('user')->get();
        
        // Get expertise categories for filtering
        $expertiseCategories = $this->expertiseService->getExpertiseCategories();
        
        // Get regional statistics
        $regionalStats = $this->expertiseService->getReviewerStatisticsByRegion();
        
        return view('dashboard.editor.journals.regional-assignment', compact(
            'journal',
            'optimalReviewers',
            'allReviewers',
            'assignedReviewers',
            'expertiseCategories',
            'regionalStats'
        ));
    }

    /**
     * Get reviewers by regional expertise
     */
    public function getReviewersByRegion(Request $request)
    {
        $journal = Journal::findOrFail($request->journal_id);
        $region = $request->region;
        
        $reviewers = User::role('Associate Editor')
            ->where('available_for_review', true)
            ->whereJsonContains('regional_expertise', $region)
            ->orderBy('average_rating', 'desc')
            ->orderBy('review_count', 'asc')
            ->get();
        
        return response()->json([
            'reviewers' => $reviewers,
            'count' => $reviewers->count()
        ]);
    }

    /**
     * Get reviewers by research interest
     */
    public function getReviewersByInterest(Request $request)
    {
        $journal = Journal::findOrFail($request->journal_id);
        $interest = $request->interest;
        
        $reviewers = User::role('Associate Editor')
            ->where('available_for_review', true)
            ->whereJsonContains('research_interests', $interest)
            ->orderBy('average_rating', 'desc')
            ->orderBy('review_count', 'asc')
            ->get();
        
        return response()->json([
            'reviewers' => $reviewers,
            'count' => $reviewers->count()
        ]);
    }

    /**
     * Assign reviewers with regional expertise consideration
     */
    public function assignRegionalReviewers(Request $request, $journalUuid)
    {
        $validator = Validator::make($request->all(), [
            'reviewers' => 'required|array|min:2|max:4',
            'reviewers.*' => 'required|string|exists:users,uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please select between 2-4 Associate Editors. ' . $validator->errors()->first()
            ], 422);
        }

        $journal = Journal::where('uuid', $journalUuid)->firstOrFail();
        
        // Check for minimum and maximum limits
        $reviewerCount = count($request->reviewers);
        if ($reviewerCount < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum of 2 Associate Editors required. Currently selected: ' . $reviewerCount
            ], 422);
        }

        if ($reviewerCount > 4) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum of 4 Associate Editors allowed. Currently selected: ' . $reviewerCount
            ], 422);
        }

        // Use the existing repository method
        $reviewerRepo = app(\App\Repositories\Reviewer\ReviewerContract::class);
        $result = $reviewerRepo->SaveJournalReviewers($request, $journalUuid);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Associate Editors assigned successfully (' . $reviewerCount . ' Associate Editor' . ($reviewerCount > 1 ? 's' : '') . ' assigned)',
                'journal_status' => $result->approval_status
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error assigning Associate Editors. Please try again.'
        ], 500);
    }

    /**
     * Get reviewer details for assignment
     */
    public function getReviewerDetails($reviewerUuid)
    {
        $reviewer = User::where('uuid', $reviewerUuid)
            ->with(['reviews'])
            ->firstOrFail();
        
        $performance = $reviewer->getReviewPerformance();
        
        return response()->json([
            'reviewer' => $reviewer,
            'performance' => $performance,
            'regional_expertise' => $reviewer->regional_expertise,
            'research_interests' => $reviewer->research_interests
        ]);
    }

    /**
     * Get optimal reviewer suggestions for a manuscript
     */
    public function getOptimalSuggestions($journalUuid)
    {
        $journal = Journal::with(['category', 'author'])->where('uuid', $journalUuid)->firstOrFail();
        
        $suggestions = $this->expertiseService->getOptimalReviewers($journal, 6);
        
        return response()->json([
            'suggestions' => $suggestions,
            'manuscript_country' => $journal->country,
            'manuscript_category' => $journal->category->name
        ]);
    }
} 