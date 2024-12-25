<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('customer.home'); // Make sure this view exists
    }

    public function index2()
    {
        return view('admin.index2'); // Make sure this view exists
    }

    public function index3()
    {
        $rooms = Room::where('owner_id', 1)->get();
        $pendingBookings = Booking::whereHas('room', function ($query) {
            $query->where('owner_id', 1);
        })->where('status', 'pending')->count();
        
        $availableRooms = Room::where('owner_id', 1)
            ->where('status', 'available')
            ->count();
        
        $recentBookings = Booking::whereHas('room', function ($query) {
            $query->where('owner_id', 1);
        })->with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('owner.index3', compact('rooms', 'pendingBookings', 'availableRooms', 'recentBookings'));
    }
}
