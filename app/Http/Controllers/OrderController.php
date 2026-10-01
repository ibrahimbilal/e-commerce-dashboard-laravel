<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProductAttribute;
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
            $payload['order']['amount'] = $this->computeOrderAmount($items, $payload['order']['coupon_id'] ?? null);
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
            }

            $itemsForAmount = $payload['items'] ?? $this->orderItemsToLineFormat($order->items()->get());
            $payload['order']['amount'] = $this->computeOrderAmount(
                $itemsForAmount,
                $payload['order']['coupon_id'] ?? null
            );

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
        ];

        $validated = $request->validate($rules);

        $customerId = (int) ($validated['customer_id'] ?? $validated['customer']);
        $couponId = $validated['coupon_id'] ?? $validated['coupon'] ?? null;

        $this->assertAddressBelongsToCustomer((int) $validated['address_id'], $customerId);
        $this->assertCouponUsable($couponId, $customerId, $order);

        $items = $request->has('items')
            ? $this->resolveOrderLineItems($validated['items'] ?? [])
            : null;

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

    private function assertAddressBelongsToCustomer(int $addressId, int $customerId): void
    {
        if (! Address::query()->whereKey($addressId)->where('customer_id', $customerId)->exists()) {
            throw ValidationException::withMessages([
                'address_id' => ['The selected address does not belong to this customer.'],
            ]);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $rawItems
     * @return array<int, array{product_attribute_id: int, quantity: int, price: int}>
     */
    private function resolveOrderLineItems(array $rawItems): array
    {
        $resolved = [];

        foreach ($rawItems as $row) {
            $variant = ProductAttribute::query()
                ->with('product')
                ->find($row['product_attribute_id']);

            if (! $variant?->product) {
                throw ValidationException::withMessages([
                    'items' => ['One or more product variants are invalid.'],
                ]);
            }

            $product = $variant->product;
            $unitPrice = (int) ($product->sale_price ?? $product->regular_price ?? 0);

            $resolved[] = [
                'product_attribute_id' => (int) $variant->id,
                'quantity' => (int) $row['quantity'],
                'price' => max(0, $unitPrice),
            ];
        }

        return $resolved;
    }

    /**
     * @param  iterable<int, \App\Models\OrderItem>  $orderItems
     * @return array<int, array{product_attribute_id: int, quantity: int, price: int}>
     */
    private function orderItemsToLineFormat(iterable $orderItems): array
    {
        $lines = [];
        foreach ($orderItems as $item) {
            $lines[] = [
                'product_attribute_id' => (int) $item->product_attribute_id,
                'quantity' => (int) $item->quantity,
                'price' => (int) $item->price,
            ];
        }

        return $lines;
    }

    /**
     * Subtotal = sum(quantity × unit price) with unit price from each line (server-resolved on write).
     * Coupon: type "percent" → subtract round(subtotal × discount / 100); type "fixed" (or other) → subtract round(discount).
     * Final amount = max(0, subtotal − deduction).
     *
     * @param  array<int, array{product_attribute_id: int, quantity: int, price: int}>  $items
     */
    private function computeOrderAmount(array $items, ?int $couponId): int
    {
        $subtotal = (int) array_sum(array_map(
            fn (array $item) => $item['quantity'] * $item['price'],
            $items
        ));

        if (! $couponId) {
            return max(0, $subtotal);
        }

        $coupon = Coupon::query()->find($couponId);

        if (! $coupon) {
            return max(0, $subtotal);
        }

        $deduction = 0;
        $type = strtolower((string) ($coupon->type ?? 'percent'));

        if ($type === 'fixed') {
            $deduction = (int) round((float) $coupon->discount);
        } else {
            $deduction = (int) round($subtotal * ((float) $coupon->discount / 100));
        }

        return max(0, $subtotal - $deduction);
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
