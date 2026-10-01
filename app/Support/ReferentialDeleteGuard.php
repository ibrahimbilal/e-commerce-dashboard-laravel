<?php

namespace App\Support;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ReferentialDeleteGuard
{
    public static function blockIfInUse(Request $request, Model $model, string $message): ?Response
    {
        if (! self::isReferenced($model)) {
            return null;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'errors' => ['delete' => [$message]],
            ], 422);
        }

        return redirect()
            ->back(302, [], url()->previous() ?: '/')
            ->with('status', $message);
    }

    public static function isReferenced(Model $model): bool
    {
        return match ($model::class) {
            Attribute::class => ProductAttribute::query()
                ->where(function ($query) use ($model) {
                    $query->where('attribute_1_id', $model->id)
                        ->orWhere('attribute_2_id', $model->id);
                })
                ->whereHas('orderItems')
                ->exists(),
            Product::class => OrderItem::query()
                ->whereHas('productAttribute', fn ($query) => $query->where('product_id', $model->id))
                ->exists(),
            Customer::class => Order::query()->where('customer_id', $model->id)->exists(),
            OrderStatus::class => Order::query()->where('order_status_id', $model->id)->exists(),
            Category::class => $model->products()->exists(),
            default => false,
        };
    }
}
