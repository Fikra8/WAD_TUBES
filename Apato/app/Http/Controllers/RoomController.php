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
