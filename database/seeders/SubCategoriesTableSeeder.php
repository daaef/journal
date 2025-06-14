<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

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
            
            // Check if subcategory already exists for this category
            $existingSubCategory = \App\Models\SubCategory::where('category_id', $category->id)
                ->where('slug', Str::slug($category->name, '-'))
                ->first();
                
            if (!$existingSubCategory) {
                \App\Models\SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $category->name,
                    'slug' => Str::slug($category->name, '-'),
                    'uuid' => Str::uuid(),
                    'description' => 'Subcategory for ' . $category->name . ' related submissions.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "Created subcategory: {$category->name}\n";
            } else {
                echo "Subcategory already exists: {$category->name}\n";
            }
        }

    }
}
