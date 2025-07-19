<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Region;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create regions first
        $regions = [
            'West Africa',
            'East Africa', 
            'Central Africa',
            'Southern Africa',
            'North Africa',
            'Europe',
            'North America',
            'Asia',
            'South America',
            'Oceania'
        ];

        foreach ($regions as $regionName) {
            Region::firstOrCreate(['name' => $regionName]);
        }

        // Get regions for reference
        $westAfrica = Region::where('name', 'West Africa')->first();
        $eastAfrica = Region::where('name', 'East Africa')->first();
        $centralAfrica = Region::where('name', 'Central Africa')->first();
        $southernAfrica = Region::where('name', 'Southern Africa')->first();
        $northAfrica = Region::where('name', 'North Africa')->first();
        $europe = Region::where('name', 'Europe')->first();
        $northAmerica = Region::where('name', 'North America')->first();
        $asia = Region::where('name', 'Asia')->first();
        $southAmerica = Region::where('name', 'South America')->first();
        $oceania = Region::where('name', 'Oceania')->first();

        // West African Countries
        $westAfricanCountries = [
            ['name' => 'Nigeria', 'code' => 'NG'],
            ['name' => 'Ghana', 'code' => 'GH'],
            ['name' => 'Senegal', 'code' => 'SN'],
            ['name' => 'Ivory Coast', 'code' => 'CI'],
            ['name' => 'Mali', 'code' => 'ML'],
            ['name' => 'Burkina Faso', 'code' => 'BF'],
            ['name' => 'Niger', 'code' => 'NE'],
            ['name' => 'Togo', 'code' => 'TG'],
            ['name' => 'Benin', 'code' => 'BJ'],
            ['name' => 'Guinea', 'code' => 'GN'],
            ['name' => 'Sierra Leone', 'code' => 'SL'],
            ['name' => 'Liberia', 'code' => 'LR'],
            ['name' => 'Gambia', 'code' => 'GM'],
            ['name' => 'Guinea-Bissau', 'code' => 'GW'],
            ['name' => 'Cape Verde', 'code' => 'CV'],
            ['name' => 'Mauritania', 'code' => 'MR'],
        ];

        // East African Countries
        $eastAfricanCountries = [
            ['name' => 'Kenya', 'code' => 'KE'],
            ['name' => 'Tanzania', 'code' => 'TZ'],
            ['name' => 'Uganda', 'code' => 'UG'],
            ['name' => 'Ethiopia', 'code' => 'ET'],
            ['name' => 'Somalia', 'code' => 'SO'],
            ['name' => 'Djibouti', 'code' => 'DJ'],
            ['name' => 'Eritrea', 'code' => 'ER'],
            ['name' => 'Rwanda', 'code' => 'RW'],
            ['name' => 'Burundi', 'code' => 'BI'],
            ['name' => 'South Sudan', 'code' => 'SS'],
        ];

        // Central African Countries
        $centralAfricanCountries = [
            ['name' => 'Cameroon', 'code' => 'CM'],
            ['name' => 'Chad', 'code' => 'TD'],
            ['name' => 'Central African Republic', 'code' => 'CF'],
            ['name' => 'Gabon', 'code' => 'GA'],
            ['name' => 'Congo', 'code' => 'CG'],
            ['name' => 'Democratic Republic of the Congo', 'code' => 'CD'],
            ['name' => 'Equatorial Guinea', 'code' => 'GQ'],
            ['name' => 'Sao Tome and Principe', 'code' => 'ST'],
        ];

        // Southern African Countries
        $southernAfricanCountries = [
            ['name' => 'South Africa', 'code' => 'ZA'],
            ['name' => 'Namibia', 'code' => 'NA'],
            ['name' => 'Botswana', 'code' => 'BW'],
            ['name' => 'Zimbabwe', 'code' => 'ZW'],
            ['name' => 'Zambia', 'code' => 'ZM'],
            ['name' => 'Malawi', 'code' => 'MW'],
            ['name' => 'Mozambique', 'code' => 'MZ'],
            ['name' => 'Angola', 'code' => 'AO'],
            ['name' => 'Lesotho', 'code' => 'LS'],
            ['name' => 'Eswatini', 'code' => 'SZ'],
            ['name' => 'Madagascar', 'code' => 'MG'],
            ['name' => 'Mauritius', 'code' => 'MU'],
            ['name' => 'Seychelles', 'code' => 'SC'],
            ['name' => 'Comoros', 'code' => 'KM'],
        ];

        // North African Countries
        $northAfricanCountries = [
            ['name' => 'Egypt', 'code' => 'EG'],
            ['name' => 'Morocco', 'code' => 'MA'],
            ['name' => 'Algeria', 'code' => 'DZ'],
            ['name' => 'Tunisia', 'code' => 'TN'],
            ['name' => 'Libya', 'code' => 'LY'],
            ['name' => 'Sudan', 'code' => 'SD'],
        ];

        // Major Global Countries
        $globalCountries = [
            // Europe
            ['name' => 'United Kingdom', 'code' => 'GB', 'region' => $europe],
            ['name' => 'Germany', 'code' => 'DE', 'region' => $europe],
            ['name' => 'France', 'code' => 'FR', 'region' => $europe],
            ['name' => 'Italy', 'code' => 'IT', 'region' => $europe],
            ['name' => 'Spain', 'code' => 'ES', 'region' => $europe],
            ['name' => 'Netherlands', 'code' => 'NL', 'region' => $europe],
            ['name' => 'Sweden', 'code' => 'SE', 'region' => $europe],
            ['name' => 'Norway', 'code' => 'NO', 'region' => $europe],
            ['name' => 'Denmark', 'code' => 'DK', 'region' => $europe],
            ['name' => 'Switzerland', 'code' => 'CH', 'region' => $europe],
            
            // North America
            ['name' => 'United States', 'code' => 'US', 'region' => $northAmerica],
            ['name' => 'Canada', 'code' => 'CA', 'region' => $northAmerica],
            ['name' => 'Mexico', 'code' => 'MX', 'region' => $northAmerica],
            
            // Asia
            ['name' => 'China', 'code' => 'CN', 'region' => $asia],
            ['name' => 'Japan', 'code' => 'JP', 'region' => $asia],
            ['name' => 'India', 'code' => 'IN', 'region' => $asia],
            ['name' => 'South Korea', 'code' => 'KR', 'region' => $asia],
            ['name' => 'Singapore', 'code' => 'SG', 'region' => $asia],
            ['name' => 'Malaysia', 'code' => 'MY', 'region' => $asia],
            ['name' => 'Thailand', 'code' => 'TH', 'region' => $asia],
            ['name' => 'Vietnam', 'code' => 'VN', 'region' => $asia],
            ['name' => 'Indonesia', 'code' => 'ID', 'region' => $asia],
            ['name' => 'Philippines', 'code' => 'PH', 'region' => $asia],
            
            // South America
            ['name' => 'Brazil', 'code' => 'BR', 'region' => $southAmerica],
            ['name' => 'Argentina', 'code' => 'AR', 'region' => $southAmerica],
            ['name' => 'Chile', 'code' => 'CL', 'region' => $southAmerica],
            ['name' => 'Colombia', 'code' => 'CO', 'region' => $southAmerica],
            ['name' => 'Peru', 'code' => 'PE', 'region' => $southAmerica],
            
            // Oceania
            ['name' => 'Australia', 'code' => 'AU', 'region' => $oceania],
            ['name' => 'New Zealand', 'code' => 'NZ', 'region' => $oceania],
        ];

        // Insert African countries
        foreach ($westAfricanCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $westAfrica->id
            ]);
        }

        foreach ($eastAfricanCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $eastAfrica->id
            ]);
        }

        foreach ($centralAfricanCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $centralAfrica->id
            ]);
        }

        foreach ($southernAfricanCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $southernAfrica->id
            ]);
        }

        foreach ($northAfricanCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $northAfrica->id
            ]);
        }

        // Insert global countries
        foreach ($globalCountries as $country) {
            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'region_id' => $country['region']->id
            ]);
        }

        $this->command->info('Countries seeded successfully!');
        $this->command->info('Total countries created: ' . Country::count());
    }
} 