@php
    $addressModel = $address ?? null;
    $customerId = old('customer_id', $addressModel?->customer_id);
@endphp
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="customer-id">Customer:</label>
<select class="form-select" id="customer-id" name="customer_id" required>
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
<label class="item-title" for="address-title">Title:</label>
<input class="form-control" id="address-title" name="address_title" type="text" value="{{ old('address_title', $addressModel?->address_title ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="mobile">Mobile:</label>
<input class="form-control" id="mobile" name="mobile" type="text" value="{{ old('mobile', $addressModel?->mobile ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="country">Country:</label>
<input class="form-control" id="country" name="country" type="text" value="{{ old('country', $addressModel?->country ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="state">State:</label>
<input class="form-control" id="state" name="state" type="text" value="{{ old('state', $addressModel?->state ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="city">City:</label>
<input class="form-control" id="city" name="city" type="text" value="{{ old('city', $addressModel?->city ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-1">Address 1:</label>
<input class="form-control" id="address-1" name="address_1" type="text" value="{{ old('address_1', $addressModel?->address_1 ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-2">Address 2:</label>
<input class="form-control" id="address-2" name="address_2" type="text" value="{{ old('address_2', $addressModel?->address_2 ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="postcode">Postcode:</label>
<input class="form-control" id="postcode" name="postcode" type="text" value="{{ old('postcode', $addressModel?->postcode ?? '') }}"/>
</div>
