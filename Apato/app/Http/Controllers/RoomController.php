<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class RoomController extends Controller
{   
    // Display the booking form for a specific room
    public function create($id)
    {
        // Fetch the room by its ID
        $room = Room::findOrFail($id);

        // Return the booking form view with the room data
        return view('customer.bookform', compact('room'));
    }

    // Handle form submission for booking a room
    public function store(Request $request, $roomId)
    {
        // Validate form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'date_from' => 'required|date',
            'time_from' => 'required',
            'date_to' => 'required|date',
            'time_to' => 'required',
            'people_count' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        // Create a new booking using the validated data
        Booking::create([
            'room_id' => $roomId,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'date_from' => $request->date_from,
            'time_from' => $request->time_from,
            'date_to' => $request->date_to,
            'time_to' => $request->time_to,
            'people_count' => $request->people_count,
            'comments' => $request->comments,
        ]);

        // Redirect back with a success message
        // Flash success message
        session()->flash('success', 'Your room has been booked successfully.');

        // Redirect back to the booking history page
        return redirect()->route('booking-history.index');
    }

    // Display the available rooms and search functionality
    public function index(Request $request)
    {
        $query = \App\Models\Room::query();

        // Search logic
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Only show available rooms
        $query->where('status', 'available');

        $rooms = $query->get();

        return view('customer.searchroom', compact('rooms'));
    }
}
