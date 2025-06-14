<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory, SoftDeletes;

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
        'reviewers',
        'reviewers_ratings',
        'total_ratings',
        'rating_percentage',
        'is_draft',
        'change_requests',
        'accept',
        'agree',
        'editor_decision_date',
        'editor_decision_comment',
        'declined_by'
        // 'dislikes',
    ];

    protected $casts = [
        'created_by' => 'array',
        'updated_by' => 'array',
        'approved_by' => 'array',
        'declined_by' => 'array',
        'approval_comments' => 'array',
        'reviewers' => 'array',
        'reviewers_ratings' => 'array',
        'license' => 'array',
        'change_requests' => 'array',
        'editor_decision_date' => 'datetime',
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

    // public function reviewers()
    // {
    //     return $this->hasMany(Reviewer::class);
    // }

    public function reviewers()
{
    return $this->hasMany(Reviewer::class, 'journal_id');
}

    public function reviewerAssignments()
    {
        return $this->hasMany(Reviewer::class, 'journal_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function versions()
    {
        return $this->hasMany(ManuscriptVersion::class, 'journal_id')->orderBy('version_number', 'desc');
    }

    public function latestVersion()
    {
        return $this->hasOne(ManuscriptVersion::class, 'journal_id')->latestOfMany('version_number');
    }

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
