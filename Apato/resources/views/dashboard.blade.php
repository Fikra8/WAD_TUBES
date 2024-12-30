<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome Back!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-2xl font-bold mb-4">Get Started on Booking Your Room</h1>
                    <p class="text-gray-600 mb-6">Explore available rooms, manage your bookings, and more.</p>
                    <img src="{{ asset('images/room.jpg') }}" alt="Room Image" class="rounded-lg shadow-md w-3/4 mx-auto mb-6">
                    <a href="" class="px-6 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
