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
                            <a class="nav-link text-white active d-flex align-items-center" href="/owner/rooms">
                                <i class="bi bi-building me-2"></i> Manage Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/owner/bookings">
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
                    <h1 class="h2">Manage Rooms</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="bi bi-plus-lg"></i> Add New Room
                    </button>
                </div>

                <!-- Rooms Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Type</th>
                                <th>Price/Month</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->type }}</td>
                                <td>Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="editRoom({{ $room->id }})">Edit</button>
                                    <form action="{{ route('owner.rooms.destroy', $room) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('owner.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Room Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Month</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Room Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editRoomForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_type" class="form-label">Room Type</label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price per Month</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Room Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editRoom(roomId) {
            // Get room data via AJAX
            fetch(`/owner/rooms/${roomId}`)
                .then(response => response.json())
                .then(room => {
                    // Populate form fields
                    document.getElementById('edit_name').value = room.name;
                    document.getElementById('edit_type').value = room.type;
                    document.getElementById('edit_price').value = room.price;
                    document.getElementById('edit_description').value = room.description;
                    document.getElementById('edit_status').value = room.status;
                    
                    // Update form action URL
                    document.getElementById('editRoomForm').action = `/owner/rooms/${roomId}`;
                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('editRoomModal')).show();
                });
        }
    </script>
</x-app-layout>
