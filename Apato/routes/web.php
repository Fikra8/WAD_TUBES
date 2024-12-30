<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OwnerController;

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
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{id}/book', [RoomController::class, 'create'])->name('add_booking');
Route::post('/rooms/{id}/book', [RoomController::class, 'store'])->name('store_booking');

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/home',[HomeController::class,'index2']);

    // Customer management routes
    Route::post('/customers/sync', [CustomerController::class, 'syncFromUsers'])->name('customers.sync');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::resource('customers', CustomerController::class);
});

// Booking routes
Route::get('/booking-history', [BookingController::class, 'index'])->name('booking-history.index');
Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
Route::resource('booking-history', BookingController::class)->except(['show']);

// Owner routes
Route::prefix('owner')->group(function () {
    // Public owner routes (no auth required)
    Route::get('/', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/home', [OwnerController::class, 'index'])->name('owner.home');
    Route::get('/{owner}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::put('/{owner}', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');
    Route::get('/export', [OwnerController::class, 'export'])->name('owners.export');

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
