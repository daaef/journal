<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;
use App\Models\User;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Updated Approval Workflow ===\n\n";

try {
    // Find a journal for testing
    $journal = Journal::first();
    if (!$journal) {
        echo "No journals found in the system.\n";
        exit;
    }

    // Set it to ready for managing editor notice
    $journal->approval_status = 'ready_for_managing_editor_notice';
    $journal->save();

    echo "Testing with Journal: {$journal->title}\n";
    echo "Current Status: {$journal->approval_status}\n\n";

    // Find a managing editor
    $managingEditor = User::whereHas('roles', function($q) {
        $q->where('name', 'Managing Editor');
    })->first();

    if (!$managingEditor) {
        echo "No Managing Editor found.\n";
        exit;
    }

    Auth::login($managingEditor);
    $repo = new EloquentJournalRepository();

    // Test 1: Approve for Publication (final approval)
    echo "=== TEST 1: Approve for Publication ===\n";
    $result1 = $repo->sendApprovalNotice(
        $journal->uuid, 
        'Manuscript is excellent and ready for immediate publication.',
        'approved'
    );
    
    echo "✅ Final Approval Sent!\n";
    echo "New Status: {$result1->approval_status}\n";
    echo "Status Label: " . $result1->getStatusLabelAttribute() . "\n";
    echo "Approved At: " . ($result1->approved_at ? $result1->approved_at->format('M j, Y g:i A') : 'Not set') . "\n";
    echo "Approved By: " . (isset($result1->approved_by['name']) ? $result1->approved_by['name'] : 'Not set') . "\n\n";    // Reset for Test 2 - get fresh instance
    $journal = Journal::find($journal->id);
    $journal->approval_status = 'ready_for_managing_editor_notice';
    $journal->approved_at = null;
    $journal->approved_by = null;
    $journal->managing_editor_notice = null;
    $journal->managing_editor_notice_sent_at = null;
    $journal->save();

    // Test 2: Approve for Copy Editing
    echo "=== TEST 2: Approve for Copy Editing ===\n";
    $result2 = $repo->sendApprovalNotice(
        $journal->uuid, 
        'Manuscript is good but needs some copy editing before publication.',
        'approved_for_copy_editing'
    );
    
    echo "✅ Copy Editing Approval Sent!\n";
    echo "New Status: {$result2->approval_status}\n";
    echo "Status Label: " . $result2->getStatusLabelAttribute() . "\n";
    echo "Approved At: " . ($result2->approved_at ? $result2->approved_at->format('M j, Y g:i A') : 'Not set') . "\n\n";

    echo "=== Managing Editor Notice Details ===\n";
    if (isset($result2->managing_editor_notice)) {
        $notice = $result2->managing_editor_notice;
        echo "Sent By: " . ($notice['sent_by']['name'] ?? 'Unknown') . "\n";
        echo "Decision: " . ($notice['decision'] ?? 'Not specified') . "\n";
        echo "Comment: " . ($notice['comment'] ?? 'No comment') . "\n";
        echo "Sent At: " . (isset($notice['sent_at']) ? \Carbon\Carbon::parse($notice['sent_at'])->format('M j, Y g:i A') : 'Not set') . "\n";
    }

} catch (Exception $e) {
    echo "Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
