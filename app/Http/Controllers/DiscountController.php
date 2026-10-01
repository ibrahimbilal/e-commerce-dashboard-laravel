<?php

namespace App\Http\Controllers;

use App\Models\Discount;
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

    public function index()
    {
        $discounts = Discount::latest('id')->paginate(20);

        return view('discounts.index', compact('discounts'));
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
