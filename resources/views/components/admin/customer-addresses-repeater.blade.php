@php
    $customer = $customer ?? null;
    $addressRows = old('addresses');
    if ($addressRows === null) {
        if ($customer) {
            $addressRows = ($customer->addresses ?? collect())->map(function ($address) {
                return [
                    'id' => $address->id,
                    'address_title' => $address->address_title,
                    'mobile' => $address->mobile,
                    'country' => $address->country,
                    'state' => $address->state,
                    'city' => $address->city,
                    'address_1' => $address->address_1,
                    'address_2' => $address->address_2,
                    'postcode' => $address->postcode,
                ];
            })->values()->all();
        } else {
            $addressRows = [[]];
        }
    }
    if (! is_array($addressRows)) {
        $addressRows = [];
    }
    $addressRows = array_values($addressRows);
    if (! $customer && count($addressRows) === 0) {
        $addressRows = [[]];
    }
@endphp
<input type="hidden" name="addresses_sync" value="1"/>
<div class="repeater-holder" data-repeater-template="customer-address-row-template" data-repeater-min="0" data-error-for="addresses">
@foreach ($addressRows as $index => $row)
@include('components.admin.customer-address-repeater-row', ['index' => $index, 'row' => $row])
@endforeach
</div>
<div class="add-repeater-item"><a class="btn">Add New Address</a></div>
<template id="customer-address-row-template">
@include('components.admin.customer-address-repeater-row', ['index' => '__INDEX__', 'row' => []])
</template>
