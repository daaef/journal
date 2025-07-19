<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AssociateEditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Associate Editor role
        $associateEditorRole = Role::where('name', 'Associate Editor')->first();
        
        if (!$associateEditorRole) {
            $this->command->error('Associate Editor role not found. Please run the role seeder first.');
            return;
        }

        // Get regions and countries from database
        $regions = Region::with('countries')->get();
        
        // Create Associate Editors with regional expertise based on database
        $associateEditors = [
            [
                'fullname' => 'Dr. Sarah Johnson',
                'username' => 'sarah.johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => Hash::make('password123'),
                'country' => 'Nigeria',
                'region_name' => 'Western Africa',
                'research_interests' => ['Agriculture', 'Medicine'],
                'available_for_review' => true,
                'average_rating' => 4.5,
                'review_count' => 12,
                'institution' => 'University of Lagos',
                'biography' => 'Expert in agricultural sciences with focus on West African farming practices.'
            ],
            [
                'fullname' => 'Dr. Michael Chen',
                'username' => 'michael.chen',
                'email' => 'michael.chen@example.com',
                'password' => Hash::make('password123'),
                'country' => 'Kenya',
                'region_name' => 'Eastern Africa',
                'research_interests' => ['Medicine', 'Public Health'],
                'available_for_review' => true,
                'average_rating' => 4.8,
                'review_count' => 8,
                'institution' => 'University of Nairobi',
                'biography' => 'Public health specialist with extensive experience in East African healthcare systems.'
            ],
            [
                'fullname' => 'Dr. Ahmed Hassan',
                'username' => 'ahmed.hassan',
                'email' => 'ahmed.hassan@example.com',
                'password' => Hash::make('password123'),
                'country' => 'Egypt',
                'region_name' => 'Northern Africa',
                'research_interests' => ['Engineering', 'Technology'],
                'available_for_review' => true,
                'average_rating' => 4.2,
                'review_count' => 15,
                'institution' => 'Cairo University',
                'biography' => 'Engineering expert specializing in renewable energy and sustainable development.'
            ],
            [
                'fullname' => 'Dr. Maria Rodriguez',
                'username' => 'maria.rodriguez',
                'email' => 'maria.rodriguez@example.com',
                'password' => Hash::make('password123'),
                'country' => 'South Africa',
                'region_name' => 'Southern Africa',
                'research_interests' => ['Social Sciences', 'Education'],
                'available_for_review' => true,
                'average_rating' => 4.6,
                'review_count' => 10,
                'institution' => 'University of Cape Town',
                'biography' => 'Social scientist with expertise in educational policy and community development.'
            ],
            [
                'fullname' => 'Dr. James Wilson',
                'username' => 'james.wilson',
                'email' => 'james.wilson@example.com',
                'password' => Hash::make('password123'),
                'country' => 'United States',
                'region_name' => 'North America',
                'research_interests' => ['Business', 'Technology'],
                'available_for_review' => true,
                'average_rating' => 4.4,
                'review_count' => 20,
                'institution' => 'Harvard University',
                'biography' => 'Business and technology expert with focus on digital transformation and innovation.'
            ],
            [
                'fullname' => 'Dr. Li Wei',
                'username' => 'li.wei',
                'email' => 'li.wei@example.com',
                'password' => Hash::make('password123'),
                'country' => 'China',
                'region_name' => 'Asia',
                'research_interests' => ['Natural Sciences', 'Engineering'],
                'available_for_review' => true,
                'average_rating' => 4.7,
                'review_count' => 18,
                'institution' => 'Tsinghua University',
                'biography' => 'Natural sciences researcher with expertise in environmental science and engineering.'
            ],
            [
                'fullname' => 'Dr. Carlos Silva',
                'username' => 'carlos.silva',
                'email' => 'carlos.silva@example.com',
                'password' => Hash::make('password123'),
                'country' => 'Brazil',
                'region_name' => 'South America',
                'research_interests' => ['Agriculture', 'Natural Sciences'],
                'available_for_review' => true,
                'average_rating' => 4.3,
                'review_count' => 14,
                'institution' => 'University of São Paulo',
                'biography' => 'Agricultural scientist with expertise in tropical agriculture and biodiversity.'
            ],
            [
                'fullname' => 'Dr. Emma Thompson',
                'username' => 'emma.thompson',
                'email' => 'emma.thompson@example.com',
                'password' => Hash::make('password123'),
                'country' => 'United Kingdom',
                'region_name' => 'Europe',
                'research_interests' => ['Medicine', 'Social Sciences'],
                'available_for_review' => true,
                'average_rating' => 4.9,
                'review_count' => 25,
                'institution' => 'University of Oxford',
                'biography' => 'Medical researcher with expertise in clinical trials and public health policy.'
            ]
        ];

        foreach ($associateEditors as $editor) {
            // Get regional expertise based on database
            $regionalExpertise = [];
            
            // Add the specific region
            if (isset($editor['region_name'])) {
                $region = $regions->where('name', $editor['region_name'])->first();
                if ($region) {
                    $regionalExpertise[] = $region->name;
                    // Add countries from this region
                    $regionalExpertise = array_merge($regionalExpertise, $region->countries->pluck('name')->toArray());
                }
            }
            
            // Add the specific country
            if (isset($editor['country'])) {
                $regionalExpertise[] = $editor['country'];
            }

            // Check if user already exists
            $existingUser = User::where('email', $editor['email'])->first();
            
            if ($existingUser) {
                // Update existing user
                $existingUser->update([
                    'fullname' => $editor['fullname'],
                    'country' => $editor['country'],
                    'regional_expertise' => array_unique($regionalExpertise),
                    'research_interests' => $editor['research_interests'],
                    'available_for_review' => $editor['available_for_review'],
                    'average_rating' => $editor['average_rating'],
                    'review_count' => $editor['review_count'],
                    'institution' => $editor['institution'],
                    'biography' => $editor['biography'],
                ]);
                
                $this->command->info("Updated Associate Editor: {$editor['fullname']} - {$editor['country']} (Regional Expertise: " . implode(', ', $regionalExpertise) . ")");
            } else {
                // Create new user
                $user = User::create([
                    'fullname' => $editor['fullname'],
                    'username' => $editor['username'],
                    'email' => $editor['email'],
                    'password' => $editor['password'],
                    'country' => $editor['country'],
                    'regional_expertise' => array_unique($regionalExpertise),
                    'research_interests' => $editor['research_interests'],
                    'available_for_review' => $editor['available_for_review'],
                    'average_rating' => $editor['average_rating'],
                    'review_count' => $editor['review_count'],
                    'institution' => $editor['institution'],
                    'biography' => $editor['biography'],
                    'uuid' => Str::uuid(),
                    'email_verified_at' => now(),
                ]);

                // Assign Associate Editor role
                $user->assignRole($associateEditorRole);

                $this->command->info("Created Associate Editor: {$editor['fullname']} - {$editor['country']} (Regional Expertise: " . implode(', ', $regionalExpertise) . ")");
            }
        }

        $this->command->info('Associate Editor seeding completed successfully!');
    }
} 