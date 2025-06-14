<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Repositories\Journal\EloquentJournalRepository;

echo "=== Editor Approval Test ===\n";

try {
    $repo = new EloquentJournalRepository();
    
    // Find a journal with "reviewed" status
    $journal = Journal::where('approval_status', 'reviewed')->first();
    
    if (!$journal) {
        echo "❌ No reviewed journals found. Setting up test scenario...\n";
        $journal = Journal::first();
        if ($journal) {
            $journal->approval_status = 'reviewed';
            $journal->save();
            echo "✅ Set journal '{$journal->title}' to reviewed status\n";
        } else {
            echo "❌ No journals found in database\n";
            exit;
        }
    }
    
    // Ensure at least 2 reviews exist (requirement for approval)
    $reviewCount = $journal->reviewerAssignments()->whereNotNull('review_submitted_at')->count();
    echo "📊 Current review count: {$reviewCount}\n";
    
    if ($reviewCount < 2) {
        echo "⚠️  Need at least 2 reviews for approval. Current: {$reviewCount}\n";
        echo "   Creating additional review records for testing...\n";
        
        // Create dummy review records
        for ($i = $reviewCount; $i < 2; $i++) {
            $dummyUser = User::skip($i)->first();
            if ($dummyUser) {
                \App\Models\Reviewer::create([
                    'journal_id' => $journal->id,
                    'user_id' => $dummyUser->id,
                    'fullname' => $dummyUser->fullname,
                    'comment' => 'Test review comment ' . ($i + 1),
                    'rating' => 4,
                    'recommendation' => 'accept',
                    'status' => 'completed',
                    'review_submitted_at' => now(),
                    'assigned_at' => now()
                ]);
                echo "   ✅ Created review #" . ($i + 1) . " by {$dummyUser->fullname}\n";
            }
        }
    }
    
    echo "\n📄 Testing with journal: {$journal->title}\n";
    echo "📊 Current status: {$journal->approval_status}\n";
    
    // Test approving for publication
    echo "\n🔄 Approving manuscript for publication...\n";
    
    $result = $repo->approveForPublication(
        $journal->uuid,
        'This manuscript has been approved for publication after thorough review.'
    );
    
    // Refresh journal to see updated status
    $journal->refresh();
    
    echo "✅ Manuscript approved successfully!\n";
    echo "📊 New status: {$journal->approval_status}\n";
    echo "📧 Notifications should have been sent to:\n";
    echo "   - Author: " . ($journal->author->email ?? 'N/A') . "\n";
    echo "   - Editors: Managing Editor, Editor in Chief\n";
    echo "📬 Check your mail logs or Mailtrap inbox for the emails.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
