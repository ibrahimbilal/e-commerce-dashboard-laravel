<?php

namespace App\Support;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Subscriber;
use Illuminate\Support\Str;

class DashboardMetrics
{
    /**
     * @return array<string, int|float|null>
     */
    public static function stats(): array
    {
        $revenue = (int) Order::query()->sum('amount');

        $currentStart = now()->subDays(30)->startOfDay();
        $previousStart = now()->subDays(60)->startOfDay();
        $previousEnd = now()->subDays(30)->startOfDay();

        $customersCurrent = Customer::query()->where('created_at', '>=', $currentStart)->count();
        $customersPrevious = Customer::query()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        $ordersCurrent = Order::query()->where('created_at', '>=', $currentStart)->count();
        $ordersPrevious = Order::query()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        $salesCurrent = (int) Order::query()->where('created_at', '>=', $currentStart)->sum('amount');
        $salesPrevious = (int) Order::query()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('amount');

        $subscribersCurrent = Subscriber::query()
            ->where('is_subscriber', true)
            ->where('created_at', '>=', $currentStart)
            ->count();
        $subscribersPrevious = Subscriber::query()
            ->where('is_subscriber', true)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        return [
            'orders' => Order::query()->count(),
            'revenue' => $revenue,
            'sales' => $revenue,
            'customers' => Customer::query()->count(),
            'products' => \App\Models\Product::query()->count(),
            'orders_today' => Order::query()->whereDate('created_at', today())->count(),
            'subscribers' => Subscriber::query()->where('is_subscriber', true)->count(),
            'customers_change' => self::percentChange($customersCurrent, $customersPrevious),
            'orders_change' => self::percentChange($ordersCurrent, $ordersPrevious),
            'sales_change' => self::percentChange($salesCurrent, $salesPrevious),
            'subscribers_change' => self::percentChange($subscribersCurrent, $subscribersPrevious),
        ];
    }

    /**
     * @return array{labels: array<int, string>, sales: array<int, int>, orders: array<int, int>}
     */
    public static function salesChartSeries(): array
    {
        $labels = [];
        $sales = [];
        $orders = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->startOfMonth()->subMonths($i);
            $labels[] = $month->format('M Y');
            $sales[] = (int) Order::query()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $orders[] = Order::query()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return compact('labels', 'sales', 'orders');
    }

    /**
     * @return array<int, array{slug: string, title: string, count: int, percent: float}>
     */
    public static function orderStatusStats(): array
    {
        $totalOrders = Order::query()->count();
        $statuses = OrderStatus::query()->orderBy('title')->get();

        return $statuses->map(function (OrderStatus $status) use ($totalOrders) {
            $count = Order::query()->where('order_status_id', $status->id)->count();
            $percent = $totalOrders > 0 ? round(($count / $totalOrders) * 100, 1) : 0.0;

            return [
                'slug' => Str::slug($status->title),
                'title' => $status->title,
                'count' => $count,
                'percent' => $percent,
            ];
        })->values()->all();
    }

    public static function percentChange(float|int $current, float|int $previous): ?float
    {
        if ((float) $previous === 0.0) {
            return null;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
