<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    // Specify the table name (if different from pluralized model name)
    // protected $table = 'bookings'; // Uncomment if table name is custom

    // The attributes that are mass assignable
    protected $fillable = [
        'room_id',
        'name',
        'email',
        'phone_number',
        'date_from',
        'time_from',
        'date_to',
        'time_to',
        'people_count',
        'comments',
        'upload_image_path',
    ];

    // Define a belongsTo relationship to Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
