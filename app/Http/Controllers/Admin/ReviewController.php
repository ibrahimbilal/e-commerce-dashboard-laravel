<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Product;
use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Review;
use App\Support\AdminResourceCounts;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view reviews', ['only' => ['index', 'show']]);
        $this->middleware('permission:add reviews', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit reviews', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete reviews', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('reviews');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'rating'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Review::query()->count(),
            'trashed' => Review::query()->onlyTrashed()->count(),
        ];

        for ($star = 1; $star <= 5; $star++) {
            $counts['star_'.$star] = Review::query()->where('rate', $star)->count();
        }

        $query = Review::with(['customer', 'product.locales']);

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($rating = $request->query('rating')) {
            $query->where('rate', (int) $rating);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('comment', 'like', '%'.$search.'%')
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('email', 'like', '%'.$search.'%')
                            ->orWhere('first_name', 'like', '%'.$search.'%')
                            ->orWhere('last_name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('product.locales', function ($localeQuery) use ($search) {
                        $localeQuery->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        $reviews = $query->latest('id')->get();

        return view('admin.reviews.index', compact('reviews', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.reviews.create', $this->reviewFormLookups());
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

        return redirect()->route('admin.reviews.index')->with('status', 'Review created.');
    }

    public function show(Review $review)
    {
        $review->load(['customer', 'product.locales']);

        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', array_merge(
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

        return redirect()->route('admin.reviews.index')->with('status', 'Review updated.');
    }

    public function destroy(Request $request, Review $review)
    {
        $review->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.reviews.index',
            'Review deleted.',
            AdminResourceCounts::reviews()
        );
    }

    public function restore(Request $request, int $id)
    {
        $review = $this->findOnlyTrashed(Review::class, $id);
        $review->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.reviews.index',
            'Review restored.',
            AdminResourceCounts::reviews()
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $review = $this->findOnlyTrashed(Review::class, $id);
        $review->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.reviews.index',
            'Review permanently deleted.',
            AdminResourceCounts::reviews()
        );
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
