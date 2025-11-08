<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Donation;
use App\Models\Like;     // <-- TAMBAHKAN IMPORT INI
use App\Models\Comment;  // <-- TAMBAHKAN IMPORT INI

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
        ];
    }
    
    /**
     * Relasi ke donasi yang dibuat oleh user.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id');
    }

    /**
     * Relasi ke semua 'like' yang telah diberikan oleh user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    /**
     * Relasi ke semua 'comment' yang telah ditulis oleh user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}