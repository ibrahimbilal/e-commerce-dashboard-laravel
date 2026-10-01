<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }

    public function __invoke()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'customers' => Customer::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
