@php
    $variantRows = old('product_attributes');
    if ($variantRows === null) {
        $variantRows = isset($product)
            ? $product->productAttributes->map(fn ($row) => [
                'id' => $row->id,
                'attribute_1_id' => $row->attribute_1_id,
                'attribute_2_id' => $row->attribute_2_id,
            ])->values()->all()
            : [];
    }
    if ($variantRows === [] || $variantRows === null) {
        $variantRows = [['id' => null, 'attribute_1_id' => null, 'attribute_2_id' => null]];
    }
    $attributeOptions = $attributes ?? collect();
@endphp
<div class="product-variant-rows" id="product-variant-rows">
<div class="table-responsive">
<table class="table table-bordered mb-2">
<thead>
<tr>
<th class="text-capitalize">Attribute 1</th>
<th class="text-capitalize">Attribute 2</th>
<th class="text-end" style="width: 90px;"> </th>
</tr>
</thead>
<tbody id="product-variant-rows-body">
@foreach ($variantRows as $index => $row)
@php
    $rowId = is_array($row) ? ($row['id'] ?? null) : null;
    $attr1 = is_array($row) ? ($row['attribute_1_id'] ?? '') : '';
    $attr2 = is_array($row) ? ($row['attribute_2_id'] ?? '') : '';
    $idx = is_numeric($index) ? (int) $index : $loop->index;
@endphp
<tr class="product-variant-row" data-row-index="{{ $idx }}">
<td>
@if ($rowId)
<input type="hidden" name="product_attributes[{{ $idx }}][id]" value="{{ $rowId }}"/>
@endif
<select class="form-select" name="product_attributes[{{ $idx }}][attribute_1_id]" required>
<option value="">Select attribute</option>
@foreach ($attributeOptions as $attribute)
<option value="{{ $attribute->id }}" @selected((string) $attr1 === (string) $attribute->id)>{{ $attribute->attribute_key }}: {{ $attribute->attribute_value }}</option>
@endforeach
</select>
</td>
<td>
<select class="form-select" name="product_attributes[{{ $idx }}][attribute_2_id]" required>
<option value="">Select attribute</option>
@foreach ($attributeOptions as $attribute)
<option value="{{ $attribute->id }}" @selected((string) $attr2 === (string) $attribute->id)>{{ $attribute->attribute_key }}: {{ $attribute->attribute_value }}</option>
@endforeach
</select>
</td>
<td class="text-end">
<button type="button" class="btn trans-btn btn-sm js-remove-product-variant" title="Remove row"><i class="fi-rr-trash"></i></button>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<button type="button" class="btn regular-btn" id="js-add-product-variant">Add variant row</button>
</div>
<template id="product-variant-row-template">
<tr class="product-variant-row" data-row-index="__INDEX__">
<td>
<select class="form-select" name="product_attributes[__INDEX__][attribute_1_id]" required>
<option value="">Select attribute</option>
@foreach ($attributeOptions as $attribute)
<option value="{{ $attribute->id }}">{{ $attribute->attribute_key }}: {{ $attribute->attribute_value }}</option>
@endforeach
</select>
</td>
<td>
<select class="form-select" name="product_attributes[__INDEX__][attribute_2_id]" required>
<option value="">Select attribute</option>
@foreach ($attributeOptions as $attribute)
<option value="{{ $attribute->id }}">{{ $attribute->attribute_key }}: {{ $attribute->attribute_value }}</option>
@endforeach
</select>
</td>
<td class="text-end">
<button type="button" class="btn trans-btn btn-sm js-remove-product-variant" title="Remove row"><i class="fi-rr-trash"></i></button>
</td>
</tr>
</template>
@push('scripts')
<script>
$(function () {
    function nextProductVariantIndex() {
        var max = -1;
        $('#product-variant-rows-body .product-variant-row').each(function () {
            var idx = parseInt($(this).attr('data-row-index'), 10);
            if (!isNaN(idx) && idx > max) { max = idx; }
        });
        return max + 1;
    }
    function reindexProductVariantRows() {
        $('#product-variant-rows-body .product-variant-row').each(function (i) {
            var $row = $(this);
            $row.attr('data-row-index', i);
            $row.find('[name^="product_attributes["]').each(function () {
                var name = $(this).attr('name').replace(/product_attributes\[\d+\]/, 'product_attributes[' + i + ']');
                $(this).attr('name', name);
            });
        });
    }
    $('#js-add-product-variant').on('click', function () {
        var idx = nextProductVariantIndex();
        var html = $('#product-variant-row-template').html().replace(/__INDEX__/g, idx);
        $('#product-variant-rows-body').append(html);
        reindexProductVariantRows();
    });
    $(document).on('click', '.js-remove-product-variant', function () {
        var $body = $('#product-variant-rows-body');
        if ($body.find('.product-variant-row').length <= 1) {
            $(this).closest('tr').find('select').val('');
            $(this).closest('tr').find('input[type="hidden"]').remove();
            return;
        }
        $(this).closest('tr').remove();
        reindexProductVariantRows();
    });
});
</script>
@endpush
