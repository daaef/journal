<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;

echo "=== DEBUGGING ASSOCIATE EDITOR ISSUE ===\n\n";

// Check Associate Editor user
echo "1. Checking Associate Editor user...\n";
$user = User::where('email', 'associate@example.com')->first();
if ($user) {
    echo "✓ User found: {$user->fullname} (ID: {$user->id})\n";
    echo "✓ Email: {$user->email}\n";
    if ($user->roles) {
        echo "✓ Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    } else {
        echo "⚠ No roles found for user\n";
    }
} else {
    echo "✗ Associate Editor user NOT found!\n";
}
echo "\n";

// Check all users
echo "2. All users in system:\n";
$users = User::all();
echo "Total users: {$users->count()}\n";
foreach ($users as $u) {
    echo "- {$u->email} ({$u->fullname})\n";
}
echo "\n";

// Check journals
echo "3. Checking journals in system...\n";
$journals = Journal::all();
echo "Total journals: {$journals->count()}\n";
if ($journals->count() > 0) {
    foreach ($journals as $journal) {
        echo "- {$journal->title} (Status: {$journal->approval_status})\n";
    }
} else {
    echo "⚠ No journals found in system\n";
}
echo "\n";

// Check reviewer assignments
echo "4. Checking reviewer assignments...\n";
$reviewers = Reviewer::all();
echo "Total reviewer assignments: {$reviewers->count()}\n";
if ($reviewers->count() > 0) {
    foreach ($reviewers as $reviewer) {
        $assignedUser = User::find($reviewer->user_id);
        $assignedJournal = Journal::find($reviewer->journal_id);
        echo "- User: " . ($assignedUser ? $assignedUser->email : 'Unknown') . 
             " assigned to Journal: " . ($assignedJournal ? $assignedJournal->title : 'Unknown') . "\n";
    }
} else {
    echo "⚠ No reviewer assignments found\n";
}
echo "\n";

// If Associate Editor exists, check their specific assignments
if ($user) {
    echo "5. Checking specific assignments for Associate Editor...\n";
    $userReviewers = Reviewer::where('user_id', $user->id)->get();
    echo "Assignments for {$user->email}: {$userReviewers->count()}\n";
    
    if ($userReviewers->count() > 0) {
        foreach ($userReviewers as $assignment) {
            $journal = Journal::find($assignment->journal_id);
            echo "- Assigned to: " . ($journal ? $journal->title : 'Unknown Journal') . "\n";
        }
    } else {
        echo "⚠ No assignments found for Associate Editor\n";
    }
    echo "\n";
    
    // Test the repository method
    echo "6. Testing repository method...\n";
    try {
        $journalRepo = new App\Repositories\Journal\EloquentJournalRepository();
        $assignedJournals = $journalRepo->getJournalsForReviewer($user->id);
        echo "Journals returned by getJournalsForReviewer(): {$assignedJournals->count()}\n";
        
        if ($assignedJournals->count() > 0) {
            foreach ($assignedJournals as $journal) {
                echo "- {$journal->title}\n";
            }
        }
    } catch (Exception $e) {
        echo "✗ Error testing repository method: {$e->getMessage()}\n";
    }
}

echo "\n=== DEBUG COMPLETE ===\n";
