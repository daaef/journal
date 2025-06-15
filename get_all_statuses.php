<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Journal;

echo "=== All Manuscript Statuses in System ===\n\n";

// Get all unique approval statuses
$statuses = Journal::select('approval_status')
    ->distinct()
    ->whereNotNull('approval_status')
    ->pluck('approval_status')
    ->toArray();

echo "Current statuses found in database:\n";
foreach ($statuses as $status) {
    $count = Journal::where('approval_status', $status)->count();
    $sampleJournal = Journal::where('approval_status', $status)->first();
    $label = $sampleJournal ? $sampleJournal->getStatusLabelAttribute() : 'Unknown';
    echo "- {$status} ({$count} manuscripts) - Label: \"{$label}\"\n";
}

echo "\n=== All Possible Statuses (from Model) ===\n";
$allPossibleStatuses = [
    'pending' => 'Pending Review',
    'in-progress' => 'In Progress', 
    'in_progress' => 'In Progress',
    'under_peer_review' => 'Under Peer Review',
    'reviewed' => 'Reviewed',
    'ready_for_managing_editor_notice' => 'Ready for Managing Editor Review',
    'approved' => 'Approved',
    'approved_with_comment' => 'Approved with Comments',
    'approved_for_copy_editing' => 'Approved for Copy Editing',
    'declined' => 'Declined',
    'rejected' => 'Rejected',
    'changes_requested' => 'Changes Requested',
    'revision_requested' => 'Revision Requested',
    'awaiting_editor_decision' => 'Awaiting Editor Decision',
    'editor_approved' => 'Editor Approved',
    'editor_declined' => 'Editor Declined',
];

foreach ($allPossibleStatuses as $status => $label) {
    $count = Journal::where('approval_status', $status)->count();
    $exists = in_array($status, $statuses) ? '✓' : '✗';
    echo "{$exists} {$status} - \"{$label}\" ({$count} manuscripts)\n";
}

echo "\n=== Recommendations for Sidebar ===\n";
echo "Main status categories that should have sidebar links:\n";
echo "1. Pending Review (pending)\n";
echo "2. Under Peer Review (under_peer_review, in-progress, in_progress)\n"; 
echo "3. Reviewed (reviewed)\n";
echo "4. Ready for Notice (ready_for_managing_editor_notice)\n";
echo "5. Approved (approved, approved_with_comment)\n";
echo "6. Approved for Copy Editing (approved_for_copy_editing)\n";
echo "7. Declined/Rejected (declined, rejected)\n";
echo "8. Revision Requested (changes_requested, revision_requested)\n";

echo "\n=== Test Complete ===\n";
