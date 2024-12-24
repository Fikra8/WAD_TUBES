<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a listing of customers
    public function index()
    {
        $customers = Customer::all();
        return view('home', compact('customers')); // Pass customers to home view
    }

    // Show the form for creating a new customer
    public function create()
    {
        return view('customers.create');
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
        return view('customers.edit', compact('customer'));
    }

    // Update the specified customer in storage
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_code' => 'required|max:10|unique:customers,customer_code,' . $customer->id,
            'customer_name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'required',
        ]);

        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Remove the specified customer from storage
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
