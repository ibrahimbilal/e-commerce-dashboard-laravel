<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Support\DiscountQuery;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class DiscountController extends Controller
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
            'all' => Discount::query()->count(),
            'active' => DiscountQuery::activeWithinDates()->count(),
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

        if ($search = $request->query('search')) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        $discounts = $query->latest('id')->get();

        return view('discounts.index', compact('discounts', 'counts', 'filters'));
    }

    public function create()
    {
        return view('discounts.create');
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

        return redirect()->route('discounts.index')->with('status', 'Discount created.');
    }

    public function show(Discount $discount)
    {
        return view('discounts.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('discounts.edit', compact('discount'));
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

        return redirect()->route('discounts.index')->with('status', 'Discount updated.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('status', 'Discount deleted.');
    }
}
