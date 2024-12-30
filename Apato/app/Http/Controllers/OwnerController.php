<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the owners.
     */
    public function index()
    {
        $rooms = Room::all();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $recentBookings = Booking::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('owner.index3', compact('rooms', 'pendingBookings', 'availableRooms', 'recentBookings'));
    }

    /**
     * Show the form for editing the specified owner.
     */
    public function edit($id)
    {
        // Find the owner by ID or fail
        $owner = Owner::findOrFail($id);
        return view('owner.edit', compact('owner'));
    }

    /**
     * Update the specified owner in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        // Find the owner by ID or fail, then update their information
        $owner = Owner::findOrFail($id);
        $owner->update($validated);

        // Redirect back to the owners list with a success message
        return redirect()->route('owners.index')->with('success', 'Owner updated successfully!');
    }

    /**
     * Remove the specified owner from storage.
     */
    public function destroy($id)
    {
        // Find the owner by ID or fail, then delete them
        $owner = Owner::findOrFail($id);
        $owner->delete();

        // Redirect back to the owners list with a success message
        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully!');
    }
}
