<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test mail system
use App\Models\User;
use App\Models\Journal;
use App\Notifications\ManuscriptStatusChangedNotification;

echo "=== Mail System Test ===\n";

try {
    $user = User::first();
    $journal = Journal::first();
    
    if (!$user) {
        echo "❌ No users found in database\n";
        exit;
    }
    
    if (!$journal) {
        echo "❌ No journals found in database\n";
        exit;
    }
    
    echo "📧 Testing notification to: {$user->email}\n";
    echo "📄 Using journal: {$journal->title}\n";
    
    // Send test notification
    $user->notify(new ManuscriptStatusChangedNotification(
        $journal,
        'pending',
        'approved',
        'This is a test notification to verify the mail system is working.',
        route('dashboard')
    ));
    
    echo "✅ Notification sent successfully!\n";
    echo "📬 Check your mail logs or Mailtrap inbox for the email.\n";
    
} catch (Exception $e) {
    echo "❌ Error sending notification: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
