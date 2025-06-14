<?php
// Set up Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Checking users in the system:\n";
echo "===============================\n";

try {
    $users = User::all(['email', 'fullname']);

    if ($users->count() > 0) {
        foreach ($users as $user) {
            echo "Email: " . $user->email . " | Name: " . $user->fullname . "\n";
        }
        echo "\nTotal users: " . $users->count() . "\n";
    } else {
        echo "No users found in the database.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
