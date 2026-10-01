<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view orders', ['only' => ['index', 'show']]);
        $this->middleware('permission:add orders', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit orders', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete orders', ['only' => ['destroy']]);
    }

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
        $payload = $this->validatedOrderPayload($request);

        $order = DB::transaction(function () use ($payload) {
            $items = $payload['items'] ?? [];
            $payload['order']['amount'] = $this->amountFromLineItems($items);
            $order = Order::create($payload['order']);
            $this->persistOrderItems($order, $items);

            return $order;
        });

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
        $payload = $this->validatedOrderPayload($request, $order);

        DB::transaction(function () use ($order, $payload) {
            if ($payload['items'] !== null) {
                $this->persistOrderItems($order, $payload['items']);
                $payload['order']['amount'] = $this->amountFromLineItems($payload['items']);
            } else {
                $order->load('items');
                $payload['order']['amount'] = $this->amountFromItems($order->items);
            }

            $order->update($payload['order']);
        });

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
     * @return array{order: array<string, mixed>, items: array<int, array<string, mixed>>|null}
     */
    private function validatedOrderPayload(Request $request, ?Order $order = null): array
    {
        $rules = [
            'customer_id' => ['required_without:customer', 'integer', 'exists:customers,id'],
            'customer' => ['required_without:customer_id', 'integer', 'exists:customers,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'order_status_id' => ['required_without:order_status', 'integer', 'exists:order_statuses,id'],
            'order_status' => ['required_without:order_status_id', 'integer', 'exists:order_statuses,id'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'coupon' => ['nullable', 'integer', 'exists:coupons,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
            'items' => ['nullable', 'array'],
            'items.*.product_attribute_id' => ['required', 'integer', 'exists:products_attributes,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'integer'],
        ];

        $validated = $request->validate($rules);

        $customerId = $validated['customer_id'] ?? $validated['customer'];
        $couponId = $validated['coupon_id'] ?? $validated['coupon'] ?? null;

        $this->assertCouponUsable($couponId, (int) $customerId, $order);

        $items = $request->has('items') ? ($validated['items'] ?? []) : null;

        return [
            'order' => [
                'customer_id' => $customerId,
                'address_id' => $validated['address_id'],
                'amount' => 0,
                'order_status_id' => $validated['order_status_id'] ?? $validated['order_status'],
                'coupon_id' => $couponId,
                'updated_by' => $validated['updated_by'] ?? optional($request->user())->id,
            ],
            'items' => $items,
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    private function persistOrderItems(Order $order, array $items): void
    {
        $order->items()->delete();

        foreach ($items as $item) {
            $order->items()->create([
                'product_attribute_id' => $item['product_attribute_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    private function amountFromLineItems(array $items): int
    {
        return (int) array_sum(array_map(
            fn (array $item) => $item['quantity'] * $item['price'],
            $items
        ));
    }

    /**
     * @param  \Illuminate\Support\Collection<int, \App\Models\OrderItem>|\Illuminate\Database\Eloquent\Collection  $items
     */
    private function amountFromItems($items): int
    {
        return (int) $items->sum(fn ($item) => $item->quantity * $item->price);
    }

    private function assertCouponUsable(?int $couponId, int $customerId, ?Order $order = null): void
    {
        if (! $couponId) {
            return;
        }

        $coupon = Coupon::query()->find($couponId);

        if (! $coupon || ! $coupon->active) {
            throw ValidationException::withMessages([
                'coupon_id' => ['The selected coupon is not active.'],
            ]);
        }

        if ($coupon->expired_at && $coupon->expired_at->isPast()) {
            throw ValidationException::withMessages([
                'coupon_id' => ['The selected coupon has expired.'],
            ]);
        }

        $ordersQuery = Order::query()->where('coupon_id', $couponId);
        if ($order) {
            $ordersQuery->whereKeyNot($order->id);
        }

        $totalUsage = $ordersQuery->count();

        if ($coupon->usage_limit > 0 && $totalUsage >= $coupon->usage_limit) {
            throw ValidationException::withMessages([
                'coupon_id' => ['This coupon has reached its usage limit.'],
            ]);
        }

        $customerUsageQuery = Order::query()
            ->where('coupon_id', $couponId)
            ->where('customer_id', $customerId);

        if ($order) {
            $customerUsageQuery->whereKeyNot($order->id);
        }

        $customerUsage = $customerUsageQuery->count();

        if ($coupon->usage_per_customer > 0 && $customerUsage >= $coupon->usage_per_customer) {
            throw ValidationException::withMessages([
                'coupon_id' => ['This customer has reached the usage limit for this coupon.'],
            ]);
        }
    }
}
