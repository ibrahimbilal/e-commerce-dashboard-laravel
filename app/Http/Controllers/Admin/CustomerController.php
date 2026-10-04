<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Customer;
use App\Support\AdminFormResponse;
use App\Support\AdminResourceCounts;
use App\Support\CustomerAddressSync;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view customers', ['only' => ['index', 'show']]);
        $this->middleware('permission:add customers', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit customers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete customers', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('customers');
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

        $customers = $query->latest('id')->get();

        return view('admin.customers.index', compact('customers', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(array_merge([
            'email' => ['required', 'email', 'max:50', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:8'],
            'gender' => ['nullable', 'string', 'max:191'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
            'ip_address' => ['nullable', 'string', 'max:50'],
        ], CustomerAddressSync::customerRules()), [], CustomerAddressSync::validationAttributeNames());

        $data['password'] = Hash::make($data['password']);

        $customer = DB::transaction(function () use ($request, $data) {
            $customer = Customer::create(collect($data)->except(['addresses', 'addresses_sync'])->all());
            CustomerAddressSync::createForCustomer($customer, $request);

            return $customer;
        });

        return AdminFormResponse::saved(
            $request,
            'Customer created.',
            fn () => redirect()->route('admin.customers.show', $customer)
        );
    }

    public function show(Customer $customer)
    {
        $customer->load(['addresses', 'orders.orderStatus', 'reviews.product', 'coupons']);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $customer->load(['addresses' => fn ($query) => $query->orderBy('id')]);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        CustomerAddressSync::assertAddressIdsBelongToCustomer($request, $customer);

        $data = $request->validate(array_merge([
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
        ], CustomerAddressSync::customerRules()), [], CustomerAddressSync::validationAttributeNames());

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        DB::transaction(function () use ($request, $customer, $data) {
            $customer->update(collect($data)->except(['addresses', 'addresses_sync'])->all());
            CustomerAddressSync::syncForCustomer($customer, $request);
        });

        return AdminFormResponse::saved(
            $request,
            'Customer updated.',
            fn () => redirect()->route('admin.customers.show', $customer)
        );
    }

    public function destroy(Request $request, Customer $customer)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $customer,
            'Cannot delete this customer because they have orders.'
        )) {
            return $blocked;
        }

        $customer->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.customers.index',
            'Customer deleted.',
            AdminResourceCounts::customers()
        );
    }

    public function restore(Request $request, int $id)
    {
        $customer = $this->findOnlyTrashed(Customer::class, $id);
        $customer->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.customers.index',
            'Customer restored.',
            AdminResourceCounts::customers()
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $customer = $this->findOnlyTrashed(Customer::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $customer,
            'Cannot permanently delete this customer because they have orders.'
        )) {
            return $blocked;
        }

        $customer->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.customers.index',
            'Customer permanently deleted.',
            AdminResourceCounts::customers()
        );
    }
}
