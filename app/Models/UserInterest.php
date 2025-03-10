<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'interests',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $cast = [
        'interests' => 'json',
    ];

}
