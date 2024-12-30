<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminOwnerController extends Controller
{
    /**
     * Display a listing of the owners.
     */
    public function index()
    {
        $owners = Owner::where('usertype', 'owner')->get();
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for editing the specified owner.
     */
    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified owner in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $owner = Owner::findOrFail($id);
        $owner->update($validated);

        return redirect()->route('admin.owners.index')->with('success', 'Owner updated successfully!');
    }

    /**
     * Remove the specified owner from storage.
     */
    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();

        return redirect()->route('admin.owners.index')->with('success', 'Owner deleted successfully!');
    }

    /**
     * Export owners list as PDF.
     */
    public function export()
    {
        $owners = Owner::where('usertype', 'owner')->get();
        $pdf = PDF::loadView('admin.owners.export', compact('owners'));
        return $pdf->download('owners-list.pdf');
    }
}
