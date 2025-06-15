<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;
use App\Models\Reviewer;
use App\Models\User;

echo "=== Testing Comment Visibility and File Upload Features ===\n\n";

try {
    // Find a journal with submitted reviews
    $journal = Journal::with(['reviewers' => function($query) {
        $query->whereNotNull('review_submitted_at');
    }])->whereHas('reviewers', function($query) {
        $query->whereNotNull('review_submitted_at');
    })->first();

    if (!$journal) {
        echo "No journal found with submitted reviews. Creating test data...\n";
        
        // Find any journal and simulate a review
        $journal = Journal::first();
        if (!$journal) {
            echo "No journals found in the system.\n";
            exit;
        }
    }

    echo "Testing with Journal: {$journal->title}\n";
    echo "Journal Status: " . $journal->getStatusLabelAttribute() . "\n";
    echo "Author: {$journal->author}\n\n";

    // Check submitted reviews
    $submittedReviews = $journal->reviewers()->whereNotNull('review_submitted_at')->get();
    echo "=== Submitted Reviews ===\n";
    echo "Number of submitted reviews: " . $submittedReviews->count() . "\n\n";

    if ($submittedReviews->count() > 0) {
        foreach ($submittedReviews as $index => $review) {
            echo "Review " . ($index + 1) . ":\n";
            echo "  Reviewer: " . ($review->user->name ?? 'Unknown') . "\n";
            echo "  Role: {$review->role}\n";
            echo "  Rating: " . ($review->rating ?? 'N/A') . "\n";
            echo "  Recommendation: " . ($review->recommendation ?? 'N/A') . "\n";
            echo "  Comments for Author: " . (strlen($review->comment ?? '') > 0 ? 'Present (' . strlen($review->comment) . ' chars)' : 'Empty') . "\n";
            echo "  Confidential Comments: " . (strlen($review->confidential_comments ?? '') > 0 ? 'Present (' . strlen($review->confidential_comments) . ' chars)' : 'Empty') . "\n";
            echo "  Submitted At: " . ($review->review_submitted_at ? $review->review_submitted_at->format('M j, Y g:i A') : 'Not set') . "\n";
            
            // Check criteria ratings
            if ($review->criteria_ratings) {
                $criteria = is_string($review->criteria_ratings) ? json_decode($review->criteria_ratings, true) : $review->criteria_ratings;
                if ($criteria && is_array($criteria)) {
                    echo "  Criteria Ratings:\n";
                    foreach ($criteria as $criterion => $rating) {
                        echo "    " . ucfirst(str_replace('_', ' ', $criterion)) . ": {$rating}\n";
                    }
                }
            }
            echo "\n";
        }
    }

    // Test role-based access for confidential comments
    echo "=== Role-Based Access Test ===\n";
    $testUsers = [
        ['email' => 'author@example.com', 'role' => 'Author'],
        ['email' => 'editor@example.com', 'role' => 'Associate Editor'], 
        ['email' => 'managing@example.com', 'role' => 'Managing Editor'],
        ['email' => 'chief@example.com', 'role' => 'Editor in Chief']
    ];

    foreach ($testUsers as $testUser) {
        $user = User::where('email', $testUser['email'])->first();
        if ($user) {
            $canViewConfidential = $user->hasAnyRole(['Managing Editor', 'Editor in Chief', 'Super Admin']);
            echo "User: {$testUser['email']} (Role: {$testUser['role']})\n";
            echo "  Can view confidential comments: " . ($canViewConfidential ? 'YES' : 'NO') . "\n";
            echo "  Can view author comments: YES\n\n";
        }
    }

} catch (Exception $e) {
    echo "Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "=== Test Complete ===\n";
