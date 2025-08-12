<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Journal;
use App\Models\User;
use App\Repositories\Journal\JournalContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class JournalRegionAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $journalRepo;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create();
        
        // Get the journal repository
        $this->journalRepo = app(JournalContract::class);
        
        // Fake storage for file uploads
        Storage::fake('public');
    }

    /** @test */
    public function it_automatically_assigns_region_when_creating_journal()
    {
        $request = $this->createMockRequest([
            'title' => 'Test Journal',
            'author' => 'Test Author',
            'country' => 'Nigeria',
            'journal_language' => 'English',
            'abstract' => 'Test abstract'
        ]);

        $journal = $this->journalRepo->create($request);

        $this->assertEquals('West Africa', $journal->region);
        $this->assertEquals('Nigeria', $journal->country);
    }

    /** @test */
    public function it_assigns_correct_regions_for_all_african_countries()
    {
        $testCases = [
            'Nigeria' => 'West Africa',
            'Ghana' => 'West Africa',
            'Kenya' => 'East Africa',
            'Tanzania' => 'East Africa',
            'Egypt' => 'North Africa',
            'Morocco' => 'North Africa',
            'South Africa' => 'Southern Africa',
            'Botswana' => 'Southern Africa',
            'Cameroon' => 'Central Africa',
            'Chad' => 'Central Africa',
        ];

        foreach ($testCases as $country => $expectedRegion) {
            $request = $this->createMockRequest([
                'title' => "Test Journal from {$country}",
                'author' => 'Test Author',
                'country' => $country,
                'journal_language' => 'English',
                'abstract' => 'Test abstract'
            ]);

            $journal = $this->journalRepo->create($request);

            $this->assertEquals($expectedRegion, $journal->region, 
                "Failed for country: {$country}. Expected: {$expectedRegion}, Got: {$journal->region}");
        }
    }

    /** @test */
    public function it_assigns_correct_regions_for_international_countries()
    {
        $testCases = [
            'United States' => 'North America',
            'Canada' => 'North America',
            'Brazil' => 'South America',
            'Argentina' => 'South America',
            'United Kingdom' => 'Europe',
            'Germany' => 'Europe',
            'China' => 'Asia',
            'Japan' => 'Asia',
            'Australia' => 'Australia and Oceania',
            'New Zealand' => 'Australia and Oceania',
        ];

        foreach ($testCases as $country => $expectedRegion) {
            $request = $this->createMockRequest([
                'title' => "Test Journal from {$country}",
                'author' => 'Test Author',
                'country' => $country,
                'journal_language' => 'English',
                'abstract' => 'Test abstract'
            ]);

            $journal = $this->journalRepo->create($request);

            $this->assertEquals($expectedRegion, $journal->region, 
                "Failed for country: {$country}. Expected: {$expectedRegion}, Got: {$journal->region}");
        }
    }

    /** @test */
    public function it_handles_unknown_countries_gracefully()
    {
        $request = $this->createMockRequest([
            'title' => 'Test Journal from Unknown Country',
            'author' => 'Test Author',
            'country' => 'Unknown Country',
            'journal_language' => 'English',
            'abstract' => 'Test abstract'
        ]);

        $journal = $this->journalRepo->create($request);

        $this->assertNull($journal->region);
        $this->assertEquals('Unknown Country', $journal->country);
    }

    /** @test */
    public function it_handles_empty_country_gracefully()
    {
        $request = $this->createMockRequest([
            'title' => 'Test Journal with No Country',
            'author' => 'Test Author',
            'country' => '',
            'journal_language' => 'English',
            'abstract' => 'Test abstract'
        ]);

        $journal = $this->journalRepo->create($request);

        $this->assertNull($journal->region);
        $this->assertEquals('', $journal->country);
    }

    /** @test */
    public function it_assigns_region_when_updating_journal_country()
    {
        // Create journal with no region
        $journal = Journal::factory()->create([
            'country' => 'Unknown Country',
            'region' => null
        ]);

        $request = $this->createMockRequest([
            'title' => $journal->title,
            'author' => $journal->author,
            'country' => 'Nigeria',
            'journal_language' => $journal->journal_language,
            'abstract' => $journal->abstract
        ]);

        $updatedJournal = $this->journalRepo->update($request, $journal->uuid);

        $this->assertEquals('West Africa', $updatedJournal->region);
        $this->assertEquals('Nigeria', $updatedJournal->country);
    }

    /** @test */
    public function it_preserves_region_when_country_is_not_changed()
    {
        $journal = Journal::factory()->create([
            'country' => 'Nigeria',
            'region' => 'West Africa'
        ]);

        $request = $this->createMockRequest([
            'title' => 'Updated Title',
            'author' => $journal->author,
            'country' => 'Nigeria', // Same country
            'journal_language' => $journal->journal_language,
            'abstract' => $journal->abstract
        ]);

        $updatedJournal = $this->journalRepo->update($request, $journal->uuid);

        $this->assertEquals('West Africa', $updatedJournal->region);
        $this->assertEquals('Nigeria', $updatedJournal->country);
    }

    /** @test */
    public function it_works_with_file_upload()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $request = $this->createMockRequest([
            'title' => 'Test Journal with File',
            'author' => 'Test Author',
            'country' => 'Kenya',
            'journal_language' => 'English',
            'abstract' => 'Test abstract',
            'manuscripts' => $file
        ]);

        $journal = $this->journalRepo->create($request);

        $this->assertEquals('East Africa', $journal->region);
        $this->assertEquals('Kenya', $journal->country);
        $this->assertNotNull($journal->journal_url);
    }

    /**
     * Create a mock request for testing
     */
    private function createMockRequest(array $data)
    {
        $request = new \Illuminate\Http\Request();
        $request->merge($data);
        $request->setUserResolver(function () {
            return $this->user;
        });
        
        return $request;
    }
}
