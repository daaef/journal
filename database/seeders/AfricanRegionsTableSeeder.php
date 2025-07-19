<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Country;

class AfricanRegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a seeder data for names of african regions in alphabetical order and their respective countries
        $regions = [
            'Central Africa' => [
                'Angola',
                'Cameroon',
                'Central African Republic',
                'Chad',
                'Congo, Democratic Republic of the',
                'Congo, Republic of the',
                'Equatorial Guinea',
                'Gabon',
                'Sao Tome and Principe',
            ],
            'Eastern Africa' => [
                'Burundi',
                'Comoros',
                'Djibouti',
                'Eritrea',
                'Ethiopia',
                'Kenya',
                'Madagascar',
                'Malawi',
                'Mauritius',
                'Mozambique',
                'Rwanda',
                'Seychelles',
                'Somalia',
                'South Sudan',
                'Tanzania',
                'Uganda',
                'Zambia',
                'Zimbabwe',
            ],
            'Northern Africa' => [
                'Algeria',
                'Egypt',
                'Libya',
                'Morocco',
                'Sudan',
                'Tunisia',
                'Western Sahara',
            ],
            'Southern Africa' => [
                'Botswana',
                'Eswatini',
                'Lesotho',
                'Namibia',
                'South Africa',
            ],
            'Western Africa' => [
                'Benin',
                'Burkina Faso',
                'Cape Verde',
                'Cote d\'Ivoire',
                'Gambia',
                'Ghana',
                'Guinea',
                'Guinea-Bissau',
                'Liberia',
                'Mali',
                'Mauritania',
                'Niger',
                'Nigeria',
                'Senegal',
                'Sierra Leone',
                'Togo',
            ],
        ];

        foreach ($regions as $regionName => $countries) {
            // Create the region
            $region = Region::create(['name' => $regionName]);

            // Create countries for this region
            foreach ($countries as $countryName) {
                Country::create([
                    'name' => $countryName,
                    'code' => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $countryName), 0, 2)), // Remove special chars for code
                    'region_id' => $region->id,
                ]);
            }

            $this->command->info("Created region: {$regionName} with " . count($countries) . " countries");
        }

        $this->command->info('African regions and countries seeding completed successfully!');
    }
}
