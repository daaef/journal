<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;
use App\Models\Reviewer;
use App\Models\User;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Support\Facades\Log;

echo "=== Testing Review Submission Fix ===\n\n";

try {
    // Find a journal that has an Associate Editor assigned for testing
    $journal = Journal::whereHas('reviewers', function($query) {
        $query->where('role', 'Associate Editor');
    })->first();

    if (!$journal) {
        echo "No journal found with Associate Editor assigned.\n";
        exit;
    }

    echo "Testing with Journal ID: {$journal->id}\n";
    echo "Journal Title: {$journal->title}\n";
    echo "Current Status: {$journal->approval_status}\n";

    // Find the Associate Editor reviewer for this journal
    $reviewer = $journal->reviewers()->where('role', 'Associate Editor')->first();
    
    if (!$reviewer) {
        echo "No Associate Editor found for this journal.\n";
        exit;
    }

    echo "Associate Editor: {$reviewer->user->name} (ID: {$reviewer->user_id})\n";
    echo "Review Submitted At: " . ($reviewer->review_submitted_at ? $reviewer->review_submitted_at : 'Not submitted') . "\n\n";    // Simulate review submission data exactly as the form sends it
    $reviewData = [
        'journal_uuid' => $journal->uuid, // Use UUID, not ID
        'comment' => 'This is a test comment for the author regarding their manuscript.',
        'confidential_comments' => 'This is a test comment for the editor regarding the review process.',
        'rating' => 4,
        'recommendation' => 'accept',
        'criteria_ratings' => [
            'scholarly_merit' => 4,
            'methodology' => 4, 
            'literature_review' => 3,
            'results' => 3,
            'implications' => 4
        ]
    ];

    echo "=== Attempting Review Submission ===\n";
    echo "Review Data:\n";
    foreach ($reviewData as $key => $value) {
        if (is_array($value)) {
            echo "  {$key}:\n";
            foreach ($value as $subKey => $subValue) {
                echo "    {$subKey}: {$subValue}\n";
            }
        } else {
            echo "  {$key}: {$value}\n";
        }
    }
    echo "\n";

    // Use the repository method that the controller uses
    $journalRepo = new EloquentJournalRepository();
    
    // Test the submitReview method
    $result = $journalRepo->submitReview(
        $reviewData['journal_uuid'],
        $reviewer->user_id, // reviewer user ID
        $reviewData['comment'],
        $reviewData['rating'],
        $reviewData['recommendation'],
        $reviewData['criteria_ratings'],
        $reviewData['confidential_comments'],
        true // finalize
    );

    echo "=== Review Submission Result ===\n";
    if ($result) {
        echo "✓ Review submission successful!\n";
        
        // Check the updated journal status
        $journal->refresh();
        echo "Updated Journal Status: {$journal->approval_status}\n";
        
        // Check the reviewer record
        $reviewer->refresh();
        echo "Reviewer submission timestamp: " . ($reviewer->review_submitted_at ? $reviewer->review_submitted_at : 'Not set') . "\n";
        echo "Reviewer comments for author: " . ($reviewer->comments_for_author ?? 'Not set') . "\n";
        echo "Reviewer comments for editor: " . ($reviewer->comments_for_editor ?? 'Not set') . "\n";
          // Check reviewer ratings
        echo "\nReviewer Ratings:\n";
        echo "  Scholarly Merit: " . ($reviewer->scholarly_merit_rating ?? 'Not set') . "\n";
        echo "  Literature Review: " . ($reviewer->literature_review_rating ?? 'Not set') . "\n";
        echo "  Methodology: " . ($reviewer->methodology_rating ?? 'Not set') . "\n";
        echo "  Results: " . ($reviewer->results_rating ?? 'Not set') . "\n";
        echo "  Implications: " . ($reviewer->implications_rating ?? 'Not set') . "\n";
        echo "  Overall Rating: " . ($reviewer->rating ?? 'Not set') . "\n";
        echo "  Overall Recommendation: " . ($reviewer->recommendation ?? 'Not set') . "\n";
        
    } else {
        echo "✗ Review submission failed!\n";
    }

} catch (Exception $e) {
    echo "Error during review submission test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
