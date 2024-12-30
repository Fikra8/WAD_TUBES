<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'check_in_date',
        'duration_months',
        'total_price',
        'status',
        'notes',
        'payment_proof'
    ];

    protected $casts = [
        'check_in_date' => 'date'
    ];

    /**
     * Get the room associated with the booking.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
