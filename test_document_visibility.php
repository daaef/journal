<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;
use App\Models\User;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Document Visibility After Approval Notice ===\n\n";

try {
    // Find a journal that's ready for managing editor notice
    $journal = Journal::where('approval_status', 'ready_for_managing_editor_notice')->first();
    
    if (!$journal) {
        // Find any journal and set it to the correct status for testing
        $journal = Journal::first();
        if ($journal) {
            $journal->approval_status = 'ready_for_managing_editor_notice';
            $journal->save();
            echo "Set journal '{$journal->title}' to ready_for_managing_editor_notice status for testing.\n\n";
        } else {
            echo "No journals found in the system.\n";
            exit;
        }
    }

    echo "Testing with Journal: {$journal->title}\n";
    echo "Author: {$journal->author}\n";
    echo "Current Status: {$journal->approval_status}\n";
    echo "Status Label: " . $journal->getStatusLabelAttribute() . "\n\n";

    // Get the author user
    $authorUser = User::find($journal->user_id);
    if (!$authorUser) {
        echo "Author user not found.\n";
        exit;
    }

    echo "Author User: {$authorUser->fullname} ({$authorUser->email})\n\n";

    // Test the user submissions view BEFORE approval
    $repo = new EloquentJournalRepository();
    $submissionsBefore = $repo->getUserSubmissionsWithDetails($journal->user_id);
    $journalInSubmissionsBefore = $submissionsBefore->where('id', $journal->id)->first();
    
    echo "=== BEFORE APPROVAL NOTICE ===\n";
    echo "Journal visible in user submissions: " . ($journalInSubmissionsBefore ? 'YES' : 'NO') . "\n";
    if ($journalInSubmissionsBefore) {
        echo "Status: {$journalInSubmissionsBefore->approval_status}\n";
        echo "Status Label: " . $journalInSubmissionsBefore->getStatusLabelAttribute() . "\n";
    }

    // Find a managing editor to simulate the approval
    $managingEditor = User::whereHas('roles', function($q) {
        $q->where('name', 'Managing Editor');
    })->first();

    if (!$managingEditor) {
        echo "No Managing Editor found. Cannot simulate approval.\n";
        exit;
    }

    // Simulate login as managing editor
    Auth::login($managingEditor);
    
    echo "\n=== SENDING APPROVAL NOTICE ===\n";
    echo "Sending approval notice as: {$managingEditor->fullname}\n";

    // Send approval notice
    $result = $repo->sendApprovalNotice($journal->uuid, 'Manuscript approved for publication after peer review.');
    
    echo "Approval notice sent successfully!\n";
    echo "New Status: {$result->approval_status}\n";
    echo "New Status Label: " . $result->getStatusLabelAttribute() . "\n\n";

    // Test the user submissions view AFTER approval
    $submissionsAfter = $repo->getUserSubmissionsWithDetails($journal->user_id);
    $journalInSubmissionsAfter = $submissionsAfter->where('id', $journal->id)->first();
    
    echo "=== AFTER APPROVAL NOTICE ===\n";
    echo "Journal visible in user submissions: " . ($journalInSubmissionsAfter ? 'YES' : 'NO') . "\n";
    if ($journalInSubmissionsAfter) {
        echo "Status: {$journalInSubmissionsAfter->approval_status}\n";
        echo "Status Label: " . $journalInSubmissionsAfter->getStatusLabelAttribute() . "\n";
        echo "Managing Editor Notice: " . (isset($journalInSubmissionsAfter->managing_editor_notice) ? 'Present' : 'Not set') . "\n";
    }

    echo "\n=== TOTAL USER SUBMISSIONS ===\n";
    echo "Total submissions for this author: " . $submissionsAfter->count() . "\n";
    
    foreach ($submissionsAfter as $submission) {
        echo "- {$submission->title} (Status: {$submission->approval_status} - {$submission->getStatusLabelAttribute()})\n";
    }

} catch (Exception $e) {
    echo "Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
