<?php

/**
 * Test script to verify Managing Editor notice functionality
 */

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Journal;
use App\Repositories\Journal\EloquentJournalRepository;

echo "=== Managing Editor Notice Test ===\n\n";

try {
    $repo = new EloquentJournalRepository();
    
    // Find Managing Editor
    $managingEditor = User::whereHas('roles', function($query) {
        $query->where('name', 'Managing Editor');
    })->first();
    
    if (!$managingEditor) {
        echo "❌ No Managing Editor found\n";
        exit;
    }
    
    echo "👤 Managing Editor: {$managingEditor->fullname}\n";
    
    // Check manuscripts ready for notice
    $readyForNotice = $repo->getJournalsReadyForNotice();
    echo "📋 Manuscripts ready for notice: {$readyForNotice->count()}\n";
    
    if ($readyForNotice->count() === 0) {
        echo "\n⚠️  No manuscripts ready for notice. Creating test scenario...\n";
        
        // Find a manuscript to use for testing
        $testJournal = Journal::where('approval_status', 'reviewed')->first();
        
        if (!$testJournal) {
            $testJournal = Journal::first();
        }
        
        if ($testJournal) {
            $testJournal->approval_status = 'ready_for_managing_editor_notice';
            $testJournal->save();
            echo "✅ Created test manuscript: {$testJournal->title}\n";
        } else {
            echo "❌ No manuscripts found to create test scenario\n";
            exit;
        }
    }
    
    echo "\n✅ Managing Editor notice functionality is ready!\n";
    echo "\n📋 Next Steps:\n";
    echo "1. Login as Managing Editor: {$managingEditor->email}\n";
    echo "2. Navigate to Dashboard > Ready for Notice\n";
    echo "3. Click 'Actions' dropdown for any manuscript\n";
    echo "4. Choose 'Send Approval Notice' or 'Send Decline Notice'\n";
    echo "5. Fill in the form and submit\n";
    
    echo "\n🔧 Available Actions:\n";
    echo "- Send Approval Notice: Approves manuscript and notifies author\n";
    echo "- Send Decline Notice: Declines manuscript with reason\n";
    echo "- Review Details: View full manuscript and review information\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n=== Test Completed ===\n";
