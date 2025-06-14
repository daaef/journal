<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== DATABASE SCHEMA CHECK ===\n\n";

try {
    // Check reviewers table columns
    echo "Reviewers table columns:\n";
    $columns = Schema::getColumnListing('reviewers');
    foreach ($columns as $column) {
        echo "  - {$column}\n";
    }

    echo "\nReviewers table sample data:\n";
    $reviewers = DB::table('reviewers')->limit(3)->get();
    foreach ($reviewers as $reviewer) {
        echo "  ID: {$reviewer->id}, journal_id: {$reviewer->journal_id}, user_id: {$reviewer->user_id}\n";
    }

    echo "\nJournals table relevant columns:\n";
    $journalColumns = Schema::getColumnListing('journals');
    $relevantCols = ['id', 'title', 'approval_status', 'user_id', 'created_at'];
    foreach ($relevantCols as $col) {
        if (in_array($col, $journalColumns)) {
            echo "  ✅ {$col}\n";
        } else {
            echo "  ❌ {$col} (missing)\n";
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
