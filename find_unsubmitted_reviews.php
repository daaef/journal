<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Finding Associate Editors with Unsubmitted Reviews ===\n\n";

// Find all Associate Editors
$associateEditors = User::whereHas('roles', function($query) {
    $query->where('name', 'Associate Editor');
})->get();

echo "Found " . $associateEditors->count() . " Associate Editors\n\n";

foreach ($associateEditors as $editor) {
    echo "Associate Editor: {$editor->fullname} (ID: {$editor->id})\n";
    
    // Find reviewer assignments for this editor
    $assignments = Reviewer::where('user_id', $editor->id)->get();
    
    if ($assignments->isEmpty()) {
        echo "  ❌ No journal assignments\n\n";
        continue;
    }
    
    foreach ($assignments as $assignment) {
        $journal = Journal::find($assignment->journal_id);
        echo "  📖 Journal: " . ($journal ? $journal->title : 'Unknown') . "\n";
        echo "     - Status: {$assignment->status}\n";
        echo "     - Review submitted: " . ($assignment->review_submitted_at ? 'YES' : 'NO') . "\n";
        
        if (!$assignment->review_submitted_at) {
            echo "     ✅ CAN SUBMIT REVIEW (not yet submitted)\n";
            echo "     - Journal UUID: " . ($journal ? $journal->uuid : 'Unknown') . "\n";
        }
        echo "\n";
    }
}

echo "=== Checking Form Logic with Actual Data ===\n";

// Find a specific case where review is not submitted
$unsubmittedAssignment = Reviewer::whereNull('review_submitted_at')->first();

if ($unsubmittedAssignment) {
    echo "Found unsubmitted assignment:\n";
    echo "  User ID: {$unsubmittedAssignment->user_id}\n";
    echo "  Journal ID: {$unsubmittedAssignment->journal_id}\n";
    echo "  Status: {$unsubmittedAssignment->status}\n";
    
    $journal = Journal::find($unsubmittedAssignment->journal_id);
    $user = User::find($unsubmittedAssignment->user_id);
    
    if ($journal && $user) {
        echo "  Journal: {$journal->title}\n";
        echo "  User: {$user->fullname}\n";
        echo "  User roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
        
        // Test the form logic
        $existingReview = $journal->reviewerAssignments()
            ->where('user_id', $user->id)
            ->first();
            
        if ($existingReview) {
            echo "  Form would be " . ($existingReview->review_submitted_at ? 'DISABLED' : 'ENABLED') . "\n";
        }
    }
} else {
    echo "No unsubmitted assignments found.\n";
}

?>
