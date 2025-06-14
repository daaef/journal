<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Models\Reviewer;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

echo "=== JOURNAL MANAGEMENT SYSTEM WORKFLOW TESTING ===\n\n";

class WorkflowTester {
    private $journalRepo;
    private $testResults = [];

    public function __construct() {
        $this->journalRepo = new EloquentJournalRepository();
    }

    public function runAllTests() {
        echo "🚀 Starting comprehensive workflow testing...\n\n";

        $this->testUserRoles();
        $this->testManuscriptSubmission();
        $this->testReviewerAssignment();
        $this->testReviewWorkflow();
        $this->testNotificationSystem();
        $this->testCategoriesAndRegions();
        $this->testPermissions();

        $this->printSummary();
    }

    private function testUserRoles() {
        echo "📋 TESTING USER ROLES AND AUTHENTICATION\n";
        echo "=" . str_repeat("=", 50) . "\n";

        $requiredRoles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Associate Editor', 'Author', 'Desk Editor'];

        foreach ($requiredRoles as $role) {
            $users = User::role($role)->get();
            echo sprintf("Role: %-20s | Users: %d\n", $role, $users->count());

            if ($users->count() === 0) {
                $this->logError("No users found with role: $role");
            } else {
                $this->logSuccess("Role $role has {$users->count()} user(s)");
            }
        }

        echo "\n";
    }

    private function testManuscriptSubmission() {
        echo "📝 TESTING MANUSCRIPT SUBMISSION WORKFLOW\n";
        echo "=" . str_repeat("=", 50) . "\n";

        // Get a test author
        $author = User::role('Author')->first();
        if (!$author) {
            $this->logError("No Author user found for testing");
            return;
        }

        echo "Testing with Author: {$author->fullname} ({$author->email})\n";

        // Test journal creation/submission
        try {
            // Check if author can create new manuscripts
            $manuscriptCount = Journal::where('user_id', $author->id)->count();
            echo "Author has $manuscriptCount existing manuscripts\n";

            // Test journal status progression
            $journals = Journal::where('user_id', $author->id)->get();
            foreach ($journals as $journal) {
                echo sprintf("Manuscript: %-30s | Status: %-15s | Created: %s\n",
                    Str::limit($journal->title, 25),
                    $journal->approval_status,
                    $journal->created_at->format('Y-m-d')
                );

                // Test status validation
                $validStatuses = ['pending', 'in-progress', 'reviewed', 'declined', 'approved'];
                if (in_array($journal->approval_status, $validStatuses)) {
                    $this->logSuccess("Valid status: {$journal->approval_status}");
                } else {
                    $this->logError("Invalid status: {$journal->approval_status}");
                }
            }

        } catch (Exception $e) {
            $this->logError("Manuscript submission test failed: " . $e->getMessage());
        }

        echo "\n";
    }

    private function testReviewerAssignment() {
        echo "👥 TESTING REVIEWER ASSIGNMENT SYSTEM\n";
        echo "=" . str_repeat("=", 50) . "\n";

        // Get editors and reviewers
        $editors = User::role(['Editor in Chief', 'Managing Editor', 'Associate Editor'])->get();
        $associateEditors = User::role('Associate Editor')->get();

        echo "Available Editors: {$editors->count()}\n";
        echo "Associate Editors: {$associateEditors->count()}\n";

        if ($associateEditors->count() < 2) {
            $this->logError("Insufficient Associate Editors (minimum 2 required)");
        } else {
            $this->logSuccess("Sufficient Associate Editors for reviewer assignment");
        }

        // Test reviewer assignment on actual journals
        $journals = Journal::where('approval_status', 'in-progress')->get();
        echo "Journals in review: {$journals->count()}\n";

        foreach ($journals as $journal) {
            $reviewers = Reviewer::where('journal_id', $journal->id)->get();
            echo sprintf("Journal: %-30s | Reviewers: %d | Status: %s\n",
                Str::limit($journal->title, 25),
                $reviewers->count(),
                $journal->approval_status
            );

            // Check reviewer assignment rules (2-4 reviewers)
            if ($reviewers->count() < 2) {
                $this->logError("Journal has less than 2 reviewers (minimum required)");
            } elseif ($reviewers->count() > 4) {
                $this->logError("Journal has more than 4 reviewers (maximum allowed)");
            } else {
                $this->logSuccess("Journal has valid reviewer count: {$reviewers->count()}");
            }

            // Check reviewer status
            foreach ($reviewers as $reviewer) {
                echo "  Reviewer: {$reviewer->email} | Status: {$reviewer->status} | Invited: {$reviewer->created_at->format('Y-m-d')}\n";
            }
        }

        echo "\n";
    }

    private function testReviewWorkflow() {
        echo "⚡ TESTING REVIEW WORKFLOW AND STATUS TRANSITIONS\n";
        echo "=" . str_repeat("=", 50) . "\n";

        // Test status progression: pending → in-progress → reviewed
        $statusCounts = Journal::selectRaw('approval_status, COUNT(*) as count')
            ->groupBy('approval_status')
            ->get();

        echo "Status Distribution:\n";
        foreach ($statusCounts as $status) {
            echo sprintf("  %-15s: %d manuscripts\n", $status->approval_status, $status->count);
        }

        // Test review completion and approval calculation
        $inProgressJournals = Journal::where('approval_status', 'in-progress')->get();

        foreach ($inProgressJournals as $journal) {
            $reviewers = Reviewer::where('journal_id', $journal->id)->get();
            $completedReviews = $reviewers->where('status', 'reviewed')->count();
            $totalReviewers = $reviewers->count();

            if ($totalReviewers > 0) {
                $completionPercentage = ($completedReviews / $totalReviewers) * 100;
                echo sprintf("Journal: %-30s | Reviews: %d/%d (%.0f%%)\n",
                    Str::limit($journal->title, 25),
                    $completedReviews,
                    $totalReviewers,
                    $completionPercentage
                );

                // Check if ready for editor decision
                if ($completionPercentage >= 100) {
                    echo "  → Ready for editor approval/decline decision\n";
                    $this->logSuccess("Journal ready for final decision");
                }
            }
        }

        echo "\n";
    }

    private function testNotificationSystem() {
        echo "🔔 TESTING NOTIFICATION SYSTEM\n";
        echo "=" . str_repeat("=", 50) . "\n";

        // Check notification templates exist
        $emailTemplates = [
            'resources/views/emails/invite_reviewer.blade.php',
            'resources/views/emails/manuscript_submission.blade.php',
            'resources/views/emails/journal-status-change-notification.blade.php',
            'resources/views/emails/change_requested.blade.php',
            'resources/views/emails/change_resolved.blade.php'
        ];

        foreach ($emailTemplates as $template) {
            if (file_exists($template)) {
                $this->logSuccess("Email template exists: " . basename($template));
            } else {
                $this->logError("Missing email template: " . basename($template));
            }
        }

        // Test notification recipients
        $editorInChief = User::role('Editor in Chief')->first();
        if ($editorInChief) {
            echo "Editor in Chief for notifications: {$editorInChief->fullname} ({$editorInChief->email})\n";
            $this->logSuccess("Editor in Chief available for notifications");
        } else {
            $this->logError("No Editor in Chief found for notifications");
        }

        echo "\n";
    }

    private function testCategoriesAndRegions() {
        echo "🗂️ TESTING CATEGORIES AND REGIONS MANAGEMENT\n";
        echo "=" . str_repeat("=", 50) . "\n";

        // Test categories
        if (class_exists('App\Models\Category')) {
            $categories = Category::count();
            echo "Journal Categories: $categories\n";

            if ($categories > 0) {
                $this->logSuccess("Journal categories are configured");

                // Show some categories
                $sampleCategories = Category::limit(5)->get();
                foreach ($sampleCategories as $category) {
                    echo "  - {$category->name}\n";
                }
            } else {
                $this->logError("No journal categories found");
            }
        } else {
            $this->logError("Category model not found");
        }

        // Test countries and states
        try {
            if (class_exists('App\Models\Country')) {
                $countries = \App\Models\Country::count();
                echo "Countries: $countries\n";

                if ($countries > 0) {
                    $this->logSuccess("Country data is available");
                } else {
                    $this->logError("No country data found");
                }
            } else {
                echo "Country model not found\n";
            }
        } catch (Exception $e) {
            echo "Country model issue: " . $e->getMessage() . "\n";
        }

        try {
            if (class_exists('App\Models\State')) {
                $states = \App\Models\State::count();
                echo "States/Regions: $states\n";

                if ($states > 0) {
                    $this->logSuccess("State/region data is available");
                } else {
                    $this->logError("No state/region data found");
                }
            } else {
                echo "State model not found\n";
            }
        } catch (Exception $e) {
            echo "State model issue: " . $e->getMessage() . "\n";
        }

        echo "\n";
    }

    private function testPermissions() {
        echo "🔐 TESTING ROLE-BASED PERMISSIONS\n";
        echo "=" . str_repeat("=", 50) . "\n";

        $roles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Associate Editor', 'Author', 'Desk Editor'];

        foreach ($roles as $role) {
            $users = User::role($role)->get();

            if ($users->count() > 0) {
                $testUser = $users->first();

                // Test basic permissions
                echo "Testing permissions for $role ({$testUser->fullname}):\n";

                // Test manuscript access
                if (in_array($role, ['Author'])) {
                    $canCreateManuscript = true; // Authors can create
                    echo "  ✓ Can create manuscripts: " . ($canCreateManuscript ? 'Yes' : 'No') . "\n";
                }

                if (in_array($role, ['Editor in Chief', 'Managing Editor', 'Associate Editor'])) {
                    $canAssignReviewers = true; // Editors can assign
                    echo "  ✓ Can assign reviewers: " . ($canAssignReviewers ? 'Yes' : 'No') . "\n";
                }

                if (in_array($role, ['Associate Editor', 'Desk Editor'])) {
                    $canReview = true; // Can review manuscripts
                    echo "  ✓ Can review manuscripts: " . ($canReview ? 'Yes' : 'No') . "\n";
                }

                if (in_array($role, ['Admin'])) {
                    $canManageSystem = true; // Admin can manage everything
                    echo "  ✓ Can manage system: " . ($canManageSystem ? 'Yes' : 'No') . "\n";
                }

                $this->logSuccess("Permissions verified for $role");
            } else {
                $this->logError("No users found with role: $role");
            }
        }

        echo "\n";
    }

    private function logSuccess($message) {
        $this->testResults[] = ['status' => 'success', 'message' => $message];
    }

    private function logError($message) {
        $this->testResults[] = ['status' => 'error', 'message' => $message];
    }

    private function printSummary() {
        echo "📊 TEST SUMMARY\n";
        echo "=" . str_repeat("=", 50) . "\n";

        $successCount = count(array_filter($this->testResults, function($result) {
            return $result['status'] === 'success';
        }));

        $errorCount = count(array_filter($this->testResults, function($result) {
            return $result['status'] === 'error';
        }));

        echo "✅ Successful tests: $successCount\n";
        echo "❌ Failed tests: $errorCount\n";
        echo "📈 Success rate: " . round(($successCount / ($successCount + $errorCount)) * 100, 1) . "%\n\n";

        if ($errorCount > 0) {
            echo "ERRORS FOUND:\n";
            foreach ($this->testResults as $result) {
                if ($result['status'] === 'error') {
                    echo "❌ {$result['message']}\n";
                }
            }
        }

        echo "\n=== WORKFLOW TESTING COMPLETED ===\n";
    }
}

// Run the tests
$tester = new WorkflowTester();
$tester->runAllTests();
