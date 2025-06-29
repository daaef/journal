<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class ReviewersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Associate Editor 1
        $afeEditor = User::firstOrCreate(
            ['email' => 'afe@example.com'],
            [
                'fullname' => 'Afe Editor',
                'username' => 'afe_editor',
                'country' => 'Nigeria',
                'password' => bcrypt('password'),
                'uuid' => Str::uuid(),
                'avatar' => 'https://via.placeholder.com/150',
                'email_verified_at' => now(),
                'is_first_login' => true,
                'is_active' => true,
            ]
        );
        $afeEditor->assignRole('Associate Editor');

        // Create Associate Editor 2
        $naniEditor = User::firstOrCreate(
            ['email' => 'nani@example.com'],
            [
                'fullname' => 'Nani Editor',
                'username' => 'nani',
                'country' => 'Nigeria',
                'password' => bcrypt('password'),
                'uuid' => Str::uuid(),
                'avatar' => 'https://via.placeholder.com/150',
                'email_verified_at' => now(),
                'is_first_login' => true,
                'is_active' => true,
            ]
        );
        $naniEditor->assignRole('Associate Editor');

        // Find or create Managing Editor (likely already exists from another seeder)
        $managingEditor = User::firstOrCreate(
            ['email' => 'managing@example.com'],
            [
                'fullname' => 'Managing Editor',
                'username' => 'managing_editor',
                'country' => 'Nigeria',
                'password' => bcrypt('password'),
                'uuid' => Str::uuid(),
                'avatar' => 'https://via.placeholder.com/150',
                'email_verified_at' => now(),
                'is_first_login' => true,
                'is_active' => true,
            ]
        );

        // Ensure the Managing Editor role is assigned
        if (!$managingEditor->hasRole('Managing Editor')) {
            $managingEditor->assignRole('Managing Editor');
        }
    }
}
