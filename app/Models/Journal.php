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
        'is_active'
    ];

    public function entries()
    {
        // return $this->hasMany(Entry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
