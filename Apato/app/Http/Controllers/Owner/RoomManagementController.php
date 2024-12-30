<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomManagementController extends Controller
{

    /**
     * Display owner's rooms
     */
    public function index()
    {
        // Get rooms for the current owner or show all if no owner
        $rooms = Room::when(request()->user()?->id, function($query, $userId) {
            return $query->where('owner_id', $userId);
        })->get();
        
        return view('owner.rooms.index', compact('rooms'));
    }

    /**
     * Get room details for editing
     */
    public function show(Room $room)
    {
        return response()->json($room);
    }

    /**
     * Store a new room
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|string|in:available,occupied,maintenance'
        ]);

        $room = new Room($validated);
        $room->status = $validated['status'] ?? 'available'; // Set default status if not provided
        $room->owner_id = request()->user()?->id ?? null; // Set owner ID if user is logged in
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('Room_Photo'), $filename);
            $room->image_path = 'Room_Photo/' . $filename;
        }

        $room->save();

        return redirect()->back()->with('success', 'Room added successfully');
    }

    /**
     * Update room details
     */
    public function update(Request $request, Room $room)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|string|in:available,occupied,maintenance'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($room->image_path && file_exists(public_path($room->image_path))) {
                unlink(public_path($room->image_path));
            }
            
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('Room_Photo'), $filename);
            $validated['image_path'] = 'Room_Photo/' . $filename;
        }

        $room->update($validated);

        return redirect()->back()->with('success', 'Room updated successfully');
    }

    /**
     * Delete a room
     */
    public function destroy(Room $room)
    {
        // Delete the room's image if it exists
        if ($room->image_path && file_exists(public_path($room->image_path))) {
            unlink(public_path($room->image_path));
        }

        $room->delete();
        return redirect()->back()->with('success', 'Room deleted successfully');
    }

    /**
     * Handle booking approval/rejection
     */
    public function handleBooking(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        // Set a default user_id if not present
        if (!$booking->user_id) {
            $booking->user_id = 1; // Set a default user ID
        }

        $booking->update($validated);

        return redirect()->back()->with('success', 'Booking ' . $validated['status'] . ' successfully');
    }

    /**
     * View booking requests
     */
    public function bookings()
    {
        // Get bookings for rooms owned by the current owner
        $bookings = Booking::whereHas('room', function($query) {
            $query->when(request()->user()?->id, function($q, $userId) {
                return $q->where('owner_id', $userId);
            });
        })->with(['room'])->get();

        return view('owner.bookings.index', compact('bookings'));
    }
}
