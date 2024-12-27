<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a listing of customers
    public function index()
    {
        $customers = Customer::with('user')->get();
        $users = User::all();
        /* dd($customers); */
        return view('owner.customers.index', compact('customers'));
    }

    // Show the form for creating a new customer
    public function create()
    {
        return view('customers.create');
    }

    public function syncFromUsers()
    {
        // Fetch users with usertype = 'customer' who are not already in tbcustomers
        $users = User::where('usertype', 'customer')
            ->whereNotIn('id', Customer::pluck('user_id'))
            ->get();

        foreach ($users as $user) {
            Customer::create([
                'user_id' => $user->id,        // Ensure user_id is set
                'name' => $user->name,        // Optional: only if name is needed
                'email' => $user->email,      // Optional: only if email is needed
                'phone' => $user->phone,      // Optional: only if phone is needed
                'address' => $user->address,  // Optional: only if address is needed
            ]);
        }

        return redirect()->route('customers.index')->with('success', 'Customers synchronized successfully.');
    }



    // Store a newly created customer in storage
    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code|max:10',
            'customer_name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    // Display the specified customer
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    // Show the form for editing the specified customer
    public function edit(Customer $customer)
    {
        return view('owner.customers.edit', compact('customer'));
    }

    // Update the specified customer in storage
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:tbcustomers,email,' . $customer->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->only(['name', 'email', 'phone', 'address']));
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    

    // Remove the specified customer from storage
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
