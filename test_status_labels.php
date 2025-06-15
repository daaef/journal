<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;

echo "🏷️  Testing Status Label Helper Methods\n";
echo "=====================================\n\n";

// Test different status values
$testStatuses = [
    'pending',
    'in-progress', 
    'approved',
    'declined',
    'reviewed',
    'under_peer_review',
    'ready_for_managing_editor_notice',
    'revision_requested',
    'changes_requested'
];

echo "📊 Testing status label mappings:\n";
foreach ($testStatuses as $status) {
    // Create a mock journal with the status
    $journal = new Journal();
    $journal->approval_status = $status;
    
    echo "   • {$status} → '{$journal->status_label}'\n";
    echo "     CSS class: {$journal->status_class}\n\n";
}

// Test with actual journal data
echo "🔍 Testing with actual journal data:\n";
$journals = Journal::take(5)->get();

if ($journals->count() > 0) {
    foreach ($journals as $journal) {
        echo "   • Journal: {$journal->title}\n";
        echo "     Status: {$journal->approval_status} → '{$journal->status_label}'\n";
        echo "     CSS: {$journal->status_class}\n\n";
    }
} else {
    echo "   No journals found in database\n";
}

// Test edge cases
echo "🧪 Testing edge cases:\n";
$edgeCases = ['unknown_status', '', null];

foreach ($edgeCases as $status) {
    $journal = new Journal();
    $journal->approval_status = $status;
    
    echo "   • '{$status}' → '{$journal->status_label}'\n";
    echo "     CSS class: {$journal->status_class}\n\n";
}

echo "✅ Status label testing completed!\n";
