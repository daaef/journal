<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserInterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed user interests data here
        // For example:
        \App\Models\UserInterest::create([
            'user_id' => 1,
            'interests' => 1,
        ]);
    }
}
