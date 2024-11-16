<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleAndPermissionSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
            SubSubCategoriesSeeder::class,
            UsersTableSeeder::class,
            AfricanRegionsTableSeeder::class,
            // JournalsTableSeeder::class,
            ReviewersTableSeeder::class,
        ]);
    }
}
