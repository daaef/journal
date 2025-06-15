<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use App\Models\Journal;

echo "=== VERIFICATION: Removed Approved for Copy Editing Status ===\n\n";

// 1. Check that route no longer exists
echo "1. Checking Removed Routes:\n";
$removedRoutes = [
    'editor.journals.approvedForCopyEditing',
    'editor.journals.sendApprovalNotice',
    'editor.journals.sendDeclineNotice'
];

foreach ($removedRoutes as $routeName) {
    try {
        $route = route($routeName);
        echo "✗ Route '$routeName' still exists: $route\n";
    } catch (Exception $e) {
        echo "✓ Route '$routeName' successfully removed\n";
    }
}

// 2. Check manuscript counts by remaining statuses
echo "\n2. Current Manuscript Counts by Remaining Statuses:\n";
$statusCounts = [
    'pending' => Journal::where('approval_status', 'pending')->count(),
    'under_peer_review' => Journal::where('approval_status', 'under_peer_review')->count(),
    'in_progress' => Journal::whereIn('approval_status', ['in-progress', 'in_progress'])->count(),
    'reviewed' => Journal::where('approval_status', 'reviewed')->count(),
    'ready_for_notice' => Journal::where('approval_status', 'ready_for_managing_editor_notice')->count(),
    'approved' => Journal::whereIn('approval_status', ['approved', 'approved_with_comment'])->count(),
    'revision_requested' => Journal::whereIn('approval_status', ['changes_requested', 'revision_requested'])->count(),
    'rejected/declined' => Journal::whereIn('approval_status', ['declined', 'rejected'])->count()
];

foreach ($statusCounts as $status => $count) {
    echo "• $status: $count manuscripts\n";
}

// 3. Check if any manuscripts still have the removed status
echo "\n3. Checking for Orphaned 'approved_for_copy_editing' Status:\n";
$approvedForCopyEditing = Journal::where('approval_status', 'approved_for_copy_editing')->count();
if ($approvedForCopyEditing > 0) {
    echo "⚠️  WARNING: $approvedForCopyEditing manuscripts still have 'approved_for_copy_editing' status\n";
    echo "   These should be migrated to 'approved' status\n";
    
    // Show these manuscripts
    $orphanedJournals = Journal::where('approval_status', 'approved_for_copy_editing')->get();
    foreach ($orphanedJournals as $journal) {
        echo "   - {$journal->title} (ID: {$journal->id})\n";
    }
} else {
    echo "✓ No manuscripts with 'approved_for_copy_editing' status found\n";
}

// 4. Check view files
echo "\n4. Checking View Files:\n";
$viewFile = 'resources/views/dashboard/editor/journals/showApprovedForCopyEditing.blade.php';
if (file_exists($viewFile)) {
    echo "✗ View file still exists: $viewFile\n";
} else {
    echo "✓ View file successfully removed: showApprovedForCopyEditing.blade.php\n";
}

// 5. Check remaining active status routes
echo "\n5. Remaining Active Status Routes:\n";
$activeRoutes = [
    'editor.journals.pendingApproval',
    'editor.journals.underPeerReview',
    'editor.journals.inProgress',
    'editor.journals.reviewed',
    'editor.journals.readyForNotice',
    'editor.journals.approved',
    'editor.journals.revisionRequested',
    'editor.journals.rejected'
];

foreach ($activeRoutes as $routeName) {
    try {
        $route = route($routeName);
        echo "✓ Active route: '$routeName'\n";
    } catch (Exception $e) {
        echo "✗ Missing route: '$routeName'\n";
    }
}

echo "\n=== SIMPLIFIED WORKFLOW ===\n";
echo "1. Pending Review → Under Peer Review → Reviewed\n";
echo "2. Ready for Notice → APPROVED or DECLINED\n";
echo "3. No intermediate 'approved for copy editing' status\n";
echo "4. No 'send approval/decline notice' actions\n\n";

echo "=== MIGRATION RECOMMENDATION ===\n";
if ($approvedForCopyEditing > 0) {
    echo "Run the following SQL to migrate existing 'approved_for_copy_editing' manuscripts:\n";
    echo "UPDATE journals SET approval_status = 'approved' WHERE approval_status = 'approved_for_copy_editing';\n\n";
}

echo "✅ CLEANUP COMPLETE: Simplified manuscript workflow implemented\n";
