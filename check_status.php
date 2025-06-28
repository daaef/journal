<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->call('tinker', ['--execute' => "
use App\Models\Journal;
use Illuminate\Support\Facades\DB;

echo 'Checking Journal statuses:' . PHP_EOL;
\$statuses = Journal::select('approval_status', DB::raw('count(*) as count'))
    ->groupBy('approval_status')
    ->get();

foreach(\$statuses as \$status) {
    echo \$status->approval_status . ': ' . \$status->count . PHP_EOL;
}

echo PHP_EOL . 'Checking ready for notice manuscripts:' . PHP_EOL;
\$ready = Journal::where('approval_status', 'ready_for_managing_editor_notice')->count();
echo 'Ready for notice count: ' . \$ready . PHP_EOL;

echo PHP_EOL . 'Checking user roles:' . PHP_EOL;
\$users = \App\Models\User::with('roles')->get();
foreach(\$users as \$user) {
    echo \$user->email . ' - Roles: ' . \$user->roles->pluck('name')->implode(', ') . PHP_EOL;
}
"]);
