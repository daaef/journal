<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateManagingEditor extends Command
{
    protected $signature = 'user:create-managing-editor';
    protected $description = 'Create a Managing Editor user';

    public function handle()
    {
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

        $this->info('Managing Editor user created/updated: managing@example.com / password');
        $this->info('User ID: ' . $managingEditor->id);
        $this->info('Roles: ' . $managingEditor->roles->pluck('name')->implode(', '));
        
        return 0;
    }
}
