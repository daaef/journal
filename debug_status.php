<?php

// Simple Laravel database check
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class);

use App\Models\Journal;
use Illuminate\Support\Facades\DB;
use App\Models\User;

// Check journal statuses
echo "=== JOURNAL STATUSES ===" . PHP_EOL;
try {
    $statuses = Journal::select('approval_status', DB::raw('count(*) as count'))
        ->groupBy('approval_status')
        ->get();

    foreach($statuses as $status) {
        echo $status->approval_status . ': ' . $status->count . PHP_EOL;
    }

    echo PHP_EOL . "=== READY FOR NOTICE ===" . PHP_EOL;
    $ready = Journal::where('approval_status', 'ready_for_managing_editor_notice')->count();
    echo 'Ready for notice count: ' . $ready . PHP_EOL;

    echo PHP_EOL . "=== USER ROLES ===" . PHP_EOL;
    $users = User::with('roles')->get();
    foreach($users as $user) {
        $roles = $user->roles->pluck('name')->implode(', ');
        echo $user->email . ' - Roles: ' . ($roles ?: 'No roles') . PHP_EOL;
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
