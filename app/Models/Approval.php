<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
