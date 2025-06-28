<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckJournalStatus extends Command
{
    protected $signature = 'journal:check-status';
    protected $description = 'Check journal statuses in the system';

    public function handle()
    {
        $this->info('=== JOURNAL STATUSES ===');
        
        $statuses = Journal::select('approval_status', DB::raw('count(*) as count'))
            ->groupBy('approval_status')
            ->get();

        if ($statuses->isEmpty()) {
            $this->warn('No journals found in the system');
        } else {
            foreach($statuses as $status) {
                $this->info($status->approval_status . ': ' . $status->count);
            }
        }

        $this->info('');
        $this->info('=== READY FOR NOTICE ===');
        $ready = Journal::where('approval_status', 'ready_for_managing_editor_notice')->count();
        $this->info('Ready for notice count: ' . $ready);

        $this->info('');
        $this->info('=== USERS WITH EDITOR ROLES ===');
        $editors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['Managing Editor', 'Editor in Chief']);
        })->with('roles')->get();

        foreach($editors as $editor) {
            $roles = $editor->roles->pluck('name')->implode(', ');
            $this->info($editor->email . ' - Roles: ' . $roles);
        }
        
        return 0;
    }
}
