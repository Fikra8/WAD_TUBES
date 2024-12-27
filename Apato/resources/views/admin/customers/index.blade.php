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
                <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h2>Manage Customers</h2>
                        <form action="{{ route('customers.sync') }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Synchronize Customers</button>
                        </form>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">Edit</button>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @include('admin.customers.edit', ['customer' => $customer])
                            @endforeach
                        </tbody>
                    </table>
                </div>
</x-app-layout>
