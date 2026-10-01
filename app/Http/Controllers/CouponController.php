<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::withCount('orders')->latest('id')->paginate(20);

        return view('coupons.index', compact('coupons'));
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

        return redirect()->route('coupons.show', $coupon)->with('status', 'Coupon created.');
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

        return redirect()->route('coupons.show', $coupon)->with('status', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('status', 'Coupon deleted.');
    }
}
