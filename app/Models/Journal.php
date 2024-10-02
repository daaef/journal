<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
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
        'approved_by'
    ];

    public function entries()
    {
        // return $this->hasMany(Entry::class);
    }

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
}
