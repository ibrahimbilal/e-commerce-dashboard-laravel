<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view invoices', ['only' => ['index', 'show']]);
        $this->middleware('permission:add invoices', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit invoices', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete invoices', ['only' => ['destroy']]);
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
            $query->where('invoice_no', 'like', '%'.$search.'%');
        }

        $invoices = $query->latest('id')->paginate(20)->withQueryString();

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

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice created.');
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

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('status', 'Invoice deleted.');
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
