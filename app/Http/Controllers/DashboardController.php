<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }

    public function __invoke()
    {
        $stats = [
            'orders' => Order::query()->count(),
            'revenue' => (int) Order::query()->sum('amount'),
            'customers' => Customer::query()->count(),
            'products' => Product::query()->count(),
            'orders_today' => Order::query()->whereDate('created_at', today())->count(),
        ];

        $recentOrders = Order::query()
            ->with(['customer', 'orderStatus'])
            ->latest('id')
            ->limit(10)
            ->get();

        $topProducts = OrderItem::query()
            ->select([
                'products_attributes.product_id',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
            ])
            ->join('products_attributes', 'products_attributes.id', '=', 'order_items.product_attribute_id')
            ->join('products', 'products.id', '=', 'products_attributes.product_id')
            ->groupBy('products_attributes.product_id')
            ->orderByDesc('quantity_sold')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $product = Product::query()
                    ->with(['locales' => fn ($q) => $q->where('locale', 'en')])
                    ->find($row->product_id);

                return [
                    'product_id' => (int) $row->product_id,
                    'name' => $product?->locales->first()?->name ?? ('Product #'.$row->product_id),
                    'quantity_sold' => (int) $row->quantity_sold,
                ];
            });

        return view('dashboard.index', compact('stats', 'recentOrders', 'topProducts'));
    }
}
