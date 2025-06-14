<?php
/**
 * Check Reviewers Table Structure
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel app to access Schema
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== REVIEWERS TABLE STRUCTURE ===\n";

try {
    // Get table columns
    $columns = Schema::getColumnListing('reviewers');

    echo "Current columns in reviewers table:\n";
    foreach ($columns as $column) {
        echo "  - $column\n";
    }

    echo "\nChecking if table exists: ";
    echo Schema::hasTable('reviewers') ? "✅ EXISTS" : "❌ NOT FOUND";
    echo "\n";

    // Check specific columns we need
    $requiredColumns = [
        'comment',
        'confidential_comments',
        'criteria_ratings',
        'recommendation',
        'status',
        'assigned_at',
        'review_submitted_at'
    ];

    echo "\nRequired columns status:\n";
    foreach ($requiredColumns as $column) {
        $exists = Schema::hasColumn('reviewers', $column);
        echo "  $column: " . ($exists ? "✅ EXISTS" : "❌ MISSING") . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
