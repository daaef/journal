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
        // Create a seeder data for names of african regions in alphabetical order and thier respective countries
        $regions = [
            'Central Africa' => [
                'Angola',
                'Cameroon',
                'Central African Republic',
                'Chad',
                'Congo',
                'Equatorial Guinea',
                'Gabon',
                'São Tomé and Príncipe',
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
            ],
            'Northern Africa' => [
                'Algeria',
                'Egypt',
                'Libya',
                'Morocco',
                'Sudan',
                'Tunisia',
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
                'Gambia',
                'Ghana',
                'Guinea',
                'Guinea-Bissau',
                'Ivory Coast',
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

        foreach ($regions as $region => $countries) {
            $region = Region::create(['name' => $region]);

            foreach ($countries as $country) {
                $countryIds = Country::whereIn('name', $countries)->pluck('id')->toArray();
                $region->countries()->attach($countryIds);
            }
        }

    }
}
