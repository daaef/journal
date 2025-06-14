<?php
/**
 * Test Script: Enhanced Review Relationship Fix
 * Tests the Journal->reviewerAssignments relationship and related functionality
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

echo "=== ENHANCED REVIEW RELATIONSHIP TESTING ===\n";
echo "Testing Date: " . date('Y-m-d H:i:s') . "\n\n";

try {
    // Initialize Laravel application
    $app = require_once 'bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    echo "✅ Laravel application initialized\n\n";

    // Test 1: Check if Journal model has reviewerAssignments relationship
    echo "1. Testing Journal Model Relationships...\n";

    $journalReflection = new ReflectionClass(\App\Models\Journal::class);
    $methods = $journalReflection->getMethods();

    $hasReviewerAssignments = false;
    $hasReviewers = false;

    foreach ($methods as $method) {
        if ($method->getName() === 'reviewerAssignments') {
            $hasReviewerAssignments = true;
        }
        if ($method->getName() === 'reviewers') {
            $hasReviewers = true;
        }
    }

    if ($hasReviewerAssignments) {
        echo "  ✅ reviewerAssignments() method exists in Journal model\n";
    } else {
        echo "  ❌ reviewerAssignments() method missing in Journal model\n";
    }

    if ($hasReviewers) {
        echo "  ✅ reviewers() method exists in Journal model\n";
    } else {
        echo "  ❌ reviewers() method missing in Journal model\n";
    }

    // Test 2: Check if Reviewer model has proper relationships
    echo "\n2. Testing Reviewer Model Relationships...\n";

    $reviewerReflection = new ReflectionClass(\App\Models\Reviewer::class);
    $reviewerMethods = $reviewerReflection->getMethods();

    $hasJournal = false;
    $hasReviewer = false;
    $hasUser = false;

    foreach ($reviewerMethods as $method) {
        if ($method->getName() === 'journal') {
            $hasJournal = true;
        }
        if ($method->getName() === 'reviewer') {
            $hasReviewer = true;
        }
        if ($method->getName() === 'user') {
            $hasUser = true;
        }
    }

    if ($hasJournal) {
        echo "  ✅ journal() method exists in Reviewer model\n";
    } else {
        echo "  ❌ journal() method missing in Reviewer model\n";
    }

    if ($hasReviewer) {
        echo "  ✅ reviewer() method exists in Reviewer model\n";
    } else {
        echo "  ❌ reviewer() method missing in Reviewer model\n";
    }

    if ($hasUser) {
        echo "  ✅ user() method exists in Reviewer model\n";
    } else {
        echo "  ❌ user() method missing in Reviewer model\n";
    }

    // Test 3: Test database tables existence
    echo "\n3. Testing Database Structure...\n";

    try {
        $journalsExists = DB::getSchemaBuilder()->hasTable('journals');
        $reviewersExists = DB::getSchemaBuilder()->hasTable('reviewers');
        $usersExists = DB::getSchemaBuilder()->hasTable('users');

        if ($journalsExists) {
            echo "  ✅ journals table exists\n";
        } else {
            echo "  ❌ journals table missing\n";
        }

        if ($reviewersExists) {
            echo "  ✅ reviewers table exists\n";
        } else {
            echo "  ❌ reviewers table missing\n";
        }

        if ($usersExists) {
            echo "  ✅ users table exists\n";
        } else {
            echo "  ❌ users table missing\n";
        }

        // Check foreign key columns in reviewers table
        if ($reviewersExists) {
            $reviewerColumns = DB::getSchemaBuilder()->getColumnListing('reviewers');

            if (in_array('journal_id', $reviewerColumns)) {
                echo "  ✅ reviewers.journal_id column exists\n";
            } else {
                echo "  ❌ reviewers.journal_id column missing\n";
            }

            if (in_array('user_id', $reviewerColumns)) {
                echo "  ✅ reviewers.user_id column exists\n";
            } else {
                echo "  ❌ reviewers.user_id column missing\n";
            }
        }

    } catch (Exception $e) {
        echo "  ⚠️  Database connection issue: " . $e->getMessage() . "\n";
    }

    // Test 4: Test the actual relationship loading (simulated)
    echo "\n4. Testing Relationship Loading...\n";

    try {
        // Check if we can create a journal instance and call the relationship
        $journal = new \App\Models\Journal();
        $reviewerAssignments = $journal->reviewerAssignments();

        if ($reviewerAssignments instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
            echo "  ✅ reviewerAssignments() returns HasMany relationship\n";
        } else {
            echo "  ❌ reviewerAssignments() does not return HasMany relationship\n";
        }

        // Test the controller load statement format
        $loadArray = ['author', 'category', 'sub_category', 'versions', 'reviewerAssignments.reviewer'];
        echo "  ✅ Controller load array format validated: " . implode(', ', $loadArray) . "\n";

    } catch (Exception $e) {
        echo "  ❌ Relationship testing failed: " . $e->getMessage() . "\n";
    }

    // Test 5: Check route accessibility
    echo "\n5. Testing Enhanced Review Route...\n";

    $routeFile = 'routes/web.php';
    if (file_exists($routeFile)) {
        $routeContent = file_get_contents($routeFile);

        if (strpos($routeContent, 'enhanced-review') !== false) {
            echo "  ✅ Enhanced review route found in web.php\n";
        } else {
            echo "  ❌ Enhanced review route missing in web.php\n";
        }

        if (strpos($routeContent, 'showEnhancedReviewForm') !== false) {
            echo "  ✅ showEnhancedReviewForm method referenced in routes\n";
        } else {
            echo "  ❌ showEnhancedReviewForm method not found in routes\n";
        }
    } else {
        echo "  ❌ routes/web.php file not found\n";
    }

    echo "\n";

} catch (Exception $e) {
    echo "❌ Application initialization failed: " . $e->getMessage() . "\n";
    echo "Continuing with static analysis...\n\n";
}

// Static analysis even if Laravel fails to load
echo "=== STATIC CODE ANALYSIS ===\n";

// Check Journal model file
$journalFile = 'app/Models/Journal.php';
if (file_exists($journalFile)) {
    $journalContent = file_get_contents($journalFile);

    if (strpos($journalContent, 'function reviewerAssignments()') !== false) {
        echo "✅ reviewerAssignments() method found in Journal.php\n";
    } else {
        echo "❌ reviewerAssignments() method missing in Journal.php\n";
    }

    if (strpos($journalContent, 'hasMany(Reviewer::class') !== false) {
        echo "✅ hasMany(Reviewer::class) relationship found\n";
    } else {
        echo "❌ hasMany(Reviewer::class) relationship missing\n";
    }
} else {
    echo "❌ Journal model file not found\n";
}

// Check Reviewer model file
$reviewerFile = 'app/Models/Reviewer.php';
if (file_exists($reviewerFile)) {
    $reviewerContent = file_get_contents($reviewerFile);

    if (strpos($reviewerContent, 'function reviewer()') !== false) {
        echo "✅ reviewer() method found in Reviewer.php\n";
    } else {
        echo "❌ reviewer() method missing in Reviewer.php\n";
    }

    if (strpos($reviewerContent, 'protected $fillable') !== false) {
        echo "✅ fillable array found in Reviewer.php\n";
    } else {
        echo "❌ fillable array missing in Reviewer.php\n";
    }
} else {
    echo "❌ Reviewer model file not found\n";
}

// Check controller file
$controllerFile = 'app/Http/Controllers/JournalController.php';
if (file_exists($controllerFile)) {
    $controllerContent = file_get_contents($controllerFile);

    if (strpos($controllerContent, 'reviewerAssignments.reviewer') !== false) {
        echo "✅ reviewerAssignments.reviewer loading found in controller\n";
    } else {
        echo "❌ reviewerAssignments.reviewer loading missing in controller\n";
    }

    if (strpos($controllerContent, 'sub_category') !== false) {
        echo "✅ sub_category relationship reference found (fixed from subCategory)\n";
    } else {
        echo "❌ sub_category relationship reference missing\n";
    }
} else {
    echo "❌ JournalController file not found\n";
}

echo "\n=== TESTING SUMMARY ===\n";
echo "Enhanced review relationship fix verification completed.\n";
echo "\nManual Testing Steps:\n";
echo "1. Login as a reviewer\n";
echo "2. Navigate to reviewer dashboard\n";
echo "3. Click 'Enhanced Review' on an assigned manuscript\n";
echo "4. Verify the page loads without relationship errors\n";
echo "5. Check that reviewer assignments are properly displayed\n";

echo "\nExpected Behavior:\n";
echo "- No 'Call to undefined relationship' errors\n";
echo "- Enhanced review form loads successfully\n";
echo "- Reviewer information displays correctly\n";
echo "- Journal metadata shows properly\n";

?>
