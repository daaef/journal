<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get all subcategories and create subsubcategories for each subcategory
        $subcategories = \App\Models\SubCategory::all();
        foreach ($subcategories as $subcategory) {
            
            // Check if subsubcategory already exists for this subcategory
            $existingSubSubCategory = \App\Models\SubSubCategory::where('sub_category_id', $subcategory->id)
                ->where('slug', Str::slug($subcategory->name, '-'))
                ->first();
                
            if (!$existingSubSubCategory) {
                \App\Models\SubSubCategory::create([
                    'sub_category_id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'slug' => Str::slug($subcategory->name, '-'),
                    'uuid' => Str::uuid(),
                    'description' => 'Sub-subcategory for ' . $subcategory->name . ' related submissions.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "Created sub-subcategory: {$subcategory->name}\n";
            } else {
                echo "Sub-subcategory already exists: {$subcategory->name}\n";
            }
        }
    }
}
