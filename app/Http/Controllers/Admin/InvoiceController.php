<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Invoice;
use App\Models\Order;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view invoices', ['only' => ['index', 'show']]);
        $this->middleware('permission:add invoices', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit invoices', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete invoices', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('invoices');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Invoice::query()->count(),
            'trashed' => Invoice::query()->onlyTrashed()->count(),
        ];

        $query = Invoice::with('order.customer');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('invoice_no', 'like', '%'.$search.'%')
                    ->orWhere('order_id', 'like', '%'.$search.'%')
                    ->orWhereHas('order.customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('email', 'like', '%'.$search.'%')
                            ->orWhere('first_name', 'like', '%'.$search.'%')
                            ->orWhere('last_name', 'like', '%'.$search.'%');
                    });
            });
        }

        $invoices = $query->latest('id')->get();

        return view('invoices.index', compact('invoices', 'counts', 'filters'));
    }

    public function create()
    {
        return view('invoices.create', $this->invoiceFormLookups());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_no' => ['required', 'integer'],
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
        ]);

        $invoice = Invoice::create($data);

        return redirect()->route('admin.invoices.show', $invoice)->with('status', 'Invoice created.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load([
            'order.items',
            'order.customer',
            'order.address',
        ]);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', array_merge(
            compact('invoice'),
            $this->invoiceFormLookups()
        ));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'invoice_no' => ['required', 'integer'],
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
        ]);

        $invoice->update($data);

        return redirect()->route('admin.invoices.show', $invoice)->with('status', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('status', 'Invoice deleted.');
    }

    public function restore(Request $request, int $id)
    {
        $invoice = $this->findOnlyTrashed(Invoice::class, $id);
        $invoice->restore();

        return $this->trashedActionResponse($request, 'admin.invoices.index', 'Invoice restored.');
    }

    public function forceDelete(Request $request, int $id)
    {
        $invoice = $this->findOnlyTrashed(Invoice::class, $id);
        $invoice->forceDelete();

        return $this->trashedActionResponse($request, 'admin.invoices.index', 'Invoice permanently deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function invoiceFormLookups(): array
    {
        return [
            'orders' => Order::with('customer')->latest('id')->get(),
        ];
    }
}
