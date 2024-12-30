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
        $custbookings=Booking::all();
        return view('customer.booking-history', compact('custbookings'));
    }


    // Show the form to create a new booking
    public function create()
    {
        // Retrieve all rooms to display for booking selection
        $rooms = Room::all();
        return view('customer.create-booking', compact('rooms'));
    }

    // Store a new booking
    public function store(Request $request)
    {
        // Validate the incoming data for booking creation
        $request->validate([
            'room_id' => 'required|exists:rooms,id',  // Ensure room exists in rooms table
            'date_from' => 'required|date|after_or_equal:today',  // Booking must be today or later
            'date_to' => 'required|date|after_or_equal:date_from', // Ensure the 'to' date is after the 'from' date
            'people_count' => 'required|integer|min:1',
            'comments' => 'nullable|string',
            'email' => 'required|email', // Email to identify the user
            'upload_image_path' => 'required|file|mimes:jpg|max:2048', // Validate JPG file
        ]);
    
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('upload_image_path')) {
            $filePath = $request->file('upload_image_path')->store('uploads', 'public'); // Save file to 'public/uploads'
        }
    
        // Create a new booking
        $custbookings = new Booking();
        $custbookings->email = $request->email;  // Store the user's email
        $custbookings->name = $request->name;
        $custbookings->date_from = $request->date_from;
        $custbookings->date_to = $request->date_to;
        $custbookings->people_count = $request->people_count;
        $custbookings->comments = $request->comments;
        $custbookings->upload_image_path = $filePath; // Save the file path in the database
        $custbookings->save();
    
        // Redirect with success message
        return redirect()->route('booking-history.index')->with('success', 'Booking created successfully');
    }

    // Show the form to edit an existing booking
    public function edit($id)
    {
        $custbookings = Booking::findOrFail($id);

        $rooms = Room::all();
        return view('customer.edit-booking', compact('custbookings', 'rooms'));
    }

    // Update an existing booking
    public function update(Request $request, $id)
    {
        $custbookings = Booking::findOrFail($id);
    
    
    
        // Validate the incoming data for updating the booking
        $request->validate([
            'name' => 'required|string',
            'date_from' => 'required|date|after_or_equal:today', // Ensure the 'from' date is valid
            'date_to' => 'required|date|after_or_equal:date_from', // Ensure the 'to' date is valid
            'people_count' => 'required|integer|min:1',
            'comments' => 'nullable|string',
            'upload_image_path' => 'nullable|file|mimes:jpg|max:2048', // Validate JPG file
        ]);
    
      
        // Update the booking details
        $custbookings->update($request->except('upload_image_path'));
    
        // Redirect with success message
        // Flash success message
        session()->flash('success', 'Booking updated successfully.');

        // Redirect back to the booking history page
        return redirect()->route('booking-history.index');
    }

    // Delete an existing booking
    public function destroy($id)
    {
        $custbookings = Booking::findOrFail($id);

            // Delete the booking
        $custbookings->delete();

        // Redirect with success message
        // Flash success message
        session()->flash('success', 'Booking deleted successfully.');

        // Redirect back to the booking history page
        return redirect()->route('booking-history.index');
    }


}
