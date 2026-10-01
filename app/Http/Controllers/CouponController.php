<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Support\CouponQuery;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view discounts', ['only' => ['index', 'show']]);
        $this->middleware('permission:add discounts', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit discounts', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete discounts', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'active', 'expired'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Coupon::query()->count(),
            'active' => CouponQuery::activeWithinDates()->count(),
            'expired' => CouponQuery::expiredByDate()->count(),
            'trashed' => Coupon::query()->onlyTrashed()->count(),
        ];

        $query = Coupon::withCount('orders');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($request->query('active') === '1') {
            $query->whereIn('id', CouponQuery::activeWithinDates()->select('id'));
        }

        if ($request->query('expired') === '1') {
            $query->whereIn('id', CouponQuery::expiredByDate()->select('id'));
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%');
            });
        }

        $coupons = $query->latest('id')->get();

        return view('coupons.index', compact('coupons', 'counts', 'filters'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:10', 'unique:coupons,code'],
            'discount' => ['required', 'numeric'],
            'type' => ['nullable', 'string', 'max:10'],
            'usage_limit' => ['required', 'integer', 'min:0'],
            'usage_per_customer' => ['required', 'integer', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'active' => ['sometimes', 'boolean'],
        ]);

        $coupon = Coupon::create($data);

        return redirect()->route('coupons.index')->with('status', 'Coupon created.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['orders.customer', 'customers']);

        return view('coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:10', 'unique:coupons,code,'.$coupon->id],
            'discount' => ['required', 'numeric'],
            'type' => ['nullable', 'string', 'max:10'],
            'usage_limit' => ['required', 'integer', 'min:0'],
            'usage_per_customer' => ['required', 'integer', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'active' => ['sometimes', 'boolean'],
        ]);

        $coupon->update($data);

        return redirect()->route('coupons.index')->with('status', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('status', 'Coupon deleted.');
    }
}
