<?php
// Set up Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Checking user roles in the system:\n";
echo "===================================\n";

try {
    $users = User::all();

    foreach ($users as $user) {
        try {
            $roles = $user->roles()->pluck('name')->toArray();
            echo "Email: " . $user->email . " | Roles: " . (count($roles) > 0 ? implode(', ', $roles) : 'No roles assigned') . "\n";
        } catch (Exception $roleError) {
            echo "Email: " . $user->email . " | Error loading roles: " . $roleError->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
