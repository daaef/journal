<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'country',
        'password',
        'avatar',
        'uuid',
    ];

    public function activation()
    {
        return $this->hasOne(Activation::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function journalComments()
    {
        return $this->hasMany(JournalComment::class);
    }

    public function likeJournals()
    {
        return $this->hasMany(LikeJournal::class);
    }

    public function dislikeJournals()
    {
        return $this->hasMany(DislikeJournal::class);
    }

    public function userInterests()
    {
        return $this->hasMany(UserInterest::class);
    }

    public function myJournalCollections()
    {
        return $this->belongsToMany(Journal::class, 'my_journal_collections', 'user_id', 'journal_id');
    }

    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
