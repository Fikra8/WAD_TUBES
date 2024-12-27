<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white" style="position: fixed; top: 0; left: 0; height: 100vh; padding: 0;">
                <div class="position-sticky">
                    <h4 class="px-3 py-3 text-white fw-bold">Apato</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active d-flex align-items-center" href="/owner/home">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/rooms">
                                <i class="bi bi-building me-2"></i> Manage Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/bookings">
                                <i class="bi bi-calendar-check me-2"></i> Booking Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/customers">
                                <i class="bi bi-people me-2"></i> Manage Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/profile">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Owner Dashboard</h1>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <!-- Total Rooms Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-primary h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-muted text-uppercase">Total Rooms</h6>
                                        <h2 class="mb-0">{{ $rooms->count() ?? 0 }}</h2>
                                    </div>
                                    <div class="text-primary">
                                        <i class="bi bi-building fs-1"></i>
                                    </div>
                                </div>
                                <a href="/owner/rooms" class="btn btn-sm btn-outline-primary mt-3">Manage Rooms</a>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Bookings Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-warning h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-muted text-uppercase">Pending Bookings</h6>
                                        <h2 class="mb-0">{{ $pendingBookings ?? 0 }}</h2>
                                    </div>
                                    <div class="text-warning">
                                        <i class="bi bi-clock-history fs-1"></i>
                                    </div>
                                </div>
                                <a href="/owner/bookings" class="btn btn-sm btn-outline-warning mt-3">View Requests</a>
                            </div>
                        </div>
                    </div>

                    <!-- Available Rooms Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-success h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-muted text-uppercase">Available Rooms</h6>
                                        <h2 class="mb-0">{{ $availableRooms ?? 0 }}</h2>
                                    </div>
                                    <div class="text-success">
                                        <i class="bi bi-check-circle fs-1"></i>
                                    </div>
                                </div>
                                <a href="{{ route('owner.rooms.index') }}" class="btn btn-sm btn-outline-success mt-3">Add New Room</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Bookings</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Room</th>
                                                <th>Customer</th>
                                                <th>Check-in Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentBookings ?? [] as $booking)
                                            <tr>
                                                <td>{{ $booking->room->name }}</td>
                                                <td>{{ $booking->user->name }}</td>
                                                <td>{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'approved' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="/owner/bookings" class="btn btn-sm btn-outline-primary">View Details</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No recent bookings</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
