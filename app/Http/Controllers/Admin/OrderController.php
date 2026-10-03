<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProductAttribute;
use App\Support\CouponQuery;
use App\Support\AdminResourceCounts;
use App\Support\IndexListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view orders', ['only' => ['index', 'show']]);
        $this->middleware('permission:add orders', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit orders', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete orders', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('orders');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'status', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Order::query()->count(),
            'trashed' => Order::query()->onlyTrashed()->count(),
        ];

        foreach (OrderStatus::query()->orderBy('title')->get() as $status) {
            $counts[Str::slug($status->title)] = Order::query()
                ->where('order_status_id', $status->id)
                ->count();
        }

        $query = Order::with(['customer', 'address', 'orderStatus', 'coupon', 'items.productAttribute.product']);

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($statusSlug = $request->query('status')) {
            $statusId = OrderStatus::query()
                ->get()
                ->first(fn (OrderStatus $status) => Str::slug($status->title) === $statusSlug)
                ?->id;

            if ($statusId) {
                $query->where('order_status_id', $statusId);
            }
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('id', 'like', '%'.$search.'%')
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('email', 'like', '%'.$search.'%')
                            ->orWhere('first_name', 'like', '%'.$search.'%')
                            ->orWhere('last_name', 'like', '%'.$search.'%');
                    });
            });
        }

        $orders = $query->latest('id')->get();

        return view('admin.orders.index', compact('orders', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.orders.create', $this->orderFormLookups());
    }

    public function store(Request $request)
    {
        $payload = $this->validatedOrderPayload($request);

        $order = DB::transaction(function () use ($payload) {
            $items = $payload['items'] ?? [];
            $payload['order']['amount'] = $this->computeOrderAmount(
                $items,
                $payload['order']['coupon_id'] ?? null
            );
            $order = Order::create($payload['order']);
            $this->persistOrderItems($order, $items);

            return $order;
        });

        return redirect()->route('admin.orders.edit', $order)->with('status', 'Order created.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'address', 'orderStatus', 'coupon', 'items.productAttribute.product', 'invoice']);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load([
            'customer',
            'address',
            'orderStatus',
            'coupon',
            'updatedByUser',
            'items.productAttribute',
        ]);

        return view('admin.orders.edit', [
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

        return redirect()->route('admin.orders.edit', $order)->with('status', 'Order updated.');
    }

    public function destroy(Request $request, Order $order)
    {
        $order->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.orders.index',
            'Order deleted.',
            AdminResourceCounts::orders()
        );
    }

    public function restore(Request $request, int $id)
    {
        $order = $this->findOnlyTrashed(Order::class, $id);
        $order->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.orders.index',
            'Order restored.',
            AdminResourceCounts::orders()
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $order = $this->findOnlyTrashed(Order::class, $id);
        $order->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.orders.index',
            'Order permanently deleted.',
            AdminResourceCounts::orders()
        );
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
            'coupons' => $this->couponsForOrderForm($order),
            'productVariants' => $this->productVariantsForOrderForm(),
        ];
    }

    private function productVariantsForOrderForm()
    {
        return ProductAttribute::query()
            ->with([
                'product.locales' => fn ($query) => $query->where('locale', 'en'),
                'attributeOne',
                'attributeTwo',
            ])
            ->orderBy('id')
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection<int, Coupon>
     */
    private function couponsForOrderForm(?Order $order = null)
    {
        return Coupon::query()
            ->orderBy('title')
            ->get()
            ->filter(function (Coupon $coupon) use ($order) {
                if ($order && (int) $order->coupon_id === (int) $coupon->id) {
                    return true;
                }

                return CouponQuery::isUsableForNewSelection($coupon);
            })
            ->values();
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
            ? $this->resolveOrderLineItems($validated['items'] ?? [], $order)
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
    private function resolveOrderLineItems(array $rawItems, ?Order $order = null): array
    {
        $existingLinesByVariant = [];

        if ($order) {
            $order->loadMissing('items');

            foreach ($order->items as $existingItem) {
                $existingLinesByVariant[(int) $existingItem->product_attribute_id] = [
                    'quantity' => (int) $existingItem->quantity,
                    'price' => (int) $existingItem->price,
                ];
            }
        }

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

            $variantId = (int) $variant->id;
            $quantity = (int) $row['quantity'];
            $existing = $existingLinesByVariant[$variantId] ?? null;

            if ($existing !== null && $existing['quantity'] === $quantity) {
                $unitPrice = $existing['price'];
            } else {
                $product = $variant->product;
                $unitPrice = (int) ($product->sale_price ?? $product->regular_price ?? 0);
                $unitPrice = max(0, $unitPrice);
            }

            $resolved[] = [
                'product_attribute_id' => $variantId,
                'quantity' => $quantity,
                'price' => $unitPrice,
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
     *
     * @param  array<int, array{product_attribute_id: int, quantity: int, price: int}>  $items
     */
    private function computeOrderSubtotal(array $items): int
    {
        $subtotal = (int) array_sum(array_map(
            fn (array $item) => $item['quantity'] * $item['price'],
            $items
        ));

        return max(0, $subtotal);
    }

    /**
     * Subtotal from line items, then coupon from coupons.type / coupons.discount:
     * type "fixed" → subtract round(discount); otherwise percent → subtract round(subtotal × discount / 100).
     * Final amount = max(0, subtotal − deduction).
     *
     * @param  array<int, array{product_attribute_id: int, quantity: int, price: int}>  $items
     */
    private function computeOrderAmount(array $items, ?int $couponId): int
    {
        $subtotal = $this->computeOrderSubtotal($items);

        return $this->applyCouponDiscount($subtotal, $couponId);
    }

    private function applyCouponDiscount(int $subtotal, ?int $couponId): int
    {
        if (! $couponId) {
            return $subtotal;
        }

        $coupon = Coupon::query()->find($couponId);

        if (! $coupon) {
            return $subtotal;
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
