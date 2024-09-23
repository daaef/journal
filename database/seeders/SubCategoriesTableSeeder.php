<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories and create subcategories for each category
        $categories = \App\Models\Category::all();
        foreach ($categories as $category) {

            // $word = fake()->word();
            \App\Models\SubCategory::create([
                'category_id' => $category->id,
                'name' => $category->name,
                'slug' => Str::slug($category->name, '-'),
                'uuid' => Str::uuid(),
                'description' => fake()->sentence(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
