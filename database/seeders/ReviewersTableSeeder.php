<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publisher = new \App\Models\User();
        $publisher->fullname = 'Afe Editor';
        $publisher->username = 'afe_editor';
        $publisher->email = 'afe@example.com';
        $publisher->country = 'Nigeria';
        $publisher->password = bcrypt('password');
        $publisher->uuid = \Illuminate\Support\Str::uuid();
        $publisher->avatar = 'https://via.placeholder.com/150';
        $publisher->email_verified_at = now();
        $publisher->is_first_login = true;
        $publisher->is_active = true;
        $publisher->save();
        $publisher->assignRole('Associate Editor');

        $publisher = new \App\Models\User();
        $publisher->fullname = 'Nani Editor';
        $publisher->username = 'nani';
        $publisher->email = 'nani@example.com';
        $publisher->country = 'Nigeria';
        $publisher->password = bcrypt('password');
        $publisher->uuid = \Illuminate\Support\Str::uuid();
        $publisher->avatar = 'https://via.placeholder.com/150';
        $publisher->email_verified_at = now();
        $publisher->is_first_login = true;
        $publisher->is_active = true;
        $publisher->save();
        $publisher->assignRole('Associate Editor');


        $publisher = new \App\Models\User();
        $publisher->fullname = 'Managing Editor';
        $publisher->username = 'managing_editor';
        $publisher->email = 'managing@example.com';
        $publisher->country = 'Nigeria';
        $publisher->password = bcrypt('password');
        $publisher->uuid = \Illuminate\Support\Str::uuid();
        $publisher->avatar = 'https://via.placeholder.com/150';
        $publisher->email_verified_at = now();
        $publisher->is_first_login = true;
        $publisher->is_active = true;
        $publisher->save();
        $publisher->assignRole('Managing Editor');
    }
}
