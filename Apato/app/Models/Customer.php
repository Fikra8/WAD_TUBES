<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Define the table name if it differs from the default convention
    protected $table = 'tbcustomers';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'usertype',
        'phone',
        'address',
        'password',
        'profile_photo_path',
        
    ];

    // If needed, add hidden fields for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
