<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'country',
        'institution',
        'password',
        'avatar',
        'uuid',
        'notification_preferences',
        'review_policy_accepted',
        'review_policy_accepted_at',
        'regional_expertise',
        'research_interests',
        'academic_degree',
        'biography',
        'publications',
        'specialization',
        'institution_region',
        'review_count',
        'average_rating',
        'last_review_at',
        'available_for_review',
        'max_reviews_per_month',
        'preferred_review_types',
    ];

    public function activation()
    {
        return $this->hasOne(Activation::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function journalComments()
    {
        return $this->hasMany(JournalComment::class);
    }

    public function likeJournals()
    {
        return $this->hasMany(LikeJournal::class);
    }

    public function dislikeJournals()
    {
        return $this->hasMany(DislikeJournal::class);
    }

    public function userInterests()
    {
        return $this->hasMany(UserInterest::class);
    }

    public function myJournalCollections()
    {
        return $this->belongsToMany(Journal::class, 'my_journal_collections', 'user_id', 'journal_id');
    }

    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function reviews()
    {
        return $this->hasMany(Reviewer::class, 'user_id');
    }

    public function reviewerComments()
    {
        // return $this->hasMany(ReviewerComment::class, 'user_id');
    }

    /**
     * Get user's regional expertise
     */
    public function getRegionalExpertiseAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set user's regional expertise
     */
    public function setRegionalExpertiseAttribute($value)
    {
        $this->attributes['regional_expertise'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Check if user has expertise in a specific region/country
     */
    public function hasRegionalExpertise($regionOrCountry)
    {
        $expertise = $this->regional_expertise ?? [];
        return in_array($regionOrCountry, $expertise);
    }

    /**
     * Check if user has expertise in a specific region
     */
    public function hasRegionalExpertiseByRegion($regionName)
    {
        $expertise = $this->regional_expertise ?? [];
        return in_array($regionName, $expertise);
    }

    /**
     * Get user's research interests
     */
    public function getResearchInterestsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set user's research interests
     */
    public function setResearchInterestsAttribute($value)
    {
        $this->attributes['research_interests'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Check if user has research interest in a specific area
     */
    public function hasResearchInterest($interest)
    {
        $interests = $this->research_interests ?? [];
        return in_array($interest, $interests);
    }

    /**
     * Get user's preferred review types
     */
    public function getPreferredReviewTypesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set user's preferred review types
     */
    public function setPreferredReviewTypesAttribute($value)
    {
        $this->attributes['preferred_review_types'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Check if user is available for review assignments
     */
    public function isAvailableForReview()
    {
        return $this->available_for_review && 
               $this->hasRole('Associate Editor') &&
               $this->review_count < $this->max_reviews_per_month;
    }

    /**
     * Get user's review performance metrics
     */
    public function getReviewPerformance()
    {
        return [
            'total_reviews' => $this->review_count,
            'average_rating' => $this->average_rating,
            'last_review' => $this->last_review_at,
            'availability' => $this->isAvailableForReview(),
            'max_capacity' => $this->max_reviews_per_month,
            'current_load' => $this->review_count
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
            'review_policy_accepted_at' => 'datetime',
            'regional_expertise' => 'array',
            'research_interests' => 'array',
            'preferred_review_types' => 'array',
            'last_review_at' => 'datetime',
            'available_for_review' => 'boolean',
        ];
    }
}
