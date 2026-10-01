<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'address', 'orderStatus', 'coupon', 'items.productAttribute.product'])
            ->latest('id')
            ->paginate(20);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create', $this->orderFormLookups());
    }

    public function store(Request $request)
    {
        $data = $this->validatedOrder($request);

        $order = Order::create($data);

        $this->syncOrderItems($order, $request);

        return redirect()->route('orders.edit', $order)->with('status', 'Order created.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'address', 'orderStatus', 'coupon', 'items.productAttribute.product', 'invoice']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['customer', 'address', 'orderStatus', 'coupon', 'items']);

        return view('orders.edit', [
            'order' => $order,
            ...$this->orderFormLookups($order),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validatedOrder($request));

        $this->syncOrderItems($order, $request);

        return redirect()->route('orders.edit', $order)->with('status', 'Order updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('status', 'Order deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function orderFormLookups(?Order $order = null): array
    {
        $addressesQuery = Address::with('customer')->orderBy('id');

        if ($order?->customer_id) {
            $addressesQuery->where('customer_id', $order->customer_id);
        }

        return [
            'customers' => Customer::orderBy('first_name')->orderBy('last_name')->get(),
            'addresses' => $addressesQuery->get(),
            'orderStatuses' => OrderStatus::orderBy('title')->get(),
            'coupons' => Coupon::orderBy('title')->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedOrder(Request $request): array
    {
        $validated = $request->validate([
            'customer_id' => ['required_without:customer', 'integer', 'exists:customers,id'],
            'customer' => ['required_without:customer_id', 'integer', 'exists:customers,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'amount' => ['required', 'integer'],
            'order_status_id' => ['required_without:order_status', 'integer', 'exists:order_statuses,id'],
            'order_status' => ['required_without:order_status_id', 'integer', 'exists:order_statuses,id'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'coupon' => ['nullable', 'integer', 'exists:coupons,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        return [
            'customer_id' => $validated['customer_id'] ?? $validated['customer'],
            'address_id' => $validated['address_id'],
            'amount' => $validated['amount'],
            'order_status_id' => $validated['order_status_id'] ?? $validated['order_status'],
            'coupon_id' => $validated['coupon_id'] ?? $validated['coupon'] ?? null,
            'updated_by' => $validated['updated_by'] ?? optional($request->user())->id,
        ];
    }

    private function syncOrderItems(Order $order, Request $request): void
    {
        if (! $request->has('items')) {
            return;
        }

        $validated = $request->validate([
            'items' => ['nullable', 'array'],
            'items.*.product_attribute_id' => ['required', 'integer', 'exists:products_attributes,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'integer'],
        ]);

        $order->items()->delete();

        foreach ($validated['items'] ?? [] as $item) {
            $order->items()->create([
                'product_attribute_id' => $item['product_attribute_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }
}
