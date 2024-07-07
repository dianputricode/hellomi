<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'profile_picture',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
