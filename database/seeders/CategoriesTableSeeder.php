<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create seeder for journal categories iwht name and description

        $categories = [
            'Computer Science',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Medicine',
            'Engineering',
            'Agriculture',
            'Economics',
            'Law',
            'Education',
            'Arts',
            'Social Sciences',
            'Humanities',
            'Environmental Sciences',
            'Management',
            'Accounting',
            'Finance',
            'Marketing',
            'Business Administration',
            'Public Administration',
            'Political Science',
            'International Relations',
            'History',
            'Geography',
            'Philosophy',
            'Religion',
            'Library and Information Science',
            'Mass Communication',
            'Psychology',
            'Sociology',
            'Anthropology',
            'Archaeology',
            'Linguistics',
            'Literature',
            'Performing Arts',
            'Visual Arts',
            'Music',
            'Film Studies',
            'Dance',
            'Sports',
            'Tourism',
            'Hospitality',
            'Culinary Arts',
            'Fashion',
            'Textile',
            'Architecture',
            'Urban Planning',
            'Genetic Engineering',
            'Industrial Engineering',
            'Rural Planning',
            'Transportation`',
            'Communication Engineering',
            'Computer Engineering',
            'Electrical Engineering',
            'Mechanical Engineering',
            'Civil Engineering',
            'Chemical Engineering',
            'Petroleum Engineering',
            'Mining Engineering',
            'Metallurgical Engineering',
            'Materials Engineering',
            'Biomedical Engineering',
            'Manufacturing Engineering',
            'Textile Engineering',
            'Aerospace Engineering',
            'Nuclear Engineering',
            'Marine Engineering',
            'Ocean Engineering',
            'Water Resources Engineering',
            'Geotechnical Engineering',
            'Structural Engineering',
            'Transportation` Engineering',
            'Surveying Engineering',
            'Urban Engineering',
            'Regional Engineering',
            'Rural Engineering',
            'Environmental Engineering',
            'Agricultural Engineering',
            'Food Engineering',
            'Biological Engineering',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
                'slug' => Str::slug($category, '-'),
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
