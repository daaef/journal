<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== QUICK SYSTEM STATUS CHECK ===\n\n";

try {
    // Check database connection
    $userCount = \App\Models\User::count();
    echo "✅ Database connection: Working ({$userCount} users)\n";

    // Check manuscript versions table
    $hasVersions = \Illuminate\Support\Facades\Schema::hasTable('manuscript_versions');
    echo "✅ Version control table: " . ($hasVersions ? 'EXISTS' : 'MISSING') . "\n";

    if ($hasVersions) {
        $versionColumns = \Illuminate\Support\Facades\Schema::getColumnListing('manuscript_versions');
        echo "   Columns: " . implode(', ', $versionColumns) . "\n";
    }

    // Check reviewers table
    $reviewerColumns = \Illuminate\Support\Facades\Schema::getColumnListing('reviewers');
    echo "✅ Reviewers table columns: " . implode(', ', $reviewerColumns) . "\n";

    // Check current manuscripts
    $manuscripts = \App\Models\Journal::count();
    echo "✅ Total manuscripts: {$manuscripts}\n";

    // Check categories
    $categories = \App\Models\Category::count();
    echo "✅ Categories: {$categories}\n";

    // Check countries
    $countries = \App\Models\Country::count();
    echo "✅ Countries: {$countries}\n";

    echo "\n=== STATUS CHECK COMPLETED ===\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
