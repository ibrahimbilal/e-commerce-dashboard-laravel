@php
    $attribute = $attribute ?? null;
    $terms = $terms ?? null;
    $termRows = old('terms');
    if ($termRows === null) {
        $termsCollection = $terms ?? collect($attribute ? [$attribute] : []);
        $termRows = $termsCollection->map(function ($term) use ($attribute) {
            return [
                'id' => $term->id ?? null,
                'title' => $term->term_title ?? $term->attribute_value ?? $attribute?->attribute_value ?? '',
                'type' => $term->term_type ?? 'text',
                'value' => $term->attribute_value ?? '',
            ];
        })->values()->all();
    }
    if (! is_array($termRows) || count($termRows) === 0) {
        $termRows = [[]];
    }
    $termRows = array_values($termRows);
@endphp
<div class="alerts warning @if (count($termRows) > 0) d-none @endif" data-repeater-empty-alert>
<ul class="list">
<li class="content">You Haven't Create Any Terms Yet.</li>
</ul>
</div>
<div class="repeater-holder" data-repeater-template="attribute-term-row-template" data-repeater-min="1" data-error-for="terms">
@foreach ($termRows as $index => $row)
@include('components.admin.attribute-term-repeater-row', ['index' => $index, 'row' => $row])
@endforeach
</div>
<div class="add-repeater-item mt-3"><a class="btn">Add New Attribute Term</a></div>
<template id="attribute-term-row-template">
@include('components.admin.attribute-term-repeater-row', ['index' => '__INDEX__', 'row' => []])
</template>
