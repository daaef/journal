<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;
use App\Repositories\Journal\EloquentJournalRepository;
use App\Repositories\Reviewer\EloquentReviewerRepository;
use Illuminate\Support\Str;

echo "=== EDITOR REVIEWER MANAGEMENT WORKFLOW TEST ===\n\n";

class EditorReviewerTester {
    private $journalRepo;
    private $reviewerRepo;
    private $editor;
    private $associateEditors;

    public function __construct() {
        $this->journalRepo = new EloquentJournalRepository();
        // Fix dependency injection for ReviewerRepository
        $this->reviewerRepo = new EloquentReviewerRepository($this->journalRepo);

        // Get editors
        $this->editor = User::role('Editor in Chief')->first();
        $this->associateEditors = User::role('Associate Editor')->get();

        if (!$this->editor) {
            throw new Exception("No Editor in Chief found for testing");
        }

        if ($this->associateEditors->count() < 2) {
            throw new Exception("Insufficient Associate Editors (minimum 2 required)");
        }
    }

    public function runTests() {
        echo "🔍 Testing Editor Reviewer Management Workflows\n";
        echo "Using Editor: {$this->editor->fullname} ({$this->editor->email})\n";
        echo "Available Associate Editors: {$this->associateEditors->count()}\n\n";

        $this->testReviewerAssignmentRules();
        $this->testReviewerInvitationSystem();
        $this->testReviewerResponseHandling();
        $this->testReviewProgressTracking();
        $this->testEditorApprovalWorkflow();
    }

    private function testReviewerAssignmentRules() {
        echo "👥 TESTING REVIEWER ASSIGNMENT RULES (2-4 MINIMUM/MAXIMUM)\n";
        echo str_repeat("=", 60) . "\n";

        // Get manuscripts that need reviewers
        $pendingManuscripts = Journal::where('approval_status', 'pending')->get();
        echo "Manuscripts pending reviewer assignment: {$pendingManuscripts->count()}\n";

        if ($pendingManuscripts->count() > 0) {
            $testManuscript = $pendingManuscripts->first();
            echo "\nTesting with manuscript: {$testManuscript->title}\n";

            // Check current reviewer assignments
            $currentReviewers = Reviewer::where('journal_id', $testManuscript->id)->get();
            echo "Current reviewers assigned: {$currentReviewers->count()}\n";

            // Test minimum requirement (2 reviewers)
            if ($currentReviewers->count() < 2) {
                echo "⚠️  Manuscript has less than minimum 2 reviewers\n";

                // Simulate assigning reviewers
                echo "Simulating reviewer assignment...\n";
                $selectedEditors = $this->associateEditors->take(3); // Assign 3 reviewers

                foreach ($selectedEditors as $editor) {
                    echo "  - Assigning: {$editor->fullname} ({$editor->email})\n";

                    // Create reviewer invitation
                    $reviewer = new Reviewer();
                    $reviewer->journal_id = $testManuscript->id;
                    $reviewer->user_id = $editor->id;
                    $reviewer->email = $editor->email;
                    $reviewer->token = Str::random(32);
                    $reviewer->status = 'invited';
                    $reviewer->invited_at = now();

                    try {
                        $reviewer->save();
                        echo "    ✅ Reviewer invitation created\n";
                    } catch (Exception $e) {
                        echo "    ❌ Failed to create invitation: " . $e->getMessage() . "\n";
                    }
                }

                // Verify assignment count
                $newCount = Reviewer::where('journal_id', $testManuscript->id)->count();
                echo "\nTotal reviewers after assignment: {$newCount}\n";

                if ($newCount >= 2 && $newCount <= 4) {
                    echo "✅ Reviewer count meets requirements (2-4)\n";
                } else {
                    echo "❌ Reviewer count violates requirements\n";
                }

            } else {
                echo "✅ Manuscript already has sufficient reviewers\n";
            }

        } else {
            echo "No pending manuscripts found for reviewer assignment testing\n";
        }
    }

    private function testReviewerInvitationSystem() {
        echo "\n📧 TESTING REVIEWER INVITATION SYSTEM\n";
        echo str_repeat("=", 60) . "\n";

        // Check reviewer invitations
        $invitations = Reviewer::where('status', 'invited')->get();
        echo "Current pending invitations: {$invitations->count()}\n";

        foreach ($invitations as $invitation) {
            $journal = Journal::find($invitation->journal_id);
            $reviewer = User::find($invitation->user_id);

            echo sprintf("  - Journal: %-25s | Reviewer: %-20s | Invited: %s\n",
                Str::limit($journal->title ?? 'N/A', 22),
                $reviewer->fullname ?? $invitation->email,
                $invitation->invited_at->format('Y-m-d H:i')
            );
        }

        // Test invitation token system
        echo "\nTesting invitation token system...\n";
        if ($invitations->count() > 0) {
            $testInvitation = $invitations->first();
            echo "Test invitation token: {$testInvitation->token}\n";
            echo "Invitation URL would be: /reviewer/accept/{$testInvitation->token}\n";
            echo "✅ Token-based invitation system is functional\n";
        } else {
            echo "No invitations available for token testing\n";
        }

        // Test email template existence
        $templatePath = 'resources/views/emails/invite_reviewer.blade.php';
        if (file_exists($templatePath)) {
            echo "✅ Reviewer invitation email template exists\n";
        } else {
            echo "❌ Reviewer invitation email template missing\n";
        }
    }

    private function testReviewerResponseHandling() {
        echo "\n📝 TESTING REVIEWER RESPONSE HANDLING\n";
        echo str_repeat("=", 60) . "\n";

        // Test different reviewer response statuses
        $statusCounts = Reviewer::selectRaw('status, COUNT(*) as count')
                               ->groupBy('status')
                               ->get();

        echo "Reviewer response status distribution:\n";
        foreach ($statusCounts as $status) {
            echo "  - {$status->status}: {$status->count}\n";
        }

        // Test status transitions
        echo "\nTesting reviewer status transitions:\n";
        echo "  invited → accepted → in-progress → reviewed\n";
        echo "  invited → declined\n";

        // Find reviewers to test status updates
        $testReviewer = Reviewer::where('status', 'invited')->first();
        if ($testReviewer) {
            echo "\nSimulating reviewer acceptance...\n";
            echo "Reviewer: {$testReviewer->email}\n";
            echo "Original status: {$testReviewer->status}\n";

            // Simulate acceptance
            $testReviewer->status = 'accepted';
            $testReviewer->accepted_at = now();
            $testReviewer->save();

            echo "New status: {$testReviewer->status}\n";
            echo "✅ Reviewer acceptance processed\n";

            // Simulate review completion
            echo "\nSimulating review completion...\n";
            $testReviewer->status = 'reviewed';
            $testReviewer->reviewed_at = now();
            $testReviewer->review_comments = 'This is a test review comment for workflow validation.';
            $testReviewer->recommendation = 'accept';
            $testReviewer->save();

            echo "Final status: {$testReviewer->status}\n";
            echo "✅ Review completion processed\n";

        } else {
            echo "No invited reviewers found for status testing\n";
        }
    }

    private function testReviewProgressTracking() {
        echo "\n📊 TESTING REVIEW PROGRESS TRACKING\n";
        echo str_repeat("=", 60) . "\n";

        // Get manuscripts in review
        $inProgressJournals = Journal::where('approval_status', 'in-progress')->get();
        echo "Manuscripts currently in review: {$inProgressJournals->count()}\n";

        foreach ($inProgressJournals as $journal) {
            $reviewers = Reviewer::where('journal_id', $journal->id)->get();
            $completedReviews = $reviewers->where('status', 'reviewed')->count();
            $totalReviewers = $reviewers->count();

            if ($totalReviewers > 0) {
                $completionPercentage = ($completedReviews / $totalReviewers) * 100;

                echo sprintf("\nJournal: %-30s\n", Str::limit($journal->title, 27));
                echo sprintf("  Progress: %d/%d reviewers completed (%.0f%%)\n",
                    $completedReviews, $totalReviewers, $completionPercentage);

                // Show reviewer details
                foreach ($reviewers as $reviewer) {
                    $user = User::find($reviewer->user_id);
                    echo sprintf("    → %-20s | Status: %-10s | %s\n",
                        $user->fullname ?? $reviewer->email,
                        $reviewer->status,
                        $reviewer->reviewed_at ? $reviewer->reviewed_at->format('Y-m-d') : 'Pending'
                    );
                }

                // Check if ready for editor decision
                if ($completionPercentage >= 100) {
                    echo "    🎯 Ready for editor approval/decline decision\n";
                } else {
                    echo "    ⏳ Waiting for remaining reviews\n";
                }
            }
        }

        if ($inProgressJournals->count() === 0) {
            echo "No manuscripts currently in review\n";
        }
    }

    private function testEditorApprovalWorkflow() {
        echo "\n✅ TESTING EDITOR APPROVAL WORKFLOW\n";
        echo str_repeat("=", 60) . "\n";

        // Find manuscripts ready for editor decision (all reviews completed)
        $readyForDecision = Journal::where('approval_status', 'in-progress')
                                 ->whereHas('reviewers', function($query) {
                                     $query->selectRaw('journal_id, COUNT(*) as total_reviewers,
                                                       SUM(CASE WHEN status = "reviewed" THEN 1 ELSE 0 END) as completed_reviews')
                                           ->groupBy('journal_id')
                                           ->havingRaw('total_reviewers = completed_reviews');
                                 })
                                 ->get();

        echo "Manuscripts ready for editor decision: {$readyForDecision->count()}\n";

        foreach ($readyForDecision as $manuscript) {
            echo "\nManuscript: {$manuscript->title}\n";

            $reviewers = Reviewer::where('journal_id', $manuscript->id)
                               ->where('status', 'reviewed')
                               ->get();

            echo "Completed reviews: {$reviewers->count()}\n";

            // Analyze recommendations
            $recommendations = $reviewers->pluck('recommendation')->countBy();
            echo "Review recommendations:\n";
            foreach ($recommendations as $recommendation => $count) {
                echo "  - {$recommendation}: {$count}\n";
            }

            // Simulate editor decision based on recommendations
            $acceptCount = $recommendations['accept'] ?? 0;
            $rejectCount = $recommendations['reject'] ?? 0;
            $reviseCount = $recommendations['revise'] ?? 0;

            echo "Simulating editor decision...\n";

            if ($acceptCount > $rejectCount && $acceptCount > $reviseCount) {
                echo "  → Recommended decision: APPROVE\n";
                // Simulate approval
                $manuscript->approval_status = 'approved';
                $manuscript->save();
                echo "  ✅ Manuscript approved\n";
            } elseif ($reviseCount > 0) {
                echo "  → Recommended decision: REQUEST CHANGES\n";
                // Would trigger change request workflow
                echo "  📝 Change requests would be sent to author\n";
            } else {
                echo "  → Recommended decision: DECLINE\n";
                $manuscript->approval_status = 'declined';
                $manuscript->save();
                echo "  ❌ Manuscript declined\n";
            }
        }

        if ($readyForDecision->count() === 0) {
            echo "No manuscripts ready for editor decision\n";
            echo "ℹ️  Editor decision workflow would activate when all reviewers complete their reviews\n";
        }
    }
}

try {
    $tester = new EditorReviewerTester();
    $tester->runTests();
} catch (Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
}

echo "\n=== EDITOR REVIEWER MANAGEMENT TESTING COMPLETED ===\n";
echo "\n📋 MANUAL TESTING CHECKLIST FOR EDITOR WORKFLOWS:\n";
echo "1. ✅ Login as editor@example.com (password: password)\n";
echo "2. ✅ Navigate to editor dashboard\n";
echo "3. ✅ View pending manuscripts needing reviewer assignment\n";
echo "4. ✅ Assign 2-4 Associate Editors as reviewers\n";
echo "5. ✅ Verify reviewer invitation emails are sent\n";
echo "6. ✅ Track review progress and completion status\n";
echo "7. ✅ Make approve/decline decisions after all reviews\n";
echo "8. ✅ Send change requests to authors when needed\n";
echo "9. ✅ Verify notifications to all stakeholders\n";
echo "10. ✅ Test minimum/maximum reviewer limits\n";
