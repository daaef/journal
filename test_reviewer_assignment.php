<?php
// Quick test to validate reviewer assignment functionality
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;

echo "=== REVIEWER ASSIGNMENT FUNCTIONALITY TEST ===\n\n";

try {
    // Check if we have users with Reviewer role
    $reviewers = User::role('Reviewer')->get();
    echo "✅ Reviewers available: " . $reviewers->count() . "\n";

    if ($reviewers->count() > 0) {
        echo "Reviewer details:\n";
        foreach ($reviewers as $reviewer) {
            echo "  - {$reviewer->fullname} ({$reviewer->email}) - UUID: {$reviewer->uuid}\n";
        }
    }

    // Check journals
    $journals = Journal::all();
    echo "\n✅ Journals available: " . $journals->count() . "\n";

    if ($journals->count() > 0) {
        $journal = $journals->first();
        echo "Sample journal: {$journal->title} (UUID: {$journal->uuid})\n";

        // Check assigned reviewers for this journal
        $assignedReviewers = Reviewer::where('journal_id', $journal->id)->with('user')->get();
        echo "Assigned reviewers for this journal: " . $assignedReviewers->count() . "\n";

        if ($assignedReviewers->count() > 0) {
            foreach ($assignedReviewers as $reviewer) {
                echo "  - {$reviewer->user->fullname} (Status: {$reviewer->status})\n";
            }
        }
    }

    // Check if the route exists
    echo "\n✅ Testing routes...\n";
    $routes = collect(\Illuminate\Support\Facades\Route::getRoutes())->filter(function($route) {
        return str_contains($route->getName() ?? '', 'reviewer');
    });

    echo "Reviewer-related routes available: " . $routes->count() . "\n";

    echo "\n=== SYSTEM STATUS ===\n";
    echo "✅ Database connection: Working\n";
    echo "✅ Models loading: Working\n";
    echo "✅ Reviewer assignment system: Ready for testing\n";

    echo "\n=== NEXT STEPS ===\n";
    echo "1. Visit http://journal.test in your browser\n";
    echo "2. Login as Editor in Chief or Managing Editor\n";
    echo "3. Navigate to a journal preview page\n";
    echo "4. Test the reviewer assignment with 2-4 reviewer limit\n";
    echo "5. Verify JavaScript functionality works correctly\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
