<?php

namespace App\Services;

use App\Models\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\Category;

class ExpertiseService
{
    /**
     * Get all available expertise categories
     */
    public function getExpertiseCategories()
    {
        return [
            'regional' => [
                'West Africa' => ['Nigeria', 'Ghana', 'Senegal', 'Ivory Coast', 'Mali', 'Burkina Faso', 'Niger', 'Togo', 'Benin', 'Guinea', 'Sierra Leone', 'Liberia', 'Gambia', 'Guinea-Bissau', 'Cape Verde', 'Mauritania'],
                'East Africa' => ['Kenya', 'Tanzania', 'Uganda', 'Ethiopia', 'Somalia', 'Djibouti', 'Eritrea', 'Rwanda', 'Burundi', 'South Sudan'],
                'Central Africa' => ['Cameroon', 'Chad', 'Central African Republic', 'Gabon', 'Congo', 'Democratic Republic of the Congo', 'Equatorial Guinea', 'Sao Tome and Principe'],
                'Southern Africa' => ['South Africa', 'Namibia', 'Botswana', 'Zimbabwe', 'Zambia', 'Malawi', 'Mozambique', 'Angola', 'Lesotho', 'Eswatini', 'Madagascar', 'Mauritius', 'Seychelles', 'Comoros'],
                'North Africa' => ['Egypt', 'Morocco', 'Algeria', 'Tunisia', 'Libya', 'Sudan'],
                'Europe' => ['United Kingdom', 'Germany', 'France', 'Italy', 'Spain', 'Netherlands', 'Sweden', 'Norway', 'Denmark', 'Switzerland'],
                'North America' => ['United States', 'Canada', 'Mexico'],
                'Asia' => ['China', 'Japan', 'India', 'South Korea', 'Singapore', 'Malaysia', 'Thailand', 'Vietnam', 'Indonesia', 'Philippines'],
                'South America' => ['Brazil', 'Argentina', 'Chile', 'Colombia', 'Peru'],
                'Oceania' => ['Australia', 'New Zealand']
            ],
            'research_areas' => [
                'Agriculture' => ['Crop Science', 'Animal Science', 'Agricultural Economics', 'Soil Science', 'Agricultural Technology'],
                'Medicine' => ['Clinical Medicine', 'Public Health', 'Epidemiology', 'Pharmacology', 'Medical Research'],
                'Engineering' => ['Civil Engineering', 'Mechanical Engineering', 'Electrical Engineering', 'Computer Engineering', 'Chemical Engineering'],
                'Social Sciences' => ['Economics', 'Sociology', 'Political Science', 'Psychology', 'Anthropology'],
                'Natural Sciences' => ['Physics', 'Chemistry', 'Biology', 'Mathematics', 'Environmental Science'],
                'Technology' => ['Information Technology', 'Artificial Intelligence', 'Data Science', 'Cybersecurity', 'Software Engineering'],
                'Business' => ['Management', 'Marketing', 'Finance', 'Accounting', 'Entrepreneurship'],
                'Education' => ['Educational Psychology', 'Curriculum Development', 'Educational Technology', 'Higher Education', 'Early Childhood Education']
            ],
            'review_types' => [
                'Research Papers',
                'Review Articles', 
                'Case Studies',
                'Methodology Papers',
                'Data Analysis Papers',
                'Theoretical Papers',
                'Experimental Studies',
                'Survey Research',
                'Qualitative Research',
                'Quantitative Research'
            ]
        ];
    }

    /**
     * Get reviewers by regional expertise
     */
    public function getReviewersByRegionalExpertise($manuscript)
    {
        $authorCountry = $manuscript->country;
        $authorRegion = $this->getRegionByCountry($authorCountry);

        return User::role('Associate Editor')
            ->where('available_for_review', true)
            ->where(function($query) use ($authorCountry, $authorRegion) {
                $query->where('country', $authorCountry)
                      ->orWhereJsonContains('regional_expertise', $authorCountry)
                      ->orWhereJsonContains('regional_expertise', $authorRegion);
            })
            ->orderBy('average_rating', 'desc')
            ->orderBy('review_count', 'asc')
            ->get();
    }

    /**
     * Get reviewers by research interest
     */
    public function getReviewersByResearchInterest($manuscript)
    {
        $category = $manuscript->category;
        
        return User::role('Associate Editor')
            ->where('available_for_review', true)
            ->whereJsonContains('research_interests', $category->name)
            ->orderBy('average_rating', 'desc')
            ->orderBy('review_count', 'asc')
            ->get();
    }

    /**
     * Get optimal reviewers for a manuscript
     */
    public function getOptimalReviewers($manuscript, $limit = 4)
    {
        $regionalReviewers = $this->getReviewersByRegionalExpertise($manuscript);
        $interestReviewers = $this->getReviewersByResearchInterest($manuscript);
        
        // Combine and prioritize reviewers
        $allReviewers = $regionalReviewers->merge($interestReviewers)->unique('id');
        
        // Sort by expertise match and availability
        $sortedReviewers = $allReviewers->sortBy(function($reviewer) use ($manuscript) {
            $score = 0;
            
            // Regional expertise bonus
            if ($reviewer->hasRegionalExpertise($manuscript->country)) {
                $score += 10;
            }
            
            // Research interest bonus
            if ($reviewer->hasResearchInterest($manuscript->category->name)) {
                $score += 8;
            }
            
            // Availability bonus (lower review count = higher priority)
            $score += (10 - min($reviewer->review_count, 10));
            
            // Rating bonus
            $score += ($reviewer->average_rating ?? 3) * 2;
            
            return -$score; // Negative for descending sort
        });
        
        return $sortedReviewers->take($limit);
    }

    /**
     * Get region by country name
     */
    public function getRegionByCountry($countryName)
    {
        $country = Country::where('name', $countryName)->first();
        return $country ? $country->region->name : null;
    }

    /**
     * Get countries by region
     */
    public function getCountriesByRegion($regionName)
    {
        $region = Region::where('name', $regionName)->first();
        return $region ? $region->countries : collect();
    }

    /**
     * Update user's regional expertise
     */
    public function updateUserRegionalExpertise($userId, $expertise)
    {
        $user = User::find($userId);
        if ($user) {
            $user->regional_expertise = $expertise;
            $user->save();
            return true;
        }
        return false;
    }

    /**
     * Update user's research interests
     */
    public function updateUserResearchInterests($userId, $interests)
    {
        $user = User::find($userId);
        if ($user) {
            $user->research_interests = $interests;
            $user->save();
            return true;
        }
        return false;
    }

    /**
     * Get reviewer statistics by region
     */
    public function getReviewerStatisticsByRegion()
    {
        $regions = Region::with('countries')->get();
        $stats = [];
        
        foreach ($regions as $region) {
            $reviewers = User::role('Associate Editor')
                ->where('available_for_review', true)
                ->where(function($query) use ($region) {
                    $query->whereJsonContains('regional_expertise', $region->name)
                          ->orWhereIn('country', $region->countries->pluck('name'));
                })
                ->get();
            
            $stats[$region->name] = [
                'total_reviewers' => $reviewers->count(),
                'available_reviewers' => $reviewers->where('available_for_review', true)->count(),
                'average_rating' => $reviewers->avg('average_rating'),
                'total_reviews' => $reviewers->sum('review_count')
            ];
        }
        
        return $stats;
    }
} 