<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user if it doesn't exist
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'fullname' => 'Test User',
                'phone' => '1234567890',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role if it exists
        if (Role::where('name', 'Admin')->exists()) {
            $testUser->assignRole('Admin');
        }

        echo "Test user created/updated: test@example.com / password123\n";
    }
}
