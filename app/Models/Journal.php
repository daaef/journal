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
        'declined_by',
        'approved_at',
        'managing_editor_notice',
        'managing_editor_notice_sent_at',
        'country',
        'region'
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
        'managing_editor_notice' => 'array',
        'editor_decision_date' => 'datetime',
        'approved_at' => 'datetime',
        'managing_editor_notice_sent_at' => 'datetime',
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

    /**
     * Get user-friendly status label for approval_status
     */
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'pending' => 'Pending Review',
            'in-progress' => 'In Progress',
            'in_progress' => 'In Progress',
            'approved' => 'Approved',
            'approved_with_comment' => 'Approved with Comments',
            'declined' => 'Declined',
            'rejected' => 'Rejected',
            'changes_requested' => 'Changes Requested',
            'revision_requested' => 'Revision Requested',
            'reviewed' => 'Reviewed',
            'under_peer_review' => 'Under Peer Review',
            'ready_for_managing_editor_notice' => 'Ready for Managing Editor Review',
            'awaiting_editor_decision' => 'Awaiting Editor Decision',
            'editor_approved' => 'Editor Approved',
            'editor_declined' => 'Editor Declined',
        ];

        return $statusLabels[$this->approval_status] ?? ucfirst(str_replace(['_', '-'], ' ', $this->approval_status));
    }

    /**
     * Get CSS class for status badge styling
     */
    public function getStatusClassAttribute()
    {
        $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in-progress' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'approved' => 'bg-green-100 text-green-800',
            'approved_with_comment' => 'bg-green-100 text-green-800',
            'declined' => 'bg-red-100 text-red-800',
            'rejected' => 'bg-red-100 text-red-800',
            'changes_requested' => 'bg-orange-100 text-orange-800',
            'revision_requested' => 'bg-orange-100 text-orange-800',
            'reviewed' => 'bg-purple-100 text-purple-800',
            'under_peer_review' => 'bg-indigo-100 text-indigo-800',
            'ready_for_managing_editor_notice' => 'bg-teal-100 text-teal-800',
            'awaiting_editor_decision' => 'bg-gray-100 text-gray-800',
            'editor_approved' => 'bg-emerald-100 text-emerald-800',
            'editor_declined' => 'bg-rose-100 text-rose-800',
        ];

        return $statusClasses[$this->approval_status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get review summary for the journal
     */
    public function getReviewSummaryAttribute()
    {
        // Get all reviewer assignments for this journal
        $reviewerAssignments = $this->reviewerAssignments;
        
        $totalReviews = $reviewerAssignments->count();
        $completedReviews = $reviewerAssignments->whereNotNull('review_submitted_at')->count();
        
        // Calculate average rating if there are completed reviews
        $averageRating = null;
        $recommendations = collect(['accept' => 0, 'reject' => 0, 'revise' => 0]);
        
        if ($completedReviews > 0) {
            $completedAssignments = $reviewerAssignments->whereNotNull('review_submitted_at');
            
            // Calculate average rating
            $ratings = $completedAssignments->whereNotNull('overall_rating')->pluck('overall_rating');
            if ($ratings->count() > 0) {
                $averageRating = $ratings->average();
            }
            
            // Count recommendations
            foreach ($completedAssignments as $assignment) {
                if ($assignment->recommendation) {
                    $recommendations[$assignment->recommendation] = $recommendations->get($assignment->recommendation, 0) + 1;
                }
            }
        }
        
        return [
            'total_reviews' => $totalReviews,
            'completed_reviews' => $completedReviews,
            'average_rating' => $averageRating,
            'recommendations' => $recommendations,
        ];
    }

    /**
     * Get the document type based on the file extension
     */
    public function getDocumentType()
    {
        if (!$this->journal_url) {
            return 'unknown';
        }

        $extension = strtolower(pathinfo($this->journal_url, PATHINFO_EXTENSION));
        
        switch ($extension) {
            case 'pdf':
                return 'pdf';
            case 'doc':
            case 'docx':
                return 'docx';
            case 'txt':
                return 'txt';
            case 'md':
                return 'markdown';
            default:
                return 'unknown';
        }
    }
}
