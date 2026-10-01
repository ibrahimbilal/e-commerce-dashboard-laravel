<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsReport
{
    /**
     * @return array{from: string, to: string, compare: string}
     */
    public static function resolveRange(?string $from, ?string $to, ?string $compare): array
    {
        $toDate = $to ? Carbon::parse($to)->endOfDay() : now()->endOfDay();
        $fromDate = $from ? Carbon::parse($from)->startOfDay() : now()->subDays(29)->startOfDay();

        if ($fromDate->greaterThan($toDate)) {
            [$fromDate, $toDate] = [$toDate->copy()->startOfDay(), $fromDate->copy()->endOfDay()];
        }

        $compareMode = in_array($compare, ['previous_period', 'previous_year', 'none'], true)
            ? $compare
            : 'previous_period';

        return [
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'compare' => $compareMode,
        ];
    }

    /**
     * @param  array{from: string, to: string, compare: string}  $range
     * @return array<string, mixed>
     */
    public static function analytics(array $range): array
    {
        $from = Carbon::parse($range['from'])->startOfDay();
        $to = Carbon::parse($range['to'])->endOfDay();

        $current = self::totalsBetween($from, $to);
        $comparison = self::comparisonTotals($from, $to, $range['compare']);

        return [
            'sales' => $current['sales'],
            'orders' => $current['orders'],
            'items_sold' => $current['items_sold'],
            'tax' => null,
            'comparison' => $comparison,
        ];
    }

    /**
     * @param  array{from: string, to: string, compare: string}  $range
     * @return array{labels: array<int, string>, sales: array<int, int>, orders: array<int, int>, items_sold: array<int, int>, tax: array<int, null>}
     */
    public static function dailySeries(array $range): array
    {
        $from = Carbon::parse($range['from'])->startOfDay();
        $to = Carbon::parse($range['to'])->endOfDay();

        $labels = [];
        $sales = [];
        $orders = [];
        $itemsSold = [];
        $tax = [];

        for ($day = $from->copy(); $day->lte($to); $day->addDay()) {
            $labels[] = $day->format('Y-m-d');
            $sales[] = (int) Order::query()->whereDate('created_at', $day)->sum('amount');
            $orders[] = Order::query()->whereDate('created_at', $day)->count();
            $itemsSold[] = (int) OrderItem::query()
                ->whereHas('order', fn ($query) => $query->whereDate('created_at', $day))
                ->sum('quantity');
            $tax[] = null;
        }

        return [
            'labels' => $labels,
            'sales' => $sales,
            'orders' => $orders,
            'items_sold' => $itemsSold,
            'tax' => $tax,
        ];
    }

    /**
     * @param  array{from: string, to: string, compare: string}  $range
     * @return array<int, array{name: string, quantity_sold: int, revenue: int}>
     */
    public static function topProducts(array $range, int $limit = 10): array
    {
        $from = Carbon::parse($range['from'])->startOfDay();
        $to = Carbon::parse($range['to'])->endOfDay();

        return self::topProductRows($from, $to, $limit);
    }

    /**
     * @param  array{from: string, to: string, compare: string}  $range
     * @return array<int, array{name: string, quantity_sold: int, revenue: int}>
     */
    public static function topCategories(array $range, int $limit = 10): array
    {
        $from = Carbon::parse($range['from'])->startOfDay();
        $to = Carbon::parse($range['to'])->endOfDay();

        $rows = OrderItem::query()
            ->select([
                'products_cats.cat_id as category_id',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
            ])
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products_attributes', 'products_attributes.id', '=', 'order_items.product_attribute_id')
            ->join('products_cats', 'products_cats.product_id', '=', 'products_attributes.product_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->groupBy('products_cats.cat_id')
            ->orderByDesc('quantity_sold')
            ->limit($limit)
            ->get();

        $categories = Category::query()->whereIn('id', $rows->pluck('category_id'))->get()->keyBy('id');

        return $rows->map(function ($row) use ($categories) {
            $category = $categories->get($row->category_id);

            return [
                'name' => $category?->title ?? ('Category #'.$row->category_id),
                'quantity_sold' => (int) $row->quantity_sold,
                'revenue' => (int) $row->revenue,
            ];
        })->values()->all();
    }

    /**
     * @return array{sales: int, orders: int, items_sold: int}
     */
    private static function totalsBetween(Carbon $from, Carbon $to): array
    {
        return [
            'sales' => (int) Order::query()->whereBetween('created_at', [$from, $to])->sum('amount'),
            'orders' => Order::query()->whereBetween('created_at', [$from, $to])->count(),
            'items_sold' => (int) OrderItem::query()
                ->whereHas('order', fn ($query) => $query->whereBetween('created_at', [$from, $to]))
                ->sum('quantity'),
        ];
    }

    /**
     * @return array{sales: int|null, orders: int|null, items_sold: int|null, tax: null}|null
     */
    private static function comparisonTotals(Carbon $from, Carbon $to, string $compare): ?array
    {
        if ($compare === 'none') {
            return null;
        }

        $days = $from->diffInDays($to) + 1;

        if ($compare === 'previous_year') {
            $compareFrom = $from->copy()->subYear();
            $compareTo = $to->copy()->subYear();
        } else {
            $compareTo = $from->copy()->subDay()->endOfDay();
            $compareFrom = $compareTo->copy()->subDays($days - 1)->startOfDay();
        }

        $totals = self::totalsBetween($compareFrom, $compareTo);

        return [
            'sales' => $totals['sales'],
            'orders' => $totals['orders'],
            'items_sold' => $totals['items_sold'],
            'tax' => null,
        ];
    }

    /**
     * @return array<int, array{name: string, quantity_sold: int, revenue: int}>
     */
    private static function topProductRows(Carbon $from, Carbon $to, int $limit): array
    {
        $rows = OrderItem::query()
            ->select([
                'products_attributes.product_id',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
            ])
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products_attributes', 'products_attributes.id', '=', 'order_items.product_attribute_id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->groupBy('products_attributes.product_id')
            ->orderByDesc('quantity_sold')
            ->limit($limit)
            ->get();

        $products = Product::query()
            ->whereIn('id', $rows->pluck('product_id'))
            ->with(['locales' => fn ($q) => $q->where('locale', 'en')])
            ->get()
            ->keyBy('id');

        return $rows->map(function ($row) use ($products) {
            $product = $products->get($row->product_id);

            return [
                'name' => $product?->locales->first()?->name ?? ('Product #'.$row->product_id),
                'quantity_sold' => (int) $row->quantity_sold,
                'revenue' => (int) $row->revenue,
            ];
        })->values()->all();
    }
}
