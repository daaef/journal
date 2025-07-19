<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Journal;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class TestJournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a regular user for journal creation
        $user = User::where('email', '!=', 'admin@example.com')->first();
        
        if (!$user) {
            $this->command->error('No regular user found. Please create a user first.');
            return;
        }

        // Get categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run the category seeder first.');
            return;
        }

        // Create test journals with different regions and categories
        $testJournals = [
            [
                'title' => 'Agricultural Innovations in West Africa: A Comprehensive Review',
                'description' => 'This study examines modern agricultural practices and innovations across West African countries, focusing on sustainable farming methods and crop improvement techniques.',
                'country' => 'Nigeria',
                'category_id' => $categories->where('name', 'Agriculture')->first()->id ?? $categories->first()->id,
                'abstract' => 'This comprehensive review explores agricultural innovations in West Africa, examining sustainable farming practices, crop improvement techniques, and the impact of climate change on agricultural productivity.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Public Health Challenges in East African Urban Centers',
                'description' => 'An analysis of public health issues and healthcare delivery systems in major East African cities, with recommendations for improvement.',
                'country' => 'Kenya',
                'category_id' => $categories->where('name', 'Medicine')->first()->id ?? $categories->first()->id,
                'abstract' => 'This study analyzes public health challenges in East African urban centers, examining healthcare delivery systems, disease prevention strategies, and recommendations for improving public health outcomes.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Renewable Energy Development in North Africa: Opportunities and Challenges',
                'description' => 'A technical analysis of renewable energy projects and infrastructure development in North African countries.',
                'country' => 'Egypt',
                'category_id' => $categories->where('name', 'Engineering')->first()->id ?? $categories->first()->id,
                'abstract' => 'This technical analysis examines renewable energy development in North Africa, exploring opportunities and challenges in solar, wind, and hydroelectric power generation.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Educational Policy Reform in Southern Africa: A Comparative Study',
                'description' => 'Comparative analysis of educational policies and reforms across Southern African countries, focusing on access, quality, and outcomes.',
                'country' => 'South Africa',
                'category_id' => $categories->where('name', 'Education')->first()->id ?? $categories->first()->id,
                'abstract' => 'This comparative study analyzes educational policy reforms in Southern Africa, examining access, quality, and outcomes across different countries in the region.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Digital Transformation in North American Business: Trends and Implications',
                'description' => 'Analysis of digital transformation trends in North American businesses and their implications for economic growth and competitiveness.',
                'country' => 'United States',
                'category_id' => $categories->where('name', 'Business')->first()->id ?? $categories->first()->id,
                'abstract' => 'This analysis examines digital transformation trends in North American businesses, exploring implications for economic growth, competitiveness, and future business models.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Environmental Science Research in Asian Ecosystems: Biodiversity and Conservation',
                'description' => 'Comprehensive study of biodiversity and conservation efforts in Asian ecosystems, with focus on environmental science and sustainability.',
                'country' => 'China',
                'category_id' => $categories->where('name', 'Natural Sciences')->first()->id ?? $categories->first()->id,
                'abstract' => 'This comprehensive study examines biodiversity and conservation efforts in Asian ecosystems, focusing on environmental science, sustainability, and the impact of human activities on natural habitats.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Tropical Agriculture and Biodiversity Conservation in South America',
                'description' => 'Study of tropical agriculture practices and their relationship with biodiversity conservation in South American ecosystems.',
                'country' => 'Brazil',
                'category_id' => $categories->where('name', 'Agriculture')->first()->id ?? $categories->first()->id,
                'abstract' => 'This study explores tropical agriculture practices and their relationship with biodiversity conservation in South American ecosystems, examining sustainable farming methods and their impact on local biodiversity.',
                'approval_status' => 'pending'
            ],
            [
                'title' => 'Clinical Trials and Public Health Policy in European Healthcare Systems',
                'description' => 'Analysis of clinical trial methodologies and their influence on public health policy development in European healthcare systems.',
                'country' => 'United Kingdom',
                'category_id' => $categories->where('name', 'Medicine')->first()->id ?? $categories->first()->id,
                'abstract' => 'This analysis examines clinical trial methodologies and their influence on public health policy development in European healthcare systems, exploring the relationship between research and policy implementation.',
                'approval_status' => 'pending'
            ]
        ];

        foreach ($testJournals as $journal) {
            $newJournal = Journal::create([
                'title' => $journal['title'],
                'author' => $user->fullname,
                'description' => $journal['description'],
                'slug' => Str::slug($journal['title']),
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'category_id' => $journal['category_id'],
                'abstract' => $journal['abstract'],
                'approval_status' => $journal['approval_status'],
                'is_active' => true,
                'is_draft' => false,
                'country' => $journal['country'],
                'created_by' => json_encode(['user_id' => $user->id, 'name' => $user->name]),
                'meta_title' => $journal['title'],
                'meta_description' => $journal['description'],
                'meta_keywords' => json_encode(['agriculture', 'health', 'education', 'technology', 'science']),
                'license' => json_encode(['type' => 'CC BY 4.0', 'url' => 'https://creativecommons.org/licenses/by/4.0/']),
                'institution' => $user->institution ?? 'Test Institution',
                'journal_format' => 'research_paper',
                'journal_language' => 'English',
                'agree' => true,
                'accept' => true
            ]);

            $this->command->info("Created Journal: {$journal['title']} - {$journal['country']}");
        }

        $this->command->info('Test Journal seeding completed successfully!');
    }
} 