@extends('admin.layout')

@section('title', 'E-Commerce Project')

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

@php
    $order = $invoice->order;
    $order?->loadMissing([
        'items.productAttribute.attributeOne',
        'items.productAttribute.attributeTwo',
        'items.productAttribute.product.locales',
        'customer',
        'address',
    ]);
    $customer = $order?->customer;
    $custName = $customer ? trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')) : '—';
    $address = $order?->address;
    $items = $order?->items ?? collect();
    $subtotal = $items->sum(fn ($item) => (int) ($item->price ?? 0) * (int) ($item->quantity ?? 0));
    $invoiceTotal = $order?->amount ?? $subtotal;
    $variantLineLabel = function ($item) {
        $pa = $item->productAttribute;
        if (! $pa) {
            return 'Line item #'.$item->id;
        }
        $productName = $pa->product?->locales?->first()?->name ?? ('Product #'.($pa->product_id ?? '?'));
        $one = $pa->attributeOne?->attribute_value ?? '?';
        $two = $pa->attributeTwo?->attribute_value ?? '?';

        return $productName.' ('.$one.' / '.$two.')';
    };
@endphp
<div class="page-title text-capitalize">invoice #{{ $invoice->invoice_no }}</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.invoices.index') }}">invoices</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-9 float-start post-box mb-3 mb-lg-0">
<div class="invoice">
<div class="invoice-header box-spaces mb-0">
<h1 class="page-title text-capitalize mb-0 py-2">invoice</h1>
</div>
<div class="invoice-body box-spaces mb-0">
<div class="row">
<div class="col-sm-4 col-lg-3 order-sm-2 d-flex justify-content-center align-items-center">
<div class="logo-holder text-center"><img class="invoice-logo" src="{{ asset('assets/images/logo.png') }}"/>
<p class="name mb-0 mt-2">Company Name</p>
</div>
</div>
<div class="col-sm-8 col-lg-9 order-sm-1">
<div class="table-holder text-start">
<p class="title title-1 mb-2">Bill From:</p>
<table class="border-0">
<tbody>
<tr>
<td>
<p class="title title-2 mb-0">Company:</p>
</td>
<td>Company Name</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Address:</p>
</td>
<td>1881  Rosewood Lane</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">City:</p>
</td>
<td>New York City</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Country:</p>
</td>
<td>{{ $address?->country ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Email Address:</p>
</td>
<td>company@email.com</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<hr/>
<div class="row">
<div class="col-sm-8 col-lg-9">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table w-100">
<thead class="table-light">
<th></th>
<th>Billing to:</th>
<th>Shipping to:</th>
</thead>
<tbody>
<tr>
<td>
<p class="title title-2 mb-0">Customer:</p>
</td>
<td>{{ $custName }}</td>
<td>{{ $custName }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Address:</p>
</td>
<td>{{ $address->address_1 ?? '—' }}</td>
<td>{{ $address->address_1 ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">City:</p>
</td>
<td>{{ $address->city ?? '—' }}</td>
<td>{{ $address->city ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Country:</p>
</td>
<td>{{ $address->country ?? '—' }}</td>
<td>{{ $address->country ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Postal:</p>
</td>
<td>{{ $address->postcode ?? '—' }}</td>
<td>{{ $address->postcode ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Mobile:</p>
</td>
<td>{{ $address->mobile ?? ($customer->mobile ?? '—') }}</td>
<td>{{ $address->mobile ?? ($customer->mobile ?? '—') }}</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="col-sm-4 col-lg-3">
<div class="invoice-detail text-sm-end">
<p class="title title-2">Invoice No</p>
<p class="title-2">{{ $invoice->invoice_no }}</p>
<p class="title title-2">Date</p>
<p class="title-2">{{ $invoice->created_at?->format('d/m/Y') ?? '—' }}</p>
<p class="title title-2">Amount</p>
<p class="title-2">${{ number_format($invoiceTotal) }}</p>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table w-100">
<thead class="table-light">
<th>Item</th>
<th class="text-center">Quantity</th>
<th class="text-center">Unit Cost</th>
<th class="text-end">Total Cost</th>
</thead>
<tbody>
@forelse ($items as $item)
@php
    $lineTotal = (int) ($item->price ?? 0) * (int) ($item->quantity ?? 0);
@endphp
<tr>
<td>{{ $variantLineLabel($item) }}</td>
<td class="text-center">{{ $item->quantity ?? '—' }}</td>
<td class="text-center">${{ number_format($item->price ?? 0) }}</td>
<td class="text-end">${{ number_format($lineTotal) }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted">No line items on this invoice's order.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="invoice-body box-spaces mb-0 pt-0 pb-5">
<div class="row">
<div class="col-sm-4 col-lg-3 order-sm-2 mb-3 mb-md-0">
<div class="total-holder">
<div class="item form-item second d-flex justify-content-between">
<div class="item-title meta-title">subtotal:</div><span class="ms-2">${{ number_format($subtotal) }}</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title meta-title">shipping:</div><span class="ms-2 text-muted">—</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title meta-title">Tax:</div><span class="ms-2 text-muted">—</span>
</div>
<div class="item form-item second d-flex justify-content-between total">
<div class="item-title meta-title">Total:</div><span class="ms-2">${{ number_format($invoiceTotal) }}</span>
</div>
</div>
</div>
<div class="col-sm-8 col-lg-9 order-sm-1">
<div class="note">
<p class="title title-1 mb-1">Notes:</p>
<p class="text-muted mb-0">{{ $invoice->order ? 'Invoice for order #'.$invoice->order_id : 'Invoice details' }}</p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box ms-auto">
<div class="main-box box-spaces">
<div class="btns-holder">
<button class="btn solid-btn w-100 mb-2" data-invoice="{{ $invoice->invoice_no }}" id="download">Download (.Pdf)</button>
<button class="btn regular-btn w-100 mb-2" id="send-mail">send as email</button>
<button class="btn regular-btn w-100 mb-2" id="print">print</button>
<button class="btn trans-btn w-100" id="trash"><span class="icon me-1"><i class="fi-rr-trash"> </i>move to trash</span></button>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/html2pdf.min.js') }}" type="text/javascript"></script>
@endpush

