<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'user_id',
        'comment',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
