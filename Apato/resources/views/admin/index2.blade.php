<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar bg-dark text-white" style="position: fixed; top: 0; left: 0; height: 100vh; padding: 0;">
                <div class="position-sticky">
                    <h4 class="px-3 py-3 text-white fw-bold">Apato</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active d-flex align-items-center" href="/admin/home">
                                <i class="bi bi-house-door me-2"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/admin/customers">
                                <i class="bi bi-people me-2"></i> Manage Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="{{ route('admin.owners.index') }}">
                                <i class="bi bi-people me-2"></i> Manage Owners
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/admin/profile">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-white d-flex align-items-center" href="/settings">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Hi, Admin!</h1>
                </div>

                <div class="text-center">
                    <h2 class="mb-3">Get Started on Manage Users</h2>
                    <p class="lead mb-4">Manage the users that use APATO.</p>
                    <div class="mb-4">
                        <img src="{{ asset('images/booking-room.jpg') }}" alt="Booking Room Image" class="img-fluid rounded" style="max-height: 500px; width: 50%; object-fit: cover;">
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/admin/customers" class="btn btn-primary btn-lg mb-5">Manage Customers</a>
                        <a href="{{ route('admin.owners.index') }}" class="btn btn-primary btn-lg mb-5">Manage Owners</a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
