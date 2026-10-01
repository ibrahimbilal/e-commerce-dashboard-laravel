<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
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
        $orderStatuses = OrderStatus::withCount('orders')->orderBy('title')->paginate(20);

        return view('order-statuses.index', compact('orderStatuses'));
    }

    public function create()
    {
        return view('order-statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
        ]);

        $orderStatus = OrderStatus::create($data);

        return redirect()->route('order-statuses.index')->with('status', 'Order status created.');
    }

    public function show(OrderStatus $orderStatus)
    {
        $orderStatus->load('orders.customer');

        return view('order-statuses.show', compact('orderStatus'));
    }

    public function edit(OrderStatus $orderStatus)
    {
        return view('order-statuses.edit', compact('orderStatus'));
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
        ]);

        $orderStatus->update($data);

        return redirect()->route('order-statuses.index')->with('status', 'Order status updated.');
    }

    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return redirect()->route('order-statuses.index')->with('status', 'Order status deleted.');
    }
}
