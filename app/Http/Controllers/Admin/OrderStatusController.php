<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\OrderStatus;
use App\Support\AdminFormResponse;
use App\Support\AdminResourceCounts;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
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
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => OrderStatus::query()->count(),
            'trashed' => OrderStatus::query()->onlyTrashed()->count(),
        ];

        $query = OrderStatus::withCount('orders');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        $orderStatuses = $query->orderBy('title')->get();

        return view('admin.order-statuses.index', compact('orderStatuses', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.order-statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
        ]);

        $orderStatus = OrderStatus::create($data);

        return AdminFormResponse::saved(
            $request,
            'Order status created.',
            fn () => redirect()->route('admin.order-statuses.index')
        );
    }

    public function show(OrderStatus $orderStatus)
    {
        $orderStatus->load('orders.customer');

        return view('admin.order-statuses.show', compact('orderStatus'));
    }

    public function edit(OrderStatus $orderStatus)
    {
        return view('admin.order-statuses.edit', compact('orderStatus'));
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
        ]);

        $orderStatus->update($data);

        return AdminFormResponse::saved(
            $request,
            'Order status updated.',
            fn () => redirect()->route('admin.order-statuses.index')
        );
    }

    public function destroy(Request $request, OrderStatus $orderStatus)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $orderStatus,
            'Cannot delete this order status because orders use it.'
        )) {
            return $blocked;
        }

        $orderStatus->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.order-statuses.index',
            'Order status deleted.',
            AdminResourceCounts::orderStatuses()
        );
    }

    public function restore(Request $request, int $id)
    {
        $orderStatus = $this->findOnlyTrashed(OrderStatus::class, $id);
        $orderStatus->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.order-statuses.index',
            'Order status restored.',
            AdminResourceCounts::orderStatuses()
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $orderStatus = $this->findOnlyTrashed(OrderStatus::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $orderStatus,
            'Cannot permanently delete this order status because orders use it.'
        )) {
            return $blocked;
        }

        $orderStatus->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.order-statuses.index',
            'Order status permanently deleted.',
            AdminResourceCounts::orderStatuses()
        );
    }
}
