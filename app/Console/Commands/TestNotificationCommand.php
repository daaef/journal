<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Journal;
use App\Notifications\JournalSubmittedNotification;
use App\Notifications\JournalStatusChangedNotification;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test notifications to verify the system is working';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing notification system...');

        // Get first user and journal
        $user = User::first();
        $journal = Journal::first();

        if (!$user) {
            $this->error('No users found in database');
            return;
        }

        if (!$journal) {
            $this->error('No journals found in database');
            return;
        }

        // Send test notifications
        $this->info("Sending test notifications to user: {$user->fullname}");

        // Test 1: Journal Submitted Notification
        $user->notify(new JournalSubmittedNotification($journal, $journal->user ?? $user));
        $this->info('✓ Journal submitted notification sent');

        // Test 2: Journal Status Changed Notification
        $user->notify(new JournalStatusChangedNotification($journal, 'approved', 'Test status change notification'));
        $this->info('✓ Journal status changed notification sent');

        // Check notification count
        $notificationCount = $user->notifications()->count();
        $unreadCount = $user->unreadNotifications()->count();

        $this->info("Total notifications: {$notificationCount}");
        $this->info("Unread notifications: {$unreadCount}");

        $this->info('Test notifications sent successfully!');
        $this->info('You can now check the notification dropdown in the application.');
    }
}
