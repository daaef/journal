<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING LOGIN FLOW FOR DIFFERENT USER ROLES ===\n\n";

// Get all users with their roles
$users = DB::table('users')
    ->select('users.id', 'users.fullname', 'users.email', 'users.email_verified_at', 'roles.name as role')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('model_has_roles.model_type', 'App\\Models\\User')
    ->get();

echo "Found " . count($users) . " users with roles:\n";
foreach ($users as $user) {
    $verified_status = $user->email_verified_at ? "✓ Verified" : "✗ Not Verified";
    echo "- {$user->fullname} ({$user->role}) - {$user->email} - {$verified_status}\n";
}

echo "\n=== CHECKING EMAIL VERIFICATION STATUS ===\n";

// Check email verification for each user
foreach ($users as $user) {
    if (!$user->email_verified_at) {
        echo "⚠️  User {$user->fullname} ({$user->email}) is not email verified - may cause login issues\n";
    }
}

echo "\n=== CHECKING ACTIVATION RECORDS ===\n";

// Check activation records
$activations = DB::table('activations')->get();
echo "Found " . count($activations) . " activation records:\n";
foreach ($activations as $activation) {
    echo "- Email: {$activation->email}, Code: {$activation->code}, Created: {$activation->created_at}\n";
}

echo "\n=== EXPECTED LOGIN REDIRECTIONS ===\n";

foreach ($users as $user) {
    echo "User: {$user->fullname} ({$user->role})\n";

    switch ($user->role) {
        case 'Admin':
            echo "  → Should redirect to: /admin (admin.dashboard)\n";
            break;
        case 'Managing Editor':
        case 'Editor in Chief':
            echo "  → Should redirect to: /editor (editor.dashboard)\n";
            break;
        case 'Associate Editor':
        case 'Desk Editor':
            echo "  → Should redirect to: /reviewer (reviewer.dashboard)\n";
            break;
        case 'Author':
            echo "  → Should redirect to: /dashboard (dashboard) or /interests if no interests set\n";
            // Check if user has interests
            $interests = DB::table('user_interests')->where('user_id', $user->id)->count();
            echo "    Interests count: {$interests}\n";
            break;
        default:
            echo "  → Default redirect to: /dashboard\n";
    }
    echo "\n";
}

echo "=== POTENTIAL ISSUES TO CHECK ===\n";

// Check for users without email verification
$unverified = DB::table('users')->whereNull('email_verified_at')->count();
if ($unverified > 0) {
    echo "⚠️  {$unverified} users are not email verified - they will be blocked from logging in\n";
}

// Check for authors without interests
$authorsWithoutInterests = DB::table('users')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->leftJoin('user_interests', 'users.id', '=', 'user_interests.user_id')
    ->where('roles.name', 'Author')
    ->whereNull('user_interests.user_id')
    ->count();

if ($authorsWithoutInterests > 0) {
    echo "⚠️  {$authorsWithoutInterests} authors don't have interests set - they will be redirected to interests page\n";
}

echo "\nTest completed!\n";
