<?php

namespace App\Http\Controllers;

use App\Models\Owner;  // Ensure this is using the Owner model
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnerController extends Controller
{
    /**
     * Display a listing of the owners.
     */
    public function index()
    {
        // Using the scope method to fetch only owners
        $owners = Owner::owners()->get();
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for editing the specified owner.
     */
    public function edit($id)
    {
        // Find the owner by ID or fail
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified owner in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        // Find the owner by ID or fail, then update their information
        $owner = Owner::findOrFail($id);
        $owner->update($validated);

        // Redirect back to the owners list with a success message
        return redirect()->route('owners.index')->with('success', 'Owner updated successfully!');
    }

    /**
     * Remove the specified owner from storage.
     */
    public function destroy($id)
    {
        // Find the owner by ID or fail, then delete them
        $owner = Owner::findOrFail($id);
        $owner->delete();

        // Redirect back to the owners list with a success message
        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully!');
    }

    public function export()
    {
        // Retrieve the owners data
        $owners = Owner::all();

        // Generate the PDF from the admin.owners.export view
        $pdf = PDF::loadView('admin.owners.export', compact('owners'));

        // Download the generated PDF
        return $pdf->download('owners.pdf');
    }
}