<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed admin user

        $user = new \App\Models\User();
        $user->fullname = 'Admin User';
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->country = 'Nigeria';
        $user->password = bcrypt('password');
        $user->avatar = 'https://via.placeholder.com/150';
        $user->email_verified_at = now();
        $user->save();
        $user->assignRole('Admin');

        // Seed editor user
        $editor = new \App\Models\User();
        $editor->fullname = 'Editor User';
        $editor->username = 'editor';
        $editor->email = 'editor@example.com';
        $editor->country = 'Nigeria';
        $editor->password = bcrypt('password');
        $editor->avatar = 'https://via.placeholder.com/150';
        $editor->email_verified_at = now();
        $editor->save();
        $editor->assignRole('Editor');

        // Seed author user
        $author = new \App\Models\User();
        $author->fullname = 'Author User';
        $author->username = 'author';
        $author->email = 'author@example.com';
        $author->country = 'Nigeria';
        $author->password = bcrypt('password');
        $author->avatar = 'https://via.placeholder.com/150';
        $author->email_verified_at = now();
        $author->save();
        $author->assignRole('Author');

    }
}
