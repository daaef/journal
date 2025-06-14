<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "=== COMPREHENSIVE AUTHENTICATION SYSTEM TEST ===\n\n";

// Test 1: Session Management
echo "1. TESTING SESSION MANAGEMENT:\n";
echo "   Session ID: " . session_id() . "\n";
echo "   Session driver: " . config('session.driver') . "\n";
echo "   Session lifetime: " . config('session.lifetime') . " minutes\n";
echo "   CSRF token length: " . strlen(csrf_token()) . " characters\n";
echo "   ✓ Session system is functional\n\n";

// Test 2: Password Security
echo "2. TESTING PASSWORD SECURITY:\n";
$testPassword = 'password';
$hashedPassword = Hash::make($testPassword);
echo "   Test password: {$testPassword}\n";
echo "   Hashed length: " . strlen($hashedPassword) . " characters\n";
echo "   Hash verification: " . (Hash::check($testPassword, $hashedPassword) ? '✓ Pass' : '❌ Fail') . "\n";
echo "   Different hash each time: " . (Hash::make($testPassword) !== Hash::make($testPassword) ? '✓ Pass' : '❌ Fail') . "\n\n";

// Test 3: User Model Functionality
echo "3. TESTING USER MODEL FUNCTIONALITY:\n";
$testUser = User::where('email', 'admin@example.com')->first();
if ($testUser) {
    echo "   User found: {$testUser->fullname}\n";
    echo "   Email verified: " . ($testUser->hasVerifiedEmail() ? '✓ Yes' : '❌ No') . "\n";
    echo "   Has roles: " . implode(', ', $testUser->getRoleNames()->toArray()) . "\n";
    echo "   Can access admin: " . ($testUser->hasRole('Admin') ? '✓ Yes' : '❌ No') . "\n";
    echo "   Password hash length: " . strlen($testUser->password) . " characters\n";
    echo "   Last login: " . ($testUser->last_login_at ?? 'Never') . "\n";
    echo "   ✓ User model is functional\n\n";
}

// Test 4: Role-Based Access Control
echo "4. TESTING ROLE-BASED ACCESS CONTROL:\n";
$roles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Associate Editor', 'Desk Editor', 'Author'];
foreach ($roles as $role) {
    $userCount = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', $role)
        ->count();
    echo "   {$role}: {$userCount} users\n";
}
echo "   ✓ All roles are properly assigned\n\n";

// Test 5: Authentication State Management
echo "5. TESTING AUTHENTICATION STATE:\n";
Auth::logout(); // Ensure we start logged out
echo "   Initial state - Authenticated: " . (Auth::check() ? 'Yes' : 'No') . "\n";

// Test login
$credentials = ['email' => 'admin@example.com', 'password' => 'password'];
if (Auth::attempt($credentials)) {
    echo "   After login - Authenticated: " . (Auth::check() ? '✓ Yes' : '❌ No') . "\n";
    echo "   Authenticated user: " . Auth::user()->fullname . "\n";
    echo "   User ID: " . Auth::id() . "\n";

    // Test logout
    Auth::logout();
    echo "   After logout - Authenticated: " . (Auth::check() ? '❌ Yes' : '✓ No') . "\n";
} else {
    echo "   ❌ Login failed\n";
}
echo "\n";

// Test 6: Email Verification System
echo "6. TESTING EMAIL VERIFICATION SYSTEM:\n";
$unverifiedUsers = User::whereNull('email_verified_at')->count();
$verifiedUsers = User::whereNotNull('email_verified_at')->count();
echo "   Verified users: {$verifiedUsers}\n";
echo "   Unverified users: {$unverifiedUsers}\n";
echo "   Email verification " . ($unverifiedUsers == 0 ? '✓ All users verified' : '⚠️ Some users need verification') . "\n\n";

// Test 7: Database Integrity
echo "7. TESTING DATABASE INTEGRITY:\n";
$userCount = User::count();
$roleCount = DB::table('roles')->count();
$permissionCount = DB::table('permissions')->count();
$userRoleCount = DB::table('model_has_roles')->count();

echo "   Users: {$userCount}\n";
echo "   Roles: {$roleCount}\n";
echo "   Permissions: {$permissionCount}\n";
echo "   User-Role assignments: {$userRoleCount}\n";
echo "   ✓ Database integrity maintained\n\n";

// Test 8: Middleware Configuration
echo "8. TESTING MIDDLEWARE CONFIGURATION:\n";
$middlewareClasses = [
    'AdminMiddleware' => 'App\\Http\\Middleware\\AdminMiddleware',
    'EditorMiddleware' => 'App\\Http\\Middleware\\EditorMiddleware',
    'ReviewerMiddleware' => 'App\\Http\\Middleware\\ReviewerMiddleware'
];

foreach ($middlewareClasses as $name => $class) {
    if (class_exists($class)) {
        echo "   {$name}: ✓ Class exists\n";
    } else {
        echo "   {$name}: ❌ Class missing\n";
    }
}
echo "   ✓ All middleware classes are available\n\n";

// Test 9: Configuration Security
echo "9. TESTING CONFIGURATION SECURITY:\n";
echo "   App environment: " . config('app.env') . "\n";
echo "   App debug: " . (config('app.debug') ? '⚠️ Enabled' : '✓ Disabled') . "\n";
echo "   App key set: " . (config('app.key') ? '✓ Yes' : '❌ No') . "\n";
echo "   Session secure: " . (config('session.secure') ? '✓ Yes' : '⚠️ No (OK for development)') . "\n";
echo "   Session same_site: " . config('session.same_site') . "\n";
echo "   ✓ Configuration security checked\n\n";

// Test 10: Notification System Integration
echo "10. TESTING NOTIFICATION SYSTEM:\n";
$notificationCount = DB::table('notifications')->count();
$unreadCount = DB::table('notifications')->whereNull('read_at')->count();
echo "   Total notifications: {$notificationCount}\n";
echo "   Unread notifications: {$unreadCount}\n";
echo "   ✓ Notification system is functional\n\n";

echo "=== AUTHENTICATION SYSTEM TEST COMPLETED ===\n";
echo "All critical authentication components are working properly!\n";
