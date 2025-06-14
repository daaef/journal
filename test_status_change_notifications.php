<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Repositories\Journal\EloquentJournalRepository;

echo "=== Manuscript Status Change Test ===\n";

try {
    $repo = new EloquentJournalRepository();
    
    // Find a journal in in-progress status or create one for testing
    $journal = Journal::where('approval_status', 'in-progress')->first();
    
    if (!$journal) {
        echo "❌ No in-progress journals found. Creating test scenario...\n";
        $journal = Journal::first();
        if ($journal) {
            $journal->approval_status = 'in-progress';
            $journal->save();
            echo "✅ Set journal '{$journal->title}' to in-progress status\n";
        } else {
            echo "❌ No journals found in database\n";
            exit;
        }
    }
    
    // Find a reviewer (Associate Editor)
    $reviewer = User::whereHas('roles', function($query) {
        $query->where('name', 'associate-editor');
    })->first();
    
    if (!$reviewer) {
        echo "❌ No Associate Editors found. Using first user...\n";
        $reviewer = User::first();
    }
    
    echo "📄 Testing with journal: {$journal->title}\n";
    echo "👤 Testing with reviewer: {$reviewer->fullname} ({$reviewer->email})\n";
    echo "📊 Current status: {$journal->approval_status}\n";
    
    // Test submitting a review
    echo "\n🔄 Submitting review...\n";
    
    $result = $repo->submitReview(
        $journal->uuid,
        $reviewer->id,
        'This is a test review comment for notification testing.',
        4,
        'accept',
        ['scholarly_merit' => 4, 'methodology' => 4, 'presentation' => 4],
        'Confidential: This manuscript shows good quality.',
        true
    );
    
    // Refresh journal to see updated status
    $journal->refresh();
    
    echo "✅ Review submitted successfully!\n";
    echo "📊 New status: {$journal->approval_status}\n";
    echo "📧 Notifications should have been sent to:\n";
    echo "   - Author: " . ($journal->author->email ?? 'N/A') . "\n";
    echo "   - Editors: Managing Editor, Editor in Chief\n";
    echo "📬 Check your mail logs or Mailtrap inbox for the emails.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
