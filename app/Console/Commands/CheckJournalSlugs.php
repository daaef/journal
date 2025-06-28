<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use Exception;

class CheckJournalSlugs extends Command
{
    protected $signature = 'journal:check-slugs';
    protected $description = 'Check journal slugs for ready manuscripts';

    public function handle()
    {
        $this->info('=== CHECKING JOURNAL SLUGS ===');
        
        $journals = Journal::where('approval_status', 'ready_for_managing_editor_notice')->get();
        
        foreach($journals as $journal) {
            $this->info('');
            $this->info('Title: ' . $journal->title);
            $this->info('UUID: ' . $journal->uuid);
            $this->info('Slug: ' . ($journal->slug ?: 'NULL/EMPTY'));
            
            // Try to generate the route
            try {
                $url = route('editor.journals.preview', [$journal->uuid, $journal->slug ?: 'manuscript']);
                $this->info('Generated URL: ' . $url);
            } catch (Exception $e) {
                $this->error('Route error: ' . $e->getMessage());
            }
        }
        
        return 0;
    }
}
