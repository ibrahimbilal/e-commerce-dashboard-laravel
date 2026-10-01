<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('customer')->latest('id')->paginate(20);

        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'address_title' => ['nullable', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'address_1' => ['nullable', 'string', 'max:100'],
            'address_2' => ['nullable', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:5'],
        ]);

        $address = Address::create($data);

        return redirect()->route('addresses.show', $address)->with('status', 'Address created.');
    }

    public function show(Address $address)
    {
        $address->load(['customer', 'orders']);

        return view('addresses.show', compact('address'));
    }

    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'address_title' => ['nullable', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'address_1' => ['nullable', 'string', 'max:100'],
            'address_2' => ['nullable', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:5'],
        ]);

        $address->update($data);

        return redirect()->route('addresses.show', $address)->with('status', 'Address updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('addresses.index')->with('status', 'Address deleted.');
    }
}
