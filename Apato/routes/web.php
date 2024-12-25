<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing');
});

// Authentication routes with email verification enabled
Auth::routes(['verify' => true]);

// Authentication routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Email verification routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.send');

// Rooms routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index'); // View all rooms
Route::get('/rooms/{id}/book', [RoomController::class, 'create'])->name('rooms.create'); // Book specific room (dynamic route)
Route::post('/rooms/{id}/book', [RoomController::class, 'store'])->name('add_booking'); // Handle booking form submission
Route::post('/add_bookings/{roomId}', [RoomController::class, 'store'])->name('add_bookings');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/booking-history', [BookingController::class, 'index'])->name('booking-history.index'); // View all bookings
Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit'); // Edit a booking
Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update'); // Update booking
Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy'); // Delete booking
Route::resource('booking-history', BookingController::class)->except(['show']);

Route::get('admin/home',[HomeController::class,'index2']);

// Owner routes
Route::prefix('owner')->group(function () {
    Route::get('/home', [HomeController::class, 'index3']);
    
    // Room management routes
    Route::get('/rooms', [App\Http\Controllers\Owner\RoomManagementController::class, 'index'])->name('owner.rooms.index');
    Route::get('/rooms/{room}', [App\Http\Controllers\Owner\RoomManagementController::class, 'show'])->name('owner.rooms.show');
    Route::post('/rooms', [App\Http\Controllers\Owner\RoomManagementController::class, 'store'])->name('owner.rooms.store');
    Route::put('/rooms/{room}', [App\Http\Controllers\Owner\RoomManagementController::class, 'update'])->name('owner.rooms.update');
    Route::delete('/rooms/{room}', [App\Http\Controllers\Owner\RoomManagementController::class, 'destroy'])->name('owner.rooms.destroy');
    
    // Booking management routes
    Route::get('/bookings', [App\Http\Controllers\Owner\RoomManagementController::class, 'bookings'])->name('owner.bookings.index');
    Route::put('/bookings/{booking}', [App\Http\Controllers\Owner\RoomManagementController::class, 'handleBooking'])->name('owner.bookings.handle');
});
