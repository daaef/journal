<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class);

// Create Managing Editor user if it doesn't exist
$managingEditor = User::firstOrCreate(
    ['email' => 'managing@example.com'],
    [
        'fullname' => 'Managing Editor User',
        'username' => 'managing_editor',
        'country' => 'Nigeria',
        'password' => Hash::make('password'),
        'uuid' => \Illuminate\Support\Str::uuid(),
        'avatar' => 'https://via.placeholder.com/150',
        'email_verified_at' => now(),
        'is_first_login' => true,
        'is_active' => true,
    ]
);

// Assign Managing Editor role
$managingEditor->assignRole('Managing Editor');

echo "Managing Editor user created/updated: managing@example.com / password\n";
echo "User ID: " . $managingEditor->id . "\n";
echo "Roles: " . $managingEditor->roles->pluck('name')->implode(', ') . "\n";
