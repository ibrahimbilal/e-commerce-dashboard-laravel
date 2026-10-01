<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Support\IndexListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view customers', ['only' => ['index', 'show']]);
        $this->middleware('permission:add customers', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit customers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete customers', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Customer::query()->count(),
            'trashed' => Customer::query()->onlyTrashed()->count(),
        ];

        $query = Customer::withCount(['orders', 'reviews']);

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('email', 'like', '%'.$search.'%')
                    ->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%');
            });
        }

        $customers = $query->latest('id')->paginate(20)->withQueryString();

        return view('customers.index', compact('customers', 'counts', 'filters'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:8'],
            'gender' => ['nullable', 'string', 'max:191'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
            'ip_address' => ['nullable', 'string', 'max:50'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $customer = Customer::create($data);

        return redirect()->route('customers.show', $customer)->with('status', 'Customer created.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['addresses', 'orders.orderStatus', 'reviews.product', 'coupons']);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50', 'unique:customers,email,'.$customer->id],
            'password' => ['nullable', 'string', 'min:8'],
            'gender' => ['nullable', 'string', 'max:191'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
            'ip_address' => ['nullable', 'string', 'max:50'],
            'deleted' => ['sometimes', 'boolean'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return redirect()->route('customers.show', $customer)->with('status', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer deleted.');
    }
}
