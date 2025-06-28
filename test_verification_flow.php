<?php

/*
 * Test script to verify the 2FA verification flow
 * This script tests the edge cases in the verification process
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Repositories\Registration\EloquentRegistrationRepository;
use App\Models\User;
use App\Models\Activation;
use Illuminate\Http\Request;

echo "Testing Verification Flow Fixes\n";
echo "================================\n\n";

$repo = new EloquentRegistrationRepository();

// Test Case 1: User doesn't exist
echo "Test 1: User doesn't exist\n";
$request1 = new Request([
    'email' => 'nonexistent@example.com',
    'code' => '123456'
]);

$result1 = $repo->verifyAcount($request1);
echo "Result: " . ($result1 === false ? "PASS - Returns false" : "FAIL - Should return false") . "\n\n";

// Test Case 2: User exists but no activation record
echo "Test 2: User exists but no activation record\n";
// Create a user without activation record
$testUser = User::where('email', 'test-no-activation@example.com')->first();
if (!$testUser) {
    echo "Creating test user without activation record...\n";
    $testUser = User::create([
        'fullname' => 'Test User',
        'username' => 'test_no_activation',
        'email' => 'test-no-activation@example.com',
        'country' => 'Test Country',
        'institution' => 'Test Institution',
        'password' => bcrypt('password'),
        'uuid' => \Illuminate\Support\Str::uuid(),
    ]);
    $testUser->assignRole('Author');
}

$request2 = new Request([
    'email' => 'test-no-activation@example.com',
    'code' => '123456'
]);

$result2 = $repo->verifyAcount($request2);
echo "Result: " . ($result2 === false ? "PASS - Returns false" : "FAIL - Should return false") . "\n\n";

// Test Case 3: User and activation exist but wrong code
echo "Test 3: User and activation exist but wrong code\n";
$testUser2 = User::where('email', 'test-wrong-code@example.com')->first();
if (!$testUser2) {
    echo "Creating test user with activation record...\n";
    $testUser2 = User::create([
        'fullname' => 'Test User 2',
        'username' => 'test_wrong_code',
        'email' => 'test-wrong-code@example.com',
        'country' => 'Test Country',
        'institution' => 'Test Institution',
        'password' => bcrypt('password'),
        'uuid' => \Illuminate\Support\Str::uuid(),
    ]);
    $testUser2->assignRole('Author');
    
    // Create activation record
    $testUser2->activation()->create([
        'email' => $testUser2->email,
        'code' => '999999', // Correct code
        'uuid' => \Illuminate\Support\Str::uuid(),
    ]);
}

$request3 = new Request([
    'email' => 'test-wrong-code@example.com',
    'code' => '123456' // Wrong code
]);

$result3 = $repo->verifyAcount($request3);
echo "Result: " . ($result3 === false ? "PASS - Returns false for wrong code" : "FAIL - Should return false") . "\n\n";

// Test Case 4: Correct code (should pass)
echo "Test 4: Correct verification code\n";
$request4 = new Request([
    'email' => 'test-wrong-code@example.com',
    'code' => '999999' // Correct code
]);

$result4 = $repo->verifyAcount($request4);
echo "Result: " . ($result4 !== false ? "PASS - Returns user object for correct code" : "FAIL - Should return user") . "\n\n";

// Cleanup
echo "Cleaning up test data...\n";
$testUser?->delete();
$testUser2?->delete();

echo "Test completed!\n";
echo "\nSummary of fixes applied:\n";
echo "1. Added explicit handling for false return from verifyAcount() in controller\n";
echo "2. Added null checks for user and activation record in repository\n";
echo "3. Added proper error message feedback for incorrect verification codes\n";
echo "4. Added error message display in the activate.blade.php view\n";
echo "5. Added value preservation (old input) for the form\n";
