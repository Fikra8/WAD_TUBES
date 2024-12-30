<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show booking history for the authenticated user
    public function index()
    {
        $bookings = Booking::with(['room'])->get();
        return view('customer.booking-history', compact('bookings'));
    }

    // Store a new booking
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

        // Get the room
        $room = Room::findOrFail($roomId);

        // Calculate duration in months
        $dateFrom = \Carbon\Carbon::parse($request->date_from);
        $dateTo = \Carbon\Carbon::parse($request->date_to);
        $durationMonths = $dateFrom->diffInMonths($dateTo) + 1; // Add 1 to include partial months

        // Calculate total price
        $totalPrice = $room->price * $durationMonths;

        // Create a new booking
        $booking = new Booking([
            'room_id' => $roomId,
            'user_id' => 1, // Default user ID since we removed auth
            'check_in_date' => $request->date_from,
            'duration_months' => $durationMonths,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->comments
        ]);

        $booking->save();
    
        // Redirect with success message
        return redirect()->route('booking-history.index')->with('success', 'Booking created successfully');
    }

    // Show the form to edit an existing booking
    public function edit($id)
    {
        $booking = Booking::with('room')->findOrFail($id);
        return view('customer.edit-booking', compact('booking'));
    }

    // Update an existing booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Validate form data
        $validatedData = $request->validate([
            'check_in_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Calculate total price
        $totalPrice = $booking->room->price * $validatedData['duration_months'];

        // Update booking
        $booking->update([
            'check_in_date' => $validatedData['check_in_date'],
            'duration_months' => $validatedData['duration_months'],
            'total_price' => $totalPrice,
            'notes' => $validatedData['notes']
        ]);
    
        // Redirect with success message
        // Flash success message
        session()->flash('success', 'Booking updated successfully.');

        // Redirect back to the booking history page
        return redirect()->route('booking-history.index');
    }

    // Delete an existing booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        
        return redirect()->route('booking-history.index')
            ->with('success', 'Booking deleted successfully.');
    }


}
