@php
    $index = $index ?? 0;
    $row = is_array($row ?? []) ? $row : [];
    $namePrefix = 'addresses['.$index.']';
    $idToken = (string) $index;
    $oldPrefix = is_numeric($index) ? 'addresses.'.$index : null;
    $field = function (string $key, $default = '') use ($row, $oldPrefix) {
        if ($oldPrefix !== null) {
            return old($oldPrefix.'.'.$key, $row[$key] ?? $default);
        }

        return $row[$key] ?? $default;
    };
@endphp
<div class="repeater mb-3" data-repeater-row>
<div class="repeater-title p-3 mb-3 d-flex justify-content-between align-items-center">
<h3 class="h5 mb-0" data-repeater-title-display>{{ $field('address_title') ?: 'Address Title' }}</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span><span class="remove" flow="up" tooltip="Remove"><i class="fi-rr-trash"> </i></span></div>
</div>
<div class="repeater-inputs px-3 active">
@if (! empty($row['id']))
<input type="hidden" name="{{ $namePrefix }}[id]" value="{{ $row['id'] }}"/>
@endif
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="address-title-{{ $idToken }}">title:</label>
<input class="form-control" id="address-title-{{ $idToken }}" name="{{ $namePrefix }}[address_title]" type="text" maxlength="100" value="{{ $field('address_title') }}" data-repeater-title-input data-repeater-title-fallback="Address Title"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-mobile-{{ $idToken }}">mobile:</label>
<input class="form-control" id="address-mobile-{{ $idToken }}" name="{{ $namePrefix }}[mobile]" type="tel" maxlength="50" value="{{ $field('mobile') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="country-{{ $idToken }}">Country:</label>
<select class="form-select" id="country-{{ $idToken }}" name="{{ $namePrefix }}[country]">
@include('components.admin.country-select-options', ['selected' => $field('country')])
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="state-{{ $idToken }}">State:</label>
<input class="form-control" id="state-{{ $idToken }}" name="{{ $namePrefix }}[state]" type="text" maxlength="100" value="{{ $field('state') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="city-{{ $idToken }}">City:</label>
<input class="form-control" id="city-{{ $idToken }}" name="{{ $namePrefix }}[city]" type="text" maxlength="100" value="{{ $field('city') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-1-{{ $idToken }}">Address 1:</label>
<input autocomplete="on" class="form-control" id="address-1-{{ $idToken }}" name="{{ $namePrefix }}[address_1]" placeholder="Street name and house number" type="text" maxlength="100" value="{{ $field('address_1') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-2-{{ $idToken }}">Address 2:</label>
<input autocomplete="on" class="form-control" id="address-2-{{ $idToken }}" name="{{ $namePrefix }}[address_2]" placeholder="Apartment, suite, unit, etc. (optional)" type="text" maxlength="100" value="{{ $field('address_2') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="postal-{{ $idToken }}">Postal Code:</label>
<input class="form-control" id="postal-{{ $idToken }}" name="{{ $namePrefix }}[postcode]" type="text" maxlength="5" value="{{ $field('postcode') }}"/>
</div>
</div>
</div>
