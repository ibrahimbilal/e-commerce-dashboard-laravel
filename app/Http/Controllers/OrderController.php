<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'orderStatus', 'coupon', 'items.productAttribute.product'])
            ->latest('id')
            ->paginate(20);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'amount' => ['required', 'integer'],
            'order_status_id' => ['required', 'integer', 'exists:order_statuses,id'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $order = Order::create($data);

        return redirect()->route('orders.show', $order)->with('status', 'Order created.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'address', 'orderStatus', 'coupon', 'items.productAttribute.product', 'invoice']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'amount' => ['required', 'integer'],
            'order_status_id' => ['required', 'integer', 'exists:order_statuses,id'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $order->update($data);

        return redirect()->route('orders.show', $order)->with('status', 'Order updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('status', 'Order deleted.');
    }
}
