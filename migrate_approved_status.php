<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Journal;

echo "=== MIGRATING MANUSCRIPTS FROM 'approved_for_copy_editing' TO 'approved' ===\n\n";

// Find manuscripts with the old status
$manuscriptsToMigrate = Journal::where('approval_status', 'approved_for_copy_editing')->get();

echo "Found {$manuscriptsToMigrate->count()} manuscripts to migrate:\n";

foreach ($manuscriptsToMigrate as $journal) {
    echo "- {$journal->title} (ID: {$journal->id})\n";
}

if ($manuscriptsToMigrate->count() > 0) {
    echo "\nMigrating manuscripts...\n";
    
    $updated = Journal::where('approval_status', 'approved_for_copy_editing')
                     ->update(['approval_status' => 'approved']);
    
    echo "✅ Successfully migrated {$updated} manuscripts to 'approved' status\n";
} else {
    echo "✅ No manuscripts need migration\n";
}

// Verify the migration
echo "\n=== VERIFICATION ===\n";
$remaining = Journal::where('approval_status', 'approved_for_copy_editing')->count();
$approved = Journal::where('approval_status', 'approved')->count();

echo "Manuscripts with 'approved_for_copy_editing' status: {$remaining}\n";
echo "Manuscripts with 'approved' status: {$approved}\n";

if ($remaining === 0) {
    echo "✅ Migration completed successfully!\n";
} else {
    echo "❌ Migration incomplete - {$remaining} manuscripts still need migration\n";
}
