<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    use HasFactory;


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
}
