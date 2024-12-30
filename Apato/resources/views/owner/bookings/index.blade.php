<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white" style="position: fixed; top: 0; left: 0; height: 100vh; padding: 0;">
                <div class="position-sticky">
                    <h4 class="px-3 py-3 text-white fw-bold">Apato</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/home">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/rooms">
                                <i class="bi bi-building me-2"></i> Manage Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active d-flex align-items-center" href="/owner/bookings">
                                <i class="bi bi-calendar-check me-2"></i> Booking Requests
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
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Booking Requests</h1>
                </div>

                <!-- Bookings Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Customer</th>
                                <th>Check-in Date</th>
                                <th>Duration</th>
                                <th>Total Price</th>
                                <th>Payment Proof</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->room->name }}</td>
                                <td>Guest User</td>
                                <td>{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                <td>{{ $booking->duration_months }} month(s)</td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($booking->payment_proof)
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#proofModal{{ $booking->id }}">
                                            View Proof
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="proofModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Payment Proof</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ $booking->payment_proof }}" alt="Payment Proof" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">No proof uploaded</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->status === 'pending')
                                        <button type="button" class="btn btn-sm btn-success me-2" onclick="approveBooking({{ $booking->id }})">Approve</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure?')) rejectBooking({{ $booking->id }})">Reject</button>
                                    @else
                                        <span class="text-muted">No actions available</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script>
        function approveBooking(bookingId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/owner/bookings/${bookingId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            
            const status = document.createElement('input');
            status.type = 'hidden';
            status.name = 'status';
            status.value = 'approved';
            
            form.appendChild(csrfToken);
            form.appendChild(method);
            form.appendChild(status);
            document.body.appendChild(form);
            form.submit();
        }

        function rejectBooking(bookingId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/owner/bookings/${bookingId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            
            const status = document.createElement('input');
            status.type = 'hidden';
            status.name = 'status';
            status.value = 'rejected';
            
            form.appendChild(csrfToken);
            form.appendChild(method);
            form.appendChild(status);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-app-layout>
