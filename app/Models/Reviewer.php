<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'journal_id',
        'user_id',
        'review',
        'comment',
        'confidential_comments',
        'rating',
        'criteria_ratings',
        'recommendation',
        'is_accepted',
        'token',
        'assigned_at',
        'status',
        'review_submitted_at'
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
        'rating' => 'integer',
        'criteria_ratings' => 'array',
        'assigned_at' => 'datetime',
        'review_submitted_at' => 'datetime',
    ];

    // public function journal()
    // {
    //     return $this->belongsTo(Journal::class);
    // }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias for consistency across the application
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
