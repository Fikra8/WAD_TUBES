<x-app-layout>
    <div class="container-fluid">
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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Welcome Back!</h1>
                </div>

                <div class="text-center">
                    <h2 class="mb-3">Get Started on Booking Your Room</h2>
                    <p class="lead mb-4">Explore available rooms, manage your bookings, and more.</p>
                    <div class="mb-4">
                        <img src="{{ asset('images/booking-room.jpg') }}" alt="Booking Room Image" class="img-fluid rounded" style="max-height: 500px; width: 50%; object-fit: cover;">
                    </div>
                    <a href="/rooms" class="btn btn-primary btn-lg mb-5">Book Now</a>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>