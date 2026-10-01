<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('order.customer')->latest('id')->paginate(20);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
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
        $invoice->load('order.customer', 'order.items');

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
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
}
