<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\Journal;
use App\Services\ExpertiseService;

class TestRegionalExpertise extends Command
{
    protected $signature = 'test:regional-expertise';
    protected $description = 'Test the regional expertise system';

    public function handle()
    {
        $this->info('=== REGIONAL EXPERTISE SYSTEM TEST ===');

        // Test 1: Check countries and regions
        $this->info("\n1. Database Population:");
        $this->info("   Countries: " . Country::count());
        $this->info("   Regions: " . Region::count());

        // Test 2: Check users and roles
        $this->info("\n2. User Roles:");
        $users = User::all();
        foreach ($users as $user) {
            $roles = $user->getRoleNames()->implode(', ');
            $this->info("   {$user->fullname}: {$roles}");
        }

        // Test 3: Check Associate Editors
        $associateEditors = User::role('Associate Editor')->get();
        $this->info("\n3. Associate Editors: " . $associateEditors->count());
        foreach ($associateEditors as $editor) {
            $this->info("   - {$editor->fullname} ({$editor->email})");
        }

        // Test 4: Test expertise service
        $this->info("\n4. Expertise Service Test:");
        $expertiseService = new ExpertiseService();
        $categories = $expertiseService->getExpertiseCategories();
        $this->info("   Regional categories: " . count($categories['regional']));
        $this->info("   Research areas: " . count($categories['research_areas']));

        // Test 5: Check if we have any journals to test with
        $journals = Journal::all();
        $this->info("\n5. Available Journals: " . $journals->count());
        
        if ($journals->count() > 0) {
            $journal = $journals->first();
            $this->info("   Testing with journal: {$journal->title}");
            $this->info("   Author country: {$journal->country}");
            $this->info("   Category: {$journal->category->name}");
            
            // Test optimal reviewers
            $optimalReviewers = $expertiseService->getOptimalReviewers($journal, 5);
            $this->info("   Optimal reviewers found: " . $optimalReviewers->count());
        }

        // Test 6: Regional statistics
        $this->info("\n6. Regional Statistics:");
        $regionalStats = $expertiseService->getReviewerStatisticsByRegion();
        foreach ($regionalStats as $region => $stats) {
            $this->info("   {$region}: {$stats['available_reviewers']} available reviewers");
        }

        $this->info("\n=== TEST COMPLETE ===");
        
        if ($associateEditors->count() > 0 && $journals->count() > 0) {
            $this->info("✅ System is ready for testing!");
            $this->info("Visit: /editor/regional-assignment/{journal_uuid}");
        } else {
            $this->warn("⚠️  Need Associate Editors and Journals to test fully");
        }

        return 0;
    }
} 