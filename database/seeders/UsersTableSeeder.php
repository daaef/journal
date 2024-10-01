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
        $user->uuid = \Illuminate\Support\Str::uuid();
        $user->avatar = 'https://via.placeholder.com/150';
        $user->email_verified_at = now();
        $user->is_first_login = true;
        $user->is_active = true;
        $user->save();
        $user->assignRole('Admin');

        // Seed editor user
        $editor = new \App\Models\User();
        $editor->fullname = 'Editor User';
        $editor->username = 'editor';
        $editor->email = 'editor@example.com';
        $editor->country = 'Nigeria';
        $editor->password = bcrypt('password');
        $editor->uuid = \Illuminate\Support\Str::uuid();
        $editor->avatar = 'https://via.placeholder.com/150';
        $editor->email_verified_at = now();
        $editor->is_first_login = true;
        $editor->is_active = true;
        $editor->save();
        $editor->assignRole('Editor');

        // Seed author user
        $author = new \App\Models\User();
        $author->fullname = 'Author User';
        $author->username = 'author';
        $author->email = 'author@example.com';
        $author->country = 'Nigeria';
        $author->password = bcrypt('password');
        $author->uuid = \Illuminate\Support\Str::uuid();
        $author->avatar = 'https://via.placeholder.com/150';
        $author->email_verified_at = now();
        $author->is_first_login = true;
        $author->is_active = true;
        $author->save();
        $author->assignRole('Author');

        // Seed Publisher user
        $publisher = new \App\Models\User();
        $publisher->fullname = 'Publisher User';
        $publisher->username = 'publisher';
        $publisher->email = 'publisher@example.com';
        $publisher->country = 'Nigeria';
        $publisher->password = bcrypt('password');
        $publisher->uuid = \Illuminate\Support\Str::uuid();
        $publisher->avatar = 'https://via.placeholder.com/150';
        $publisher->email_verified_at = now();
        $publisher->is_first_login = true;
        $publisher->is_active = true;
        $publisher->save();
        $publisher->assignRole('Publisher');

    }
}
