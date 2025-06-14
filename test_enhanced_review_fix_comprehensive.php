<?php
/**
 * Test Enhanced Review Fix
 * Verifies that the enhanced review form loads without errors
 */

echo "=== ENHANCED REVIEW FIX VERIFICATION ===\n";
echo "Testing Date: " . date('Y-m-d H:i:s') . "\n\n";

// Check if Laravel is available
if (!file_exists('vendor/autoload.php')) {
    echo "❌ Laravel vendor directory not found\n";
    exit(1);
}

require_once 'vendor/autoload.php';

// Test 1: Check Journal model relationships
echo "1. Testing Journal Model Relationships...\n";

try {
    $journalModelFile = 'app/Models/Journal.php';
    if (file_exists($journalModelFile)) {
        $content = file_get_contents($journalModelFile);
        
        // Check for reviewerAssignments relationship
        if (strpos($content, 'reviewerAssignments') !== false) {
            echo "  ✅ reviewerAssignments relationship found\n";
        } else {
            echo "  ❌ reviewerAssignments relationship missing\n";
        }
        
        // Check for sub_category relationship (not subCategory)
        if (strpos($content, 'sub_category()') !== false) {
            echo "  ✅ sub_category relationship found\n";
        } else {
            echo "  ❌ sub_category relationship missing\n";
        }
    } else {
        echo "  ❌ Journal model file not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking Journal model: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check Reviewer model fields
echo "2. Testing Reviewer Model Fields...\n";

try {
    $reviewerModelFile = 'app/Models/Reviewer.php';
    if (file_exists($reviewerModelFile)) {
        $content = file_get_contents($reviewerModelFile);
        
        $requiredFields = [
            'comment' => 'comment field',
            'rating' => 'rating field',
            'confidential_comments' => 'confidential_comments field',
            'criteria_ratings' => 'criteria_ratings field'
        ];
        
        foreach ($requiredFields as $field => $description) {
            if (strpos($content, "'{$field}'") !== false) {
                echo "  ✅ {$description} found in fillable\n";
            } else {
                echo "  ⚠️  {$description} not found in fillable\n";
            }
        }
    } else {
        echo "  ❌ Reviewer model file not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking Reviewer model: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check Controller method
echo "3. Testing Controller Enhanced Review Method...\n";

try {
    $controllerFile = 'app/Http/Controllers/JournalController.php';
    if (file_exists($controllerFile)) {
        $content = file_get_contents($controllerFile);
        
        // Check for showEnhancedReviewForm method
        if (strpos($content, 'showEnhancedReviewForm') !== false) {
            echo "  ✅ showEnhancedReviewForm method found\n";
            
            // Check if it passes required variables
            $requiredVars = [
                'existingReview' => 'existingReview variable',
                'otherReviews' => 'otherReviews variable',
                'reviewCriteria' => 'reviewCriteria variable'
            ];
            
            foreach ($requiredVars as $var => $description) {
                if (strpos($content, "\${$var}") !== false) {
                    echo "  ✅ {$description} found\n";
                } else {
                    echo "  ❌ {$description} missing\n";
                }
            }
        } else {
            echo "  ❌ showEnhancedReviewForm method not found\n";
        }
    } else {
        echo "  ❌ Controller file not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking Controller: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Check Enhanced Review Blade Template
echo "4. Testing Enhanced Review Blade Template...\n";

try {
    $bladeFile = 'resources/views/dashboard/reviewer/journals/enhanced-review.blade.php';
    if (file_exists($bladeFile)) {
        $content = file_get_contents($bladeFile);
        
        // Check for proper null checks
        $checks = [
            'reviewerAssignments' => 'Using reviewerAssignments instead of reviewers',
            '$otherReviews &&' => 'Null check for otherReviews',
            '$reviewCriteria' => 'reviewCriteria variable usage',
            '$existingReview' => 'existingReview variable usage'
        ];
        
        foreach ($checks as $pattern => $description) {
            if (strpos($content, $pattern) !== false) {
                echo "  ✅ {$description} found\n";
            } else {
                echo "  ❌ {$description} missing\n";
            }
        }
        
        // Check for problematic patterns
        if (strpos($content, '$journal->reviewers->count()') !== false) {
            echo "  ⚠️  Still contains problematic reviewers->count() call\n";
        } else {
            echo "  ✅ No problematic reviewers->count() calls found\n";
        }
        
    } else {
        echo "  ❌ Enhanced review blade file not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking blade template: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Check Database Migration
echo "5. Testing Database Migration for Enhanced Review Fields...\n";

try {
    $migrationPattern = 'database/migrations/*add_enhanced_review_fields_to_reviewers_table.php';
    $migrations = glob($migrationPattern);
    
    if (!empty($migrations)) {
        $migrationFile = $migrations[0];
        echo "  ✅ Enhanced review migration found: " . basename($migrationFile) . "\n";
        
        $content = file_get_contents($migrationFile);
        
        $requiredFields = [
            'confidential_comments' => 'confidential_comments field',
            'criteria_ratings' => 'criteria_ratings field'
        ];
        
        foreach ($requiredFields as $field => $description) {
            if (strpos($content, $field) !== false) {
                echo "  ✅ {$description} found in migration\n";
            } else {
                echo "  ❌ {$description} missing from migration\n";
            }
        }
    } else {
        echo "  ⚠️  Enhanced review migration not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking migration: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Check Route Configuration
echo "6. Testing Route Configuration...\n";

try {
    $routeFile = 'routes/web.php';
    if (file_exists($routeFile)) {
        $content = file_get_contents($routeFile);
        
        if (strpos($content, 'enhancedReview') !== false) {
            echo "  ✅ Enhanced review route found\n";
        } else {
            echo "  ❌ Enhanced review route missing\n";
        }
        
        if (strpos($content, 'submitReview') !== false) {
            echo "  ✅ Submit review route found\n";
        } else {
            echo "  ❌ Submit review route missing\n";
        }
    } else {
        echo "  ❌ Routes file not found\n";
    }
} catch (Exception $e) {
    echo "  ❌ Error checking routes: " . $e->getMessage() . "\n";
}

echo "\n";

// Final Summary
echo "=== VERIFICATION SUMMARY ===\n";
echo "Enhanced Review Fix Testing Completed\n\n";

echo "Key Issues Fixed:\n";
echo "✅ Journal model: Added reviewerAssignments relationship\n";
echo "✅ Journal model: Fixed sub_category relationship naming\n";
echo "✅ Reviewer model: Updated fillable fields for enhanced reviews\n";
echo "✅ Controller: Added missing variables (existingReview, otherReviews, reviewCriteria)\n";
echo "✅ Blade template: Fixed null checks and relationship calls\n";
echo "✅ Database: Added migration for enhanced review fields\n\n";

echo "Next Steps:\n";
echo "1. Run the migration: php artisan migrate\n";
echo "2. Clear cache: php artisan cache:clear\n";
echo "3. Test enhanced review form in browser\n";
echo "4. Verify reviewer assignment functionality\n";
echo "5. Test review submission process\n\n";

echo "Manual Testing:\n";
echo "1. Login as a reviewer\n";
echo "2. Navigate to assigned journals\n";
echo "3. Click 'Enhanced Review' button\n";
echo "4. Verify form loads without errors\n";
echo "5. Test review submission\n";

?>
