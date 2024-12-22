<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{   
    // Display the booking form
    public function create()
    {
        return view('customer.bookform');
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'date_from' => 'required|date',
            'time_from' => 'required',
            'date_to' => 'required|date',
            'time_to' => 'required',
            'people_count' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);
        return back()->with('success', 'Your room has been booked successfully!');
    }

    public function index(Request $request)
    {
        // Example rooms data for testing
        $rooms = [
            [
                'name' => 'Deluxe 2BR at The Green Kosambi Bandung Apartment',
                'location' => 'Lengkong, Buahbatu',
                'rating' => 8.2,
                'reviews' => 5,
                'discounted_price' => 'Rp 845.998',
                'original_price' => 'Rp 1.409.997',
                'image' => 'images/booking-room.jpg',
                'tag' => '36% OFF',
                'status' => 'Convenient'
            ],
            [
                'name' => 'Minimalist 2BR Apartment at Gateway Ahmad Yani',
                'location' => 'Buahbatu, Bandung',
                'rating' => 6.0,
                'reviews' => 5,
                'discounted_price' => 'Rp 624.612',
                'original_price' => 'Rp 832.815',
                'image' => 'images/booking-room.jpg',
                'status' => 'Acceptable'
            ]
        ];

        // Search logic
        $search = $request->input('search');
        if ($search) {
            $rooms = array_filter($rooms, function ($room) use ($search) {
                return stripos($room['name'], $search) !== false || stripos($room['location'], $search) !== false;
            });
        }

        // Return the view with filtered rooms
        return view('customer.searchroom', ['rooms' => $rooms, 'search' => $search]);
    }
}
