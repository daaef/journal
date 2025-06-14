<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing notification system...\n";

try {
    // Test database connection
    $userCount = \App\Models\User::count();
    echo "Total users in database: {$userCount}\n";
    
    if ($userCount > 0) {
        $user = \App\Models\User::first();
        echo "First user: {$user->email}\n";
        
        // Test notifications
        $notificationCount = $user->notifications()->count();
        echo "Notifications for user: {$notificationCount}\n";
        
        $unreadCount = $user->unreadNotifications()->count();
        echo "Unread notifications: {$unreadCount}\n";
        
        // Test journals
        $journalCount = \App\Models\Journal::count();
        echo "Total journals: {$journalCount}\n";
        
        if ($journalCount > 0) {
            $journal = \App\Models\Journal::first();
            echo "Testing journal relationship...\n";
            
            // Test the reviewers relationship that was causing issues
            $reviewers = $journal->reviewers;
            if ($reviewers) {
                echo "Reviewers for journal: " . $reviewers->count() . "\n";
            } else {
                echo "No reviewers found for journal (this is normal)\n";
            }
        }
        
        echo "All tests passed!\n";
        
    } else {
        echo "No users found in database\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
