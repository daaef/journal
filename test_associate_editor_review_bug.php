<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Associate Editor Review Bug Investigation ===\n\n";

// Find an Associate Editor
$associateEditor = User::whereHas('roles', function($query) {
    $query->where('name', 'Associate Editor');
})->first();

if (!$associateEditor) {
    echo "❌ No Associate Editor found in database\n";
    exit;
}

echo "✅ Found Associate Editor: {$associateEditor->fullname} (ID: {$associateEditor->id})\n";

// Find a journal that this Associate Editor can review
$journal = Journal::whereHas('reviewerAssignments', function($query) use ($associateEditor) {
    $query->where('user_id', $associateEditor->id);
})->first();

if (!$journal) {
    echo "❌ No journal assigned to this Associate Editor\n";
    exit;
}

echo "✅ Found assigned journal: {$journal->title} (UUID: {$journal->uuid})\n";

// Check current reviewer assignment status
$reviewerAssignment = Reviewer::where('journal_id', $journal->id)
    ->where('user_id', $associateEditor->id)
    ->first();

if (!$reviewerAssignment) {
    echo "❌ No reviewer assignment record found\n";
    exit;
}

echo "✅ Found reviewer assignment record:\n";
echo "   - Status: {$reviewerAssignment->status}\n";
echo "   - Review submitted at: " . ($reviewerAssignment->review_submitted_at ? $reviewerAssignment->review_submitted_at : 'NULL') . "\n";
echo "   - Comment: " . ($reviewerAssignment->comment ? 'Present' : 'NULL') . "\n";
echo "   - Rating: " . ($reviewerAssignment->rating ? $reviewerAssignment->rating : 'NULL') . "\n";
echo "   - Recommendation: " . ($reviewerAssignment->recommendation ? $reviewerAssignment->recommendation : 'NULL') . "\n";
echo "   - Criteria ratings: " . ($reviewerAssignment->criteria_ratings ? json_encode($reviewerAssignment->criteria_ratings) : 'NULL') . "\n";
echo "   - Confidential comments: " . ($reviewerAssignment->confidential_comments ? 'Present' : 'NULL') . "\n";

// Simulate the controller logic
echo "\n=== Controller Logic Test ===\n";

// Test showEnhancedReviewForm logic
echo "Testing showEnhancedReviewForm logic:\n";
$existingReview = $journal->reviewerAssignments()
    ->where('user_id', $associateEditor->id)
    ->first();

if ($existingReview) {
    echo "✅ Found existing review record\n";
    echo "   - Has review_submitted_at: " . ($existingReview->review_submitted_at ? 'YES' : 'NO') . "\n";
    
    if ($existingReview->review_submitted_at) {
        echo "   - Form should be DISABLED (already submitted)\n";
    } else {
        echo "   - Form should be ENABLED (not yet submitted)\n";
    }
} else {
    echo "❌ No existing review record found\n";
}

// Test submitReview logic
echo "\nTesting submitReview logic:\n";
$existingSubmittedReview = $journal->reviewerAssignments()
    ->where('user_id', $associateEditor->id)
    ->whereNotNull('review_submitted_at')
    ->first();

if ($existingSubmittedReview) {
    echo "❌ Would block submission - review already submitted\n";
} else {
    echo "✅ Would allow submission - no submitted review found\n";
}

echo "\n=== Analysis ===\n";

if ($reviewerAssignment->review_submitted_at) {
    echo "🔍 This Associate Editor HAS already submitted a review.\n";
    echo "   The form should be disabled and submission should be blocked.\n";
    echo "   This is expected behavior.\n";
} else {
    echo "🔍 This Associate Editor has NOT submitted a review yet.\n";
    echo "   The form should be enabled and submission should be allowed.\n";
    
    if ($reviewerAssignment->comment || $reviewerAssignment->rating) {
        echo "   ⚠️  However, there is partial review data (draft).\n";
        echo "   This might be causing confusion in the UI.\n";
    }
}

echo "\n=== Recommendations ===\n";
echo "1. Check if the review form is properly checking 'review_submitted_at' field\n";
echo "2. Ensure the form only disables when review_submitted_at is NOT NULL\n";
echo "3. Verify that the submit button respects the same logic\n";

?>
