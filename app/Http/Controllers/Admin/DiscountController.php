<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Http\Controllers\Concerns\TogglesAdminResourceFields;
use App\Models\Discount;
use App\Support\DiscountQuery;
use App\Support\AdminResourceCounts;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    use ManagesTrashedRecords;
    use TogglesAdminResourceFields;

    public function __construct()
    {
        $this->middleware('permission:view discounts', ['only' => ['index', 'show']]);
        $this->middleware('permission:add discounts', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit discounts', ['only' => ['edit', 'update', 'toggle']]);
        $this->middleware('permission:delete discounts', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('discounts');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'active', 'expired', 'inactive'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Discount::query()->count(),
            'active' => DiscountQuery::activeWithinDates()->count(),
            'inactive' => DiscountQuery::inactiveNotExpired()->count(),
            'expired' => DiscountQuery::expiredByDate()->count(),
            'trashed' => Discount::query()->onlyTrashed()->count(),
        ];

        $query = Discount::query();

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($request->query('active') === '1') {
            $query->whereIn('id', DiscountQuery::activeWithinDates()->select('id'));
        }

        if ($request->query('expired') === '1') {
            $query->whereIn('id', DiscountQuery::expiredByDate()->select('id'));
        }

        if ($request->query('inactive') === '1') {
            $query->whereIn('id', DiscountQuery::inactiveNotExpired()->select('id'));
        }

        if ($search = $request->query('search')) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        $discounts = $query->latest('id')->get();

        return view('admin.discounts.index', compact('discounts', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'discount' => ['required', 'numeric'],
            'type' => ['nullable', 'string', 'max:10'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'apply_to' => ['nullable', 'string', 'max:191'],
            'active' => ['sometimes', 'boolean'],
        ]);

        $discount = Discount::create($data);

        return redirect()->route('admin.discounts.index')->with('status', 'Discount created.');
    }

    public function show(Discount $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'discount' => ['required', 'numeric'],
            'type' => ['nullable', 'string', 'max:10'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'apply_to' => ['nullable', 'string', 'max:191'],
            'active' => ['sometimes', 'boolean'],
        ]);

        $discount->update($data);

        return redirect()->route('admin.discounts.index')->with('status', 'Discount updated.');
    }

    public function destroy(Request $request, Discount $discount)
    {
        $discount->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.discounts.index',
            'Discount deleted.',
            AdminResourceCounts::discounts()
        );
    }

    public function toggle(Request $request, int $id)
    {
        $discount = Discount::query()->findOrFail($id);

        return $this->toggleResourceField(
            $request,
            $discount,
            AdminResourceCounts::toggleFieldWhitelist()['discounts'],
            fn () => AdminResourceCounts::discounts(),
            'admin.discounts.index'
        );
    }

    public function restore(Request $request, int $id)
    {
        $discount = $this->findOnlyTrashed(Discount::class, $id);
        $discount->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.discounts.index',
            'Discount restored.',
            AdminResourceCounts::discounts()
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $discount = $this->findOnlyTrashed(Discount::class, $id);
        $discount->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.discounts.index',
            'Discount permanently deleted.',
            AdminResourceCounts::discounts()
        );
    }
}
