<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Models\Booking;


class Room extends Model
{
    use HasFactory;

    // Specify the table name (if different from pluralized model name)
    // protected $table = 'rooms'; // Uncomment if table name is custom

    // The attributes that are mass assignable
    protected $fillable = [
        'room_title',
        'room_type',
        'price_per_night',
        'description',
        'image_url',
        'status'
    ];

    // Define a hasMany relationship to Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
