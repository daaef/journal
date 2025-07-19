<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Journal;
use App\Models\User;
use App\Repositories\Journal\EloquentJournalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class JournalRegionTest extends TestCase
{
    use RefreshDatabase;

    public function test_region_is_automatically_set_based_on_country()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create a request with country data
        $request = new Request([
            'title' => 'Test Journal',
            'author' => 'Test Author',
            'country' => 'Nigeria', // This should map to 'West Africa'
            'journal_language' => 'English',
            'abstract' => 'Test abstract',
            'description' => 'Test description',
            'user_id' => $user->id,
            'submit' => 'submit'
        ]);

        // Use the repository to create the journal
        $documentConversionService = app(\App\Services\DocumentConversionService::class);
        $repository = new EloquentJournalRepository($documentConversionService);
        $journal = $repository->create($request);

        // Verify the region was set correctly
        $this->assertEquals('West Africa', $journal->region);
    }

    public function test_region_is_null_for_unknown_country()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create a request with unknown country
        $request = new Request([
            'title' => 'Test Journal Unknown Country',
            'author' => 'Test Author',
            'country' => 'Unknown Country', // This should not map to any region
            'journal_language' => 'English',
            'abstract' => 'Test abstract',
            'description' => 'Test description',
            'user_id' => $user->id,
            'submit' => 'submit'
        ]);

        // Use the repository to create the journal
        $documentConversionService = app(\App\Services\DocumentConversionService::class);
        $repository = new EloquentJournalRepository($documentConversionService);
        $journal = $repository->create($request);

        // Verify the region is null
        $this->assertNull($journal->region);
    }

    public function test_region_is_updated_when_country_is_changed()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create a request with initial country
        $request = new Request([
            'title' => 'Test Journal Update',
            'author' => 'Test Author',
            'country' => 'Nigeria', // West Africa
            'journal_language' => 'English',
            'abstract' => 'Test abstract',
            'description' => 'Test description',
            'user_id' => $user->id,
            'submit' => 'submit'
        ]);

        // Use the repository to create the journal
        $documentConversionService = app(\App\Services\DocumentConversionService::class);
        $repository = new EloquentJournalRepository($documentConversionService);
        $journal = $repository->create($request);

        // Verify initial region
        $this->assertEquals('West Africa', $journal->region);

        // Create update request with different country
        $updateRequest = new Request([
            'title' => 'Test Journal Update',
            'author' => 'Test Author',
            'country' => 'Kenya', // East Africa
            'journal_language' => 'English',
            'abstract' => 'Test abstract',
            'description' => 'Test description',
            'user_id' => $user->id,
            'submit' => 'submit'
        ]);

        // Update the journal using repository
        $updatedJournal = $repository->update($updateRequest, $journal->uuid);

        // Verify the region was updated
        $this->assertEquals('East Africa', $updatedJournal->region);
    }

    public function test_get_region_by_country_helper_function()
    {
        // Test the helper function directly
        $regions = globalRegions();
        
        // Test known countries
        $this->assertEquals('West Africa', $this->getRegionByCountry('Nigeria'));
        $this->assertEquals('East Africa', $this->getRegionByCountry('Kenya'));
        $this->assertEquals('North Africa', $this->getRegionByCountry('Egypt'));
        $this->assertEquals('Southern Africa', $this->getRegionByCountry('South Africa'));
        $this->assertEquals('Central Africa', $this->getRegionByCountry('Cameroon'));
        
        // Test unknown country
        $this->assertNull($this->getRegionByCountry('Unknown Country'));
    }

    /**
     * Get region by country name using the globalRegions helper function
     */
    private function getRegionByCountry($countryName)
    {
        if (!$countryName) {
            return null;
        }

        $regions = globalRegions();
        
        foreach ($regions as $region => $countries) {
            if (in_array($countryName, $countries)) {
                return $region;
            }
        }
        
        return null;
    }
}
