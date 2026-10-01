<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reviews', ['only' => ['index', 'show']]);
        $this->middleware('permission:add reviews', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit reviews', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete reviews', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Review::query()->count(),
            'trashed' => Review::query()->onlyTrashed()->count(),
        ];

        $query = Review::with(['customer', 'product.locales']);

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where('comment', 'like', '%'.$search.'%');
        }

        $reviews = $query->latest('id')->paginate(20)->withQueryString();

        return view('reviews.index', compact('reviews', 'counts', 'filters'));
    }

    public function create()
    {
        return view('reviews.create', $this->reviewFormLookups());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'comment' => ['required', 'string', 'max:191'],
            'rate' => ['required', 'integer', 'min:0', 'max:5'],
        ]);

        $review = Review::create($data);

        return redirect()->route('reviews.index')->with('status', 'Review created.');
    }

    public function show(Review $review)
    {
        $review->load(['customer', 'product.locales']);

        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('reviews.edit', array_merge(
            compact('review'),
            $this->reviewFormLookups()
        ));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'comment' => ['required', 'string', 'max:191'],
            'rate' => ['required', 'integer', 'min:0', 'max:5'],
        ]);

        $review->update($data);

        return redirect()->route('reviews.index')->with('status', 'Review updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('status', 'Review deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function reviewFormLookups(): array
    {
        return [
            'customers' => Customer::orderBy('first_name')->orderBy('last_name')->get(),
            'products' => Product::with('locales')->orderBy('id')->get(),
        ];
    }
}
