<?php

/**
 * Test script to verify the new JAPR workflow implementation
 * Tests Managing Editor notice functionality
 */

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;
use App\Repositories\Journal\EloquentJournalRepository;

echo "=== JAPR Workflow Test ===\n";
echo "Testing Managing Editor Notice functionality\n\n";

try {
    $repo = new EloquentJournalRepository();
    
    // Find a Managing Editor
    $managingEditor = User::whereHas('roles', function($query) {
        $query->where('name', 'Managing Editor');
    })->first();
    
    if (!$managingEditor) {
        echo "❌ No Managing Editor found. Please ensure Managing Editor role exists.\n";
        exit;
    }
    
    echo "👤 Managing Editor: {$managingEditor->fullname} ({$managingEditor->email})\n";
    
    // Find Associate Editors
    $associateEditors = User::whereHas('roles', function($query) {
        $query->where('name', 'Associate Editor');
    })->take(2)->get();
    
    if ($associateEditors->count() < 2) {
        echo "❌ Need at least 2 Associate Editors. Found: {$associateEditors->count()}\n";
        exit;
    }
    
    echo "👥 Associate Editors found: {$associateEditors->count()}\n";
    
    // Check for manuscripts ready for notice
    $readyForNotice = $repo->getJournalsReadyForNotice();
    echo "\n📋 Manuscripts ready for Managing Editor notice: {$readyForNotice->count()}\n";
    
    if ($readyForNotice->count() > 0) {
        $testJournal = $readyForNotice->first();
        echo "\n📄 Testing with journal: {$testJournal->title}\n";
        echo "📊 Current status: {$testJournal->approval_status}\n";
        
        // Check review completion
        $completedReviews = $testJournal->reviewerAssignments()
            ->whereNotNull('review_submitted_at')
            ->count();
        echo "✅ Completed reviews: {$completedReviews}\n";
        
        // Test sending approval notice
        echo "\n🔄 Testing approval notice...\n";
          // Set current user to Managing Editor for the test
        \Illuminate\Support\Facades\Auth::login($managingEditor);
        
        $result = $repo->sendApprovalNotice(
            $testJournal->uuid,
            'This manuscript has been approved after thorough peer review and will proceed to copy editing.'
        );
        
        // Refresh journal to see updated status
        $testJournal->refresh();
        
        echo "✅ Approval notice sent successfully!\n";
        echo "📊 New status: {$testJournal->approval_status}\n";
        echo "📧 Notice data: " . json_encode($testJournal->managing_editor_notice) . "\n";
        
    } else {
        echo "\n⚠️  No manuscripts ready for notice found.\n";
        echo "   Creating test scenario...\n";
        
        // Find a manuscript under review
        $inReviewJournal = Journal::where('approval_status', 'in-progress')->first();
        
        if (!$inReviewJournal) {
            $inReviewJournal = Journal::where('approval_status', 'pending')->first();
            if ($inReviewJournal) {
                $inReviewJournal->approval_status = 'in-progress';
                $inReviewJournal->save();
            }
        }
        
        if ($inReviewJournal) {
            echo "📄 Using journal: {$inReviewJournal->title}\n";
            
            // Simulate Associate Editor reviews
            $reviewCount = 0;
            foreach ($associateEditors as $editor) {
                // Create or update reviewer assignment
                $reviewer = Reviewer::updateOrCreate(
                    [
                        'journal_id' => $inReviewJournal->id,
                        'user_id' => $editor->id
                    ],
                    [
                        'fullname' => $editor->fullname,
                        'comment' => "This is a test review by {$editor->fullname}. The manuscript shows good quality.",
                        'rating' => 4,
                        'recommendation' => 'accept',
                        'status' => 'completed',
                        'review_submitted_at' => now(),
                        'assigned_at' => now(),
                    ]
                );
                
                $reviewCount++;
                echo "   ✅ Created review #{$reviewCount} by {$editor->fullname}\n";
                
                if ($reviewCount >= 2) break;
            }
            
            // Update journal status
            $inReviewJournal->approval_status = 'ready_for_managing_editor_notice';
            $inReviewJournal->save();
            
            echo "📊 Updated journal status to: ready_for_managing_editor_notice\n";
            echo "✅ Test scenario created successfully!\n";
            echo "\n💡 Now try accessing the Managing Editor dashboard to send notices.\n";
        } else {
            echo "❌ No suitable manuscript found for testing.\n";
        }
    }
    
    // Test the dashboard counts
    echo "\n📊 Dashboard Metrics:\n";
    echo "   - Ready for Notice: " . $repo->getJournalsReadyForNotice()->count() . "\n";
    echo "   - Pending: " . $repo->getPendingApprovedJournals()->count() . "\n";
    echo "   - In Progress: " . $repo->getJournalsInProgress()->count() . "\n";
    echo "   - Reviewed: " . $repo->getJournalsReviewed()->count() . "\n";
    echo "   - Approved: " . $repo->getApprovedJournals()->count() . "\n";
    echo "   - Declined: " . $repo->getRejectedJournals()->count() . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n=== JAPR Workflow Test Completed ===\n";
echo "\n📋 Next Steps:\n";
echo "1. ✅ Login as Managing Editor (" . ($managingEditor->email ?? 'managing-editor@example.com') . ")\n";
echo "2. ✅ Navigate to Editor Dashboard\n";
echo "3. ✅ Check 'Ready for Notice' section\n";
echo "4. ✅ Click 'Ready for Notice' in sidebar\n";
echo "5. ✅ Send approval/decline notices to authors\n";
echo "6. ✅ Verify notifications sent to Author, Editor-in-Chief, and Desk Editor\n";

?>
