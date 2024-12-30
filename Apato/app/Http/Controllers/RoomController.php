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
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Get the room
        $room = Room::findOrFail($roomId);

        // Calculate duration in months
        $dateFrom = \Carbon\Carbon::parse($request->date_from);
        $dateTo = \Carbon\Carbon::parse($request->date_to);
        $durationMonths = $dateFrom->diffInMonths($dateTo) + 1; // Add 1 to include partial months

        // Calculate total price
        $totalPrice = $room->price * $durationMonths;

        // Handle payment proof upload
        $paymentProof = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $path = $file->store('payment_proofs', 'public');
            $paymentProof = asset('storage/' . $path);
        }

        // Create a new booking
        $booking = new Booking([
            'room_id' => $roomId,
            'user_id' => 1, // Default user ID since we removed auth
            'check_in_date' => $request->date_from,
            'duration_months' => $durationMonths,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->comments,
            'payment_proof' => $paymentProof
        ]);

        $booking->save();

        // Redirect back with a success message
        // Flash success message
        session()->flash('success', 'Your room has been booked successfully.');

        // Redirect back to the booking history page
        return redirect()->route('booking-history.index');
    }

    // Display the available rooms and search functionality
    public function index(Request $request)
    {
        $query = Room::where('status', 'available');

        // Search logic
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $rooms = $query->latest()->get();

        return view('customer.searchroom', compact('rooms'));
    }
}
