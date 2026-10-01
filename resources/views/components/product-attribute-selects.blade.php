@php
    $grouped = $attributes->groupBy('attribute_key');
@endphp
<div class="select2-wrapper">
@forelse ($grouped as $key => $items)
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap @if(!$loop->first) mt-3 @endif">
<label class="item-title" for="attr-{{ \Illuminate\Support\Str::slug($key) }}">{{ $key }}:<span class="icon info ms-2" flow="up" tooltip="Attributes are not saved on product yet (display only)."><i class="fi-rr-info"> </i></span></label>
<select class="form-select multi-select" id="attr-{{ \Illuminate\Support\Str::slug($key) }}" multiple="multiple" disabled="disabled" title="Not persisted by ProductController">
@foreach ($items as $attribute)
<option value="{{ $attribute->id }}">{{ $attribute->attribute_value }}</option>
@endforeach
</select>
</div>
@empty
<p class="text-muted mb-0">No attributes defined.</p>
@endforelse
</div>
