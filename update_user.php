<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::first();
if ($user) {
    $user->password = Hash::make('password123');
    $user->save();
    echo "Updated user: {$user->email} with password: password123\n";
} else {
    echo "No users found\n";
}
