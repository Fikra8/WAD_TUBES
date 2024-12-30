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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 250px;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Booking History</h1>
                </div>

                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Booking History Table -->
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Name</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>People Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($custbookings as $booking)
                                        <tr>
                                            <!-- Access room name via the room relationship -->
                                            <td>{{ $custbookings->room->name }}</td>
                                            <td>{{ $custbookings->name }}</td>
                                            <td>{{ $custbookings->date_from }}</td>
                                            <td>{{ $custbookings->date_to }}</td>
                                            <td>{{ $custbookings->people_count }}</td>
                                            <td>
                                                <!-- Edit and Delete Actions -->
                                                <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No bookings found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
