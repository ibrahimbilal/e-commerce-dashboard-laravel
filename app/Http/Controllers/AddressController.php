<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view addresses', ['only' => ['index', 'show']]);
        $this->middleware('permission:add addresses', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit addresses', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete addresses', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Address::query()->count(),
            'trashed' => Address::query()->onlyTrashed()->count(),
        ];

        $query = Address::with('customer');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('address_title', 'like', '%'.$search.'%')
                    ->orWhere('city', 'like', '%'.$search.'%')
                    ->orWhereHas('customer', fn ($customer) => $customer->where('email', 'like', '%'.$search.'%'));
            });
        }

        $addresses = $query->latest('id')->get();

        return view('addresses.index', compact('addresses', 'counts', 'filters'));
    }

    public function create()
    {
        return view('addresses.create', [
            'customers' => Customer::orderBy('first_name')->orderBy('last_name')->get(),
        ]);
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
        return view('addresses.edit', [
            'address' => $address,
            'customers' => Customer::orderBy('first_name')->orderBy('last_name')->get(),
        ]);
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
