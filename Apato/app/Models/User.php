<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Import the interface
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // Implement the interface
{
    use Notifiable;

    // customer

    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
