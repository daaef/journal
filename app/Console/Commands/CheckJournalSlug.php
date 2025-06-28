<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;

class CheckJournalSlug extends Command
{
    protected $signature = 'test:journal-slug';
    protected $description = 'Check journal slug and URL';

    public function handle()
    {
        $journal = Journal::where('approval_status', 'ready_for_managing_editor_notice')->first();
        
        if (!$journal) {
            $this->error('No journal found with ready_for_managing_editor_notice status');
            return 1;
        }
        
        $this->info('Journal Details:');
        $this->info('UUID: ' . $journal->uuid);
        $this->info('Slug: ' . ($journal->slug ?? 'NULL'));
        $this->info('Title: ' . $journal->title);
        
        $slug = $journal->slug ?? 'default-slug';
        $previewUrl = route('editor.journals.preview', [$journal->uuid, $slug]);
        $this->info('Preview URL: ' . $previewUrl);
        
        return 0;
    }
}
