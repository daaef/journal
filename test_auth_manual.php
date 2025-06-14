<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== TESTING AUTHENTICATION MANUALLY ===\n\n";

// Test credentials for each user type
$testUsers = [
    ['email' => 'admin@example.com', 'role' => 'Admin'],
    ['email' => 'editor@example.com', 'role' => 'Editor in Chief'],
    ['email' => 'author@example.com', 'role' => 'Author'],
    ['email' => 'associate@example.com', 'role' => 'Associate Editor'],
    ['email' => 'managing@example.com', 'role' => 'Managing Editor']
];

foreach ($testUsers as $testUser) {
    echo "Testing login for {$testUser['email']} ({$testUser['role']}):\n";
    
    // Find the user
    $user = User::where('email', $testUser['email'])->first();
    
    if (!$user) {
        echo "  ❌ User not found\n\n";
        continue;
    }
    
    echo "  ✓ User found: {$user->fullname}\n";
    echo "  ✓ Email verified: " . ($user->hasVerifiedEmail() ? 'Yes' : 'No') . "\n";
    
    // Check if user has the expected role
    $userRoles = $user->getRoleNames()->toArray();
    echo "  ✓ User roles: " . implode(', ', $userRoles) . "\n";
    
    if ($user->hasRole($testUser['role'])) {
        echo "  ✓ Has expected role: {$testUser['role']}\n";
    } else {
        echo "  ❌ Missing expected role: {$testUser['role']}\n";
    }
    
    // Test password (assuming password is 'password' for all test users)
    if (Hash::check('password', $user->password)) {
        echo "  ✓ Password verification successful\n";
    } else {
        echo "  ❌ Password verification failed\n";
    }
    
    // Test authentication attempt
    $credentials = ['email' => $testUser['email'], 'password' => 'password'];
    
    if (Auth::attempt($credentials)) {
        $authenticatedUser = Auth::user();
        echo "  ✓ Authentication successful for: {$authenticatedUser->fullname}\n";
        
        // Test role-based redirect logic
        if ($authenticatedUser->hasRole('Admin')) {
            echo "  ✓ Should redirect to: admin.dashboard\n";
        } elseif ($authenticatedUser->hasRole('Managing Editor') || $authenticatedUser->hasRole('Editor in Chief')) {
            echo "  ✓ Should redirect to: editor.dashboard\n";
        } elseif ($authenticatedUser->hasRole('Associate Editor') || $authenticatedUser->hasRole('Desk Editor')) {
            echo "  ✓ Should redirect to: reviewer.dashboard\n";
        } elseif ($authenticatedUser->hasRole('Author')) {
            $interests = $authenticatedUser->userInterests()->count();
            if ($interests > 0) {
                echo "  ✓ Should redirect to: dashboard (Author has {$interests} interests)\n";
            } else {
                echo "  ✓ Should redirect to: interests (Author has no interests)\n";
            }
        }
        
        // Logout to test next user
        Auth::logout();
    } else {
        echo "  ❌ Authentication failed\n";
    }
    
    echo "\n";
}

echo "=== TESTING MIDDLEWARE PROTECTION ===\n\n";

// Test middleware without authentication
Auth::logout();
echo "Current user authenticated: " . (Auth::check() ? 'Yes' : 'No') . "\n";

if (!Auth::check()) {
    echo "✓ Not authenticated - middleware should block access to protected routes\n";
}

echo "\nAuthentication test completed!\n";
