@php
    $invoiceModel = $invoice ?? null;
    $invoiceNo = old('invoice_no', $invoiceModel?->invoice_no ?? '');
    $orderId = old('order_id', $invoiceModel?->order_id);
@endphp
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="invoice-no">Invoice number:</label>
<input class="form-control" id="invoice-no" name="invoice_no" type="number" value="{{ $invoiceNo }}" required/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="order-id">Order:</label>
<select class="form-select" id="order-id" name="order_id">
<option value="">No linked order</option>
@foreach ($orders as $order)
@php
    $cust = $order->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
@endphp
<option value="{{ $order->id }}" @selected((string) $orderId === (string) $order->id)>#{{ $order->id }} — {{ $custLabel }} (${{ number_format($order->amount ?? 0) }})</option>
@endforeach
</select>
</div>
