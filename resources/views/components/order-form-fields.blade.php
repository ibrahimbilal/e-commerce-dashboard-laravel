@php
    $orderModel = $order ?? null;
    $customerId = old('customer_id', old('customer', $orderModel?->customer_id));
    $addressId = old('address_id', $orderModel?->address_id);
    $statusId = old('order_status_id', old('order_status', $orderModel?->order_status_id));
    $couponId = old('coupon_id', old('coupon', $orderModel?->coupon_id));
    $amount = old('amount', $orderModel?->amount ?? '');
@endphp
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="customer">Customer:</label>
<select class="form-select" id="customer" name="customer_id" required>
<option value="">Select customer</option>
@foreach ($customers as $customer)
@php
    $label = trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')) ?: ($customer->email ?? 'Customer #'.$customer->id);
@endphp
<option value="{{ $customer->id }}" @selected((string) $customerId === (string) $customer->id)>{{ $label }}</option>
@endforeach
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-id">Shipping address:</label>
<select class="form-select" id="address-id" name="address_id" required>
<option value="">Select address</option>
@foreach ($addresses as $address)
@php
    $addrLabel = collect([
        $address->address_title,
        $address->address_1,
        $address->city,
        $address->country,
    ])->filter()->implode(', ');
    $cust = $address->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '';
@endphp
<option value="{{ $address->id }}" @selected((string) $addressId === (string) $address->id)>{{ $custLabel ? $custLabel.' — ' : '' }}{{ $addrLabel ?: 'Address #'.$address->id }}</option>
@endforeach
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="order-status">Order status:</label>
<select class="form-select" id="order-status" name="order_status_id" required>
<option value="">Select status</option>
@foreach ($orderStatuses as $status)
<option value="{{ $status->id }}" @selected((string) $statusId === (string) $status->id)>{{ $status->title }}</option>
@endforeach
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="coupon">Coupon:</label>
<select class="form-select" id="coupon" name="coupon_id">
<option value="">No coupon</option>
@foreach ($coupons as $coupon)
<option value="{{ $coupon->id }}" @selected((string) $couponId === (string) $coupon->id)>{{ $coupon->title }}@if($coupon->code) ({{ $coupon->code }})@endif</option>
@endforeach
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="amount">Order amount:</label>
<input class="form-control" id="amount" name="amount" type="number" min="0" step="1" value="{{ $amount }}" required/>
</div>
