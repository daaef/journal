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
            CountriesTableSeeder::class,
            // JournalsTableSeeder::class,
            ReviewersTableSeeder::class,
            AssociateEditorSeeder::class,
            TestJournalSeeder::class,
        ]);

        // Generate PDFs for all seeded journals as the final step
        $this->command->info('Generating PDFs for all seeded journals...');
        \Artisan::call('journals:generate-abstracts-pdfs');
        $this->command->info('PDF generation completed!');
    }
}
