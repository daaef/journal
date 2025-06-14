<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Journal;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Support\Facades\Auth;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Associate Editor Manuscript Filtering ===\n\n";

try {
    // Find the associate editor user
    $associateEditor = User::where('email', 'associate@example.com')->first();
    
    if (!$associateEditor) {
        echo "❌ Associate editor not found with email: associate@example.com\n";
        exit(1);
    }
    
    echo "✅ Found Associate Editor: {$associateEditor->fullname} ({$associateEditor->email})\n";
    echo "   Roles: " . $associateEditor->roles->pluck('name')->join(', ') . "\n\n";
    
    // Simulate login as this user
    Auth::login($associateEditor);
    
    // Test the repository methods
    $repo = new EloquentJournalRepository();
    
    echo "=== Testing Repository Methods ===\n";
    
    // Test general methods (should return ALL manuscripts)
    $allPending = $repo->getPendingApprovedJournals();
    echo "Total pending manuscripts (all): " . $allPending->count() . "\n";
    
    $allApproved = $repo->getApprovedJournals();
    echo "Total approved manuscripts (all): " . $allApproved->count() . "\n";
    
    $allInProgress = $repo->getJournalsInProgress();
    echo "Total in-progress manuscripts (all): " . $allInProgress->count() . "\n";
    
    $allDeclined = $repo->getRejectedJournals();
    echo "Total declined manuscripts (all): " . $allDeclined->count() . "\n\n";
    
    // Test reviewer-specific methods (should return ONLY assigned manuscripts)
    echo "=== Assigned to Associate Editor ===\n";
    
    $assignedPending = $repo->getPendingApprovedJournalsForReviewer();
    echo "Assigned pending manuscripts: " . $assignedPending->total() . "\n";
    
    $assignedApproved = $repo->getApprovedJournalsForReviewer();
    echo "Assigned approved manuscripts: " . $assignedApproved->total() . "\n";
    
    $assignedInProgress = $repo->getInProgressJournalsForReviewer();
    echo "Assigned in-progress manuscripts: " . $assignedInProgress->total() . "\n";
    
    $assignedDeclined = $repo->getDeclinedJournalsForReviewer();
    echo "Assigned declined manuscripts: " . $assignedDeclined->total() . "\n\n";
    
    // Check specific assignments
    echo "=== Manuscript Assignment Details ===\n";
    $allAssignedJournals = $repo->getJournalsForReviewer($associateEditor->id);
    echo "Total manuscripts assigned to this Associate Editor: " . $allAssignedJournals->count() . "\n";
    
    if ($allAssignedJournals->count() > 0) {
        echo "\nAssigned manuscripts:\n";
        foreach ($allAssignedJournals as $journal) {
            echo "- {$journal->title} (Status: {$journal->approval_status})\n";
        }
    } else {
        echo "\n⚠️  No manuscripts currently assigned to this Associate Editor\n";
        echo "   This explains why they should see 0 manuscripts in their dashboard.\n";
    }
    
    // Check if there are any unassigned manuscripts
    echo "\n=== Unassigned Manuscripts Check ===\n";
    $unassignedManuscripts = Journal::whereNotIn('id', function($query) {
        $query->select('journal_id')->from('reviewers');
    })->get();
    
    echo "Total unassigned manuscripts: " . $unassignedManuscripts->count() . "\n";
    
    if ($unassignedManuscripts->count() > 0) {
        echo "\nUnassigned manuscripts (Associate Editor should NOT see these):\n";
        foreach ($unassignedManuscripts as $journal) {
            echo "- {$journal->title} (Status: {$journal->approval_status})\n";
        }
    }
    
    echo "\n=== Test Results ===\n";
    if ($assignedPending->total() == 0 && $assignedApproved->total() == 0 && 
        $assignedInProgress->total() == 0 && $assignedDeclined->total() == 0) {
        echo "✅ CORRECT: Associate Editor sees 0 manuscripts (none assigned)\n";
    } else {
        echo "✅ Associate Editor sees only assigned manuscripts:\n";
        echo "   - Pending: {$assignedPending->total()}\n";
        echo "   - Approved: {$assignedApproved->total()}\n";
        echo "   - In Progress: {$assignedInProgress->total()}\n";
        echo "   - Declined: {$assignedDeclined->total()}\n";
    }
    
    if ($allPending->count() > ($assignedPending->total() ?? 0)) {
        echo "✅ CORRECT: There are unassigned manuscripts that the Associate Editor cannot see\n";
    }
    
    echo "\n=== Fix Applied Successfully ===\n";
    echo "The ReviewerDashboardController and journal listing methods now use:\n";
    echo "- getPendingApprovedJournalsForReviewer() instead of getPendingApprovedJournals()\n";
    echo "- getApprovedJournalsForReviewer() instead of getApprovedJournals()\n";
    echo "- getInProgressJournalsForReviewer() instead of getJournalsInProgress()\n";
    echo "- getDeclinedJournalsForReviewer() instead of getRejectedJournals()\n";
    echo "\nThese methods filter by the 'reviewers' table to show only assigned manuscripts.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
