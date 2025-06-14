<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\User;
use App\Models\Reviewer;

class TestReviewerAssignment extends Command
{
    protected $signature = 'test:reviewer-assignment';
    protected $description = 'Test reviewer assignment functionality';

    public function handle()
    {
        $this->info('=== REVIEWER ASSIGNMENT SYSTEM TEST ===');

        // Get journals
        $journals = Journal::all();
        $this->info("Journals available: " . $journals->count());

        if ($journals->count() > 0) {
            foreach ($journals as $journal) {
                $this->line("  - {$journal->title} (UUID: {$journal->uuid})");
                $assignedReviewers = $journal->reviewers()->with('user')->get();
                $this->line("    Assigned reviewers: " . $assignedReviewers->count());
                foreach ($assignedReviewers as $reviewer) {
                    $this->line("      * {$reviewer->user->fullname}");
                }
            }
        }

        // Get Associate Editors
        $associateEditors = User::role('Associate Editor')->get();
        $this->info("\nAssociate Editors available: " . $associateEditors->count());
        foreach ($associateEditors as $editor) {
            $this->line("  - {$editor->fullname} ({$editor->email})");
        }

        $this->info("\n=== SYSTEM READY FOR TESTING ===");
        $this->info("1. Visit http://journal.test");
        $this->info("2. Login as Editor in Chief or Managing Editor");
        $this->info("3. Navigate to journal preview");
        $this->info("4. Test reviewer assignment with 2-4 limit");

        return 0;
    }
}
