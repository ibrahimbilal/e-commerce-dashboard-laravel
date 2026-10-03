<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Support\DashboardMetrics;
use App\Support\ProductImage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }

    public function __invoke()
    {
        $stats = DashboardMetrics::stats();

        $recentOrders = Order::query()
            ->with(['customer', 'orderStatus'])
            ->latest('id')
            ->limit(10)
            ->get();

        $topProductRows = OrderItem::query()
            ->select([
                'products_attributes.product_id',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
            ])
            ->join('products_attributes', 'products_attributes.id', '=', 'order_items.product_attribute_id')
            ->join('products', 'products.id', '=', 'products_attributes.product_id')
            ->groupBy('products_attributes.product_id')
            ->orderByDesc('quantity_sold')
            ->limit(5)
            ->get();

        $topProductModels = Product::query()
            ->whereIn('id', $topProductRows->pluck('product_id'))
            ->with(['locales' => fn ($q) => $q->where('locale', 'en')])
            ->get()
            ->keyBy('id');

        $topProducts = $topProductRows->map(function ($row) use ($topProductModels) {
            $product = $topProductModels->get($row->product_id);

            return [
                'product_id' => (int) $row->product_id,
                'name' => $product?->locales->first()?->name ?? ('Product #'.$row->product_id),
                'quantity_sold' => (int) $row->quantity_sold,
                'image_url' => ProductImage::url($product?->product_img),
                'price' => (int) ($product?->sale_price ?? $product?->regular_price ?? 0),
                'regular_price' => (int) ($product?->regular_price ?? 0),
            ];
        });

        $recentProducts = Product::query()
            ->where('status', 'published')
            ->with(['locales' => fn ($q) => $q->where('locale', 'en')])
            ->latest('id')
            ->limit(10)
            ->get()
            ->map(fn (Product $product) => [
                'id' => (int) $product->id,
                'name' => $product->locales->first()?->name ?? ('Product #'.$product->id),
                'image_url' => ProductImage::url($product->product_img),
                'price' => (int) ($product->sale_price ?? $product->regular_price ?? 0),
                'regular_price' => (int) ($product->regular_price ?? 0),
            ]);

        $salesChartSeries = DashboardMetrics::salesChartSeries();
        $orderStatusStats = DashboardMetrics::orderStatusStats();

        return view('dashboard.index', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'recentProducts',
            'salesChartSeries',
            'orderStatusStats',
        ));
    }
}
