<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Coupon;
use App\Support\CouponQuery;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view discounts', ['only' => ['index', 'show']]);
        $this->middleware('permission:add discounts', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit discounts', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete discounts', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('discounts');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'active', 'expired', 'inactive'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Coupon::query()->count(),
            'active' => CouponQuery::activeWithinDates()->count(),
            'inactive' => CouponQuery::inactiveNotExpired()->count(),
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

        if ($request->query('inactive') === '1') {
            $query->whereIn('id', CouponQuery::inactiveNotExpired()->select('id'));
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%');
            });
        }

        $coupons = $query->latest('id')->get();

        return view('admin.coupons.index', compact('coupons', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.coupons.create');
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

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon created.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['orders.customer', 'customers']);

        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
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

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon updated.');
    }

    public function destroy(Request $request, Coupon $coupon)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $coupon,
            'Cannot delete this coupon because it is used on orders.'
        )) {
            return $blocked;
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon deleted.');
    }

    public function restore(Request $request, int $id)
    {
        $coupon = $this->findOnlyTrashed(Coupon::class, $id);
        $coupon->restore();

        return $this->trashedActionResponse($request, 'admin.coupons.index', 'Coupon restored.');
    }

    public function forceDelete(Request $request, int $id)
    {
        $coupon = $this->findOnlyTrashed(Coupon::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $coupon,
            'Cannot permanently delete this coupon because it is used on orders.'
        )) {
            return $blocked;
        }

        $coupon->forceDelete();

        return $this->trashedActionResponse($request, 'admin.coupons.index', 'Coupon permanently deleted.');
    }
}
