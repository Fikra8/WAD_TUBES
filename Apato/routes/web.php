<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController; 
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

// Home route after login with email verification
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rooms routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/book-room', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/book-room', [RoomController::class, 'store'])->name('rooms.book');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

route::get('admin/home',[HomeController::class,'index2']);

route::get('owner/home',[HomeController::class,'index3']);