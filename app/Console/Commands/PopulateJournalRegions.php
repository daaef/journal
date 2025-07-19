<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;

class PopulateJournalRegions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journals:populate-regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate region field for existing journals based on their country';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to populate regions for existing journals...');
        
        $journals = Journal::whereNull('region')->get();
        $count = 0;
        
        foreach ($journals as $journal) {
            if ($journal->country) {
                $region = $this->getRegionByCountry($journal->country);
                if ($region) {
                    $journal->region = $region;
                    $journal->save();
                    $count++;
                    $this->line("Updated journal '{$journal->title}' with region: {$region}");
                } else {
                    $this->warn("Could not determine region for country: {$journal->country}");
                }
            } else {
                $this->warn("Journal '{$journal->title}' has no country set");
            }
        }
        
        $this->info("Completed! Updated {$count} journals with region data.");
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
