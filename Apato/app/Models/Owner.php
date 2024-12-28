<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'users';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'usertype', 
    ];

    public function scopeOwners($query)
    {
        return $query->where('usertype', 'owner');
    }
}
