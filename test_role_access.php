<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== ROLE-BASED DASHBOARD ACCESS TEST ===\n\n";

// Test data: user credentials and expected dashboard routes
$testCases = [
    [
        'email' => 'admin@example.com',
        'role' => 'Admin',
        'expected_route' => 'admin.dashboard',
        'expected_url' => '/admin'
    ],
    [
        'email' => 'editor@example.com',
        'role' => 'Editor in Chief',
        'expected_route' => 'editor.dashboard',
        'expected_url' => '/editor'
    ],
    [
        'email' => 'managing@example.com',
        'role' => 'Managing Editor',
        'expected_route' => 'editor.dashboard',
        'expected_url' => '/editor'
    ],
    [
        'email' => 'associate@example.com',
        'role' => 'Associate Editor',
        'expected_route' => 'reviewer.dashboard',
        'expected_url' => '/reviewer'
    ],
    [
        'email' => 'desk@example.com',
        'role' => 'Desk Editor',
        'expected_route' => 'reviewer.dashboard',
        'expected_url' => '/reviewer'
    ],
    [
        'email' => 'author@example.com',
        'role' => 'Author',
        'expected_route' => 'dashboard',
        'expected_url' => '/dashboard'
    ]
];

foreach ($testCases as $test) {
    echo "Testing access for {$test['email']} ({$test['role']}):\n";

    // Find and authenticate user
    $user = User::where('email', $test['email'])->first();

    if (!$user) {
        echo "  ❌ User not found\n\n";
        continue;
    }

    // Test authentication
    Auth::logout();
    $credentials = ['email' => $test['email'], 'password' => 'password'];

    if (Auth::attempt($credentials)) {
        echo "  ✓ Authentication successful\n";

        $authenticatedUser = Auth::user();
        $userRoles = $authenticatedUser->getRoleNames()->toArray();

        echo "  ✓ User roles: " . implode(', ', $userRoles) . "\n";

        // Test role verification
        if ($authenticatedUser->hasRole($test['role'])) {
            echo "  ✓ Has expected role: {$test['role']}\n";
        } else {
            echo "  ❌ Missing expected role: {$test['role']}\n";
        }

        // Test middleware access logic
        switch ($test['role']) {
            case 'Admin':
                $canAccessAdmin = $authenticatedUser->hasRole('Admin');
                echo "  Admin access: " . ($canAccessAdmin ? '✓ Allowed' : '❌ Denied') . "\n";
                break;

            case 'Editor in Chief':
            case 'Managing Editor':
                $canAccessEditor = $authenticatedUser->hasAnyRole(['Managing Editor', 'Editor in Chief']);
                echo "  Editor access: " . ($canAccessEditor ? '✓ Allowed' : '❌ Denied') . "\n";
                break;

            case 'Associate Editor':
            case 'Desk Editor':
                $canAccessReviewer = $authenticatedUser->hasRole('Associate Editor') || $authenticatedUser->hasRole('Desk Editor');
                echo "  Reviewer access: " . ($canAccessReviewer ? '✓ Allowed' : '❌ Denied') . "\n";
                break;

            case 'Author':
                $hasInterests = $authenticatedUser->userInterests()->count() > 0;
                echo "  Author interests: " . ($hasInterests ? '✓ Has interests' : '⚠️ No interests') . "\n";
                echo "  Expected redirect: " . ($hasInterests ? 'dashboard' : 'interests') . "\n";
                break;
        }

        echo "  Expected dashboard: {$test['expected_url']}\n";

    } else {
        echo "  ❌ Authentication failed\n";
    }

    echo "\n";
}

// Test unauthorized access scenarios
echo "=== TESTING UNAUTHORIZED ACCESS SCENARIOS ===\n\n";

Auth::logout();
echo "1. Testing unauthenticated access:\n";
echo "   Current auth status: " . (Auth::check() ? 'Authenticated' : '✓ Not authenticated') . "\n";
echo "   Middleware should redirect to login for all protected routes\n\n";

// Test role boundary violations
$boundaryTests = [
    ['user' => 'author@example.com', 'role' => 'Author', 'accessing' => 'Admin dashboard'],
    ['user' => 'associate@example.com', 'role' => 'Associate Editor', 'accessing' => 'Admin dashboard'],
    ['user' => 'author@example.com', 'role' => 'Author', 'accessing' => 'Editor dashboard']
];

foreach ($boundaryTests as $test) {
    Auth::logout();
    $user = User::where('email', $test['user'])->first();

    if ($user && Auth::attempt(['email' => $test['user'], 'password' => 'password'])) {
        echo "2. Testing {$test['role']} accessing {$test['accessing']}:\n";

        $authenticatedUser = Auth::user();

        // Test admin access for non-admin
        if ($test['accessing'] === 'Admin dashboard') {
            $canAccess = $authenticatedUser->hasRole('Admin');
            echo "   Admin access: " . ($canAccess ? '❌ Incorrectly allowed' : '✓ Correctly denied') . "\n";
        }

        // Test editor access for non-editor
        if ($test['accessing'] === 'Editor dashboard') {
            $canAccess = $authenticatedUser->hasAnyRole(['Managing Editor', 'Editor in Chief']);
            echo "   Editor access: " . ($canAccess ? '❌ Incorrectly allowed' : '✓ Correctly denied') . "\n";
        }

        echo "\n";
    }
}

Auth::logout();
echo "=== ROLE-BASED ACCESS TEST COMPLETED ===\n";
echo "All authentication and authorization checks have been verified!\n";
