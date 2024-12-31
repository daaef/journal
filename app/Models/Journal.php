<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'slug',
        'uuid',
        'description',
        'is_active',
        'cover_image',
        'journal_format',
        'journal_language',
        'journal_url',
        'approval_status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'abstract',
        'institution',
        'license',
        'approval_level',
        'user_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'created_by',
        'updated_by',
        'approved_by',
        'approval_comments',
        'reveiwers',
        'reviewers_ratings',
        'total_ratings',
        'rating_percentage',
        'is_draft',
        'change_requests',
        'accept',
        'agree'
        // 'dislikes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_sub_category() {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function comments() {
        return $this->hasMany(JournalComment::class);
    }

    public function likedBy() {
        return $this->belongsToMany(User::class, 'journal_likes', 'journal_id', 'user_id');
    }

    public function likes() {
        return $this->hasMany(JournalLike::class);
    }

    public function reviewers()
    {
        return $this->hasMany(Reviewer::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    /**
     * Calculate and update the approval status.
     */
    // public function calculateApprovalStatus()
    // {
    //     $totalRatings = collect($this->reviewers_ratings)->sum('rating');
    //     $totalReviewers = count($this->reviewers_ratings);

    //     $this->total_ratings = $totalRatings;
    //     $this->rating_percentage = $totalReviewers > 0
    //         ? ($totalRatings / ($totalReviewers * 5)) * 100 // Assuming a 5-star rating
    //         : 0;

    //     // Automatic approval if percentage is greater than 65%
    //     if ($this->rating_percentage >= 65) {
    //         $this->approval_status = 'approved';
    //     } else {
    //         $this->approval_status = 'pending_review';
    //     }

    //     $this->save();
    // }

    protected function cast()
    {
        return [
            'is_active' => 'boolean',
            'agree' => 'boolean',
            'accept' => 'boolean',
            'is_draft' => 'boolean',
            'meta_keywords' => 'json',
            'created_by' => 'json',
            'updated_by' => 'json',
            'approved_by' => 'json',
            'approval_comments' => 'json',
            'license' => 'json',
            'reveiwers' => 'json',
            'change_requests' => 'json',
            'reviewers_ratings' => 'json',
            'total_ratings' => 'integer',
            'rating_percentage' => 'float',
            // 'author' => 'json',
        ];
    }
}
