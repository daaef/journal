<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Repositories\Journal\EloquentJournalRepository;

class TestReadyForNotice extends Command
{
    protected $signature = 'test:ready-for-notice';
    protected $description = 'Test the ready for notice functionality';

    public function handle()
    {
        $this->info('=== TESTING READY FOR NOTICE FUNCTIONALITY ===');
          $journals = Journal::where('approval_status', 'ready_for_managing_editor_notice')
            ->with(['reviewerAssignments.user', 'category', 'user'])
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $this->info('Found ' . $journals->count() . ' manuscripts ready for notice');
        
        foreach($journals as $journal) {
            $this->info('');
            $this->info('Manuscript: ' . $journal->title);
            $this->info('Author: ' . $journal->author);
            $this->info('Status: ' . $journal->approval_status);
            $this->info('UUID: ' . $journal->uuid);
            $this->info('Created: ' . $journal->created_at->format('Y-m-d H:i:s'));
            
            // Check reviews
            $reviewCount = $journal->reviewerAssignments->where('review_submitted_at', '!=', null)->count();
            $this->info('Completed Reviews: ' . $reviewCount);
        }
        
        $this->info('');
        $this->info('=== ROUTE TESTING ===');
        $this->info('Try accessing: ' . route('editor.journals.readyForNotice'));
        
        return 0;
    }
}
