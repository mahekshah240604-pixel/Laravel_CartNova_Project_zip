<?php
// app/Http/Controllers/AddressController.php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // ── List all addresses ─────────────────────────────────────
    // Route: GET /addresses
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())
                            ->orderByDesc('is_default')
                            ->latest()
                            ->get();

        return view('addresses.index', compact('addresses'));
    }

    // ── Show create form ───────────────────────────────────────
    // Route: GET /addresses/create
    public function create()
    {
        return view('addresses.create');
    }

    // ── Store new address ──────────────────────────────────────
    // Route: POST /addresses
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'     => ['required','string','min:2','max:100'],
            'phone'         => ['required','digits:10'],
            'address_line1' => ['required','string','min:5','max:255'],
            'address_line2' => ['nullable','string','max:255'],
            'city'          => ['required','string','max:100'],
            'state'         => ['required','string','max:100'],
            'pincode'       => ['required','digits:6'],
            'type'          => ['required','in:home,work,other'],
            'is_default'    => ['boolean'],
        ], [
            'full_name.required'     => 'Enter full name.',
            'phone.required'         => 'Enter a phone number.',
            'phone.digits'           => 'Phone must be 10 digits.',
            'address_line1.required' => 'Enter your street address.',
            'city.required'          => 'Enter your city.',
            'state.required'         => 'Select your state.',
            'pincode.required'       => 'Enter your 6-digit pincode.',
            'pincode.digits'         => 'Pincode must be exactly 6 digits.',
        ]);

        $data['user_id']    = Auth::id();
        $data['is_default'] = $request->boolean('is_default');

        // If setting as default, unset others
        if ($data['is_default']) {
            Address::where('user_id', Auth::id())
                   ->update(['is_default' => false]);
        }

        // First address is always default
        $count = Address::where('user_id', Auth::id())->count();
        if ($count === 0) {
            $data['is_default'] = true;
        }

        Address::create($data);

        // Redirect back to checkout if coming from there
        if ($request->has('redirect_to_checkout')) {
            return redirect()->route('checkout.index')
                             ->with('success', 'Address added successfully!');
        }

        return redirect()->route('addresses.index')
                         ->with('success', 'Address added successfully!');
    }

    // ── Show edit form ─────────────────────────────────────────
    // Route: GET /addresses/{address}/edit
    public function edit(Address $address)
    {
        // Only owner can edit
        if ($address->user_id !== Auth::id()) abort(403);

        return view('addresses.edit', compact('address'));
    }

    // ── Update address ─────────────────────────────────────────
    // Route: PUT /addresses/{address}
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $data = $request->validate([
            'full_name'     => ['required','string','min:2','max:100'],
            'phone'         => ['required','digits:10'],
            'address_line1' => ['required','string','min:5','max:255'],
            'address_line2' => ['nullable','string','max:255'],
            'city'          => ['required','string','max:100'],
            'state'         => ['required','string','max:100'],
            'pincode'       => ['required','digits:6'],
            'type'          => ['required','in:home,work,other'],
            'is_default'    => ['boolean'],
        ]);

        $data['is_default'] = $request->boolean('is_default');

        if ($data['is_default']) {
            Address::where('user_id', Auth::id())
                   ->where('id', '!=', $address->id)
                   ->update(['is_default' => false]);
        }

        $address->update($data);

        return redirect()->route('addresses.index')
                         ->with('success', 'Address updated successfully!');
    }

    // ── Delete address ─────────────────────────────────────────
    // Route: DELETE /addresses/{address}
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted address was default, set next one as default
        if ($wasDefault) {
            $next = Address::where('user_id', Auth::id())->latest()->first();
            if ($next) $next->update(['is_default' => true]);
        }

        return back()->with('success', 'Address deleted successfully.');
    }

    // ── Set as default ─────────────────────────────────────────
    // Route: PATCH /addresses/{address}/default
    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        // Remove default from all
        Address::where('user_id', Auth::id())
               ->update(['is_default' => false]);

        // Set this one
        $address->update(['is_default' => true]);

        return back()->with('success', '"' . $address->full_name . '\'s" address set as default.');
    }

    // ── Get addresses for checkout (AJAX) ──────────────────────
    // Route: GET /addresses/list
    public function list()
    {
        $addresses = Address::where('user_id', Auth::id())
                            ->orderByDesc('is_default')
                            ->get();

        return response()->json($addresses);
    }
}