<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['customer', 'product.locales'])
            ->latest('id')
            ->paginate(20);

        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('reviews.create');
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

        return redirect()->route('reviews.show', $review)->with('status', 'Review created.');
    }

    public function show(Review $review)
    {
        $review->load(['customer', 'product.locales']);

        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
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

        return redirect()->route('reviews.show', $review)->with('status', 'Review updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('status', 'Review deleted.');
    }
}
