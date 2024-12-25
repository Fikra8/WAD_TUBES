<x-app-layout>
    <div class="container-fluid my-4">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white" style="position: fixed; top: 0; left: 0; height: 100vh; padding: 0;">
                <div class="position-sticky">
                    <h4 class="px-3 py-3 text-white fw-bold">Apato</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/home">
                                <i class="bi bi-house-door me-2"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/rooms">
                                <i class="bi bi-search me-2"></i> Search Rooms
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white active d-flex align-items-center" href="/booking-history">
                                <i class="bi bi-book me-2"></i> Booking History
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 260px;"> <!-- Add margin to avoid sidebar overlap -->
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Available Rooms in Buahbatu</h3>
                    <form action="{{ route('rooms.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search rooms..." value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

                <!-- Results Section -->
                @if (!empty($rooms))
                    <div class="row">
                        @foreach ($rooms as $room)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Image Section -->
                                    <img src="{{ asset($room['image']) }}" alt="{{ $room['name'] }}" class="img-fluid card-img-top" style="height: 200px; object-fit: cover;">
                                    
                                    <!-- Details Section -->
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $room['name'] }}</h5>
                                        <p class="card-text text-muted">{{ $room['location'] }}</p>
                                        <p class="card-text">
                                            <strong>Rating:</strong> {{ $room['rating'] }} ({{ $room['reviews'] }} reviews)
                                            @if (isset($room['tag']))
                                                <span class="badge bg-success ms-2">{{ $room['tag'] }}</span>
                                            @endif
                                        </p>
                                        <p class="card-text text-danger fw-bold">
                                            {{ $room['discounted_price'] }} 
                                            <del class="text-muted">{{ $room['original_price'] }}</del>
                                        </p>
                                        <a href="{{ route('add_booking', ['id' => $room->id]) }}" class="btn btn-primary">Select Room</a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        No rooms found for your search criteria.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
