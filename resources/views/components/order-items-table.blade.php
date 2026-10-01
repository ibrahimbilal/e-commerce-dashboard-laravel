@php
    $orderModel = $order ?? null;
    $itemRows = old('items');
    if ($itemRows === null && $orderModel) {
        $itemRows = $orderModel->items->map(fn ($item) => [
            'product_attribute_id' => $item->product_attribute_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ])->values()->all();
    }
    if ($itemRows === null || $itemRows === []) {
        $itemRows = [['product_attribute_id' => '', 'quantity' => 1, 'price' => '']];
    }

    $variantOptions = isset($productVariants) ? collect($productVariants) : collect();
    if ($variantOptions->isEmpty() && $orderModel) {
        $orderModel->loadMissing([
            'items.productAttribute.attributeOne',
            'items.productAttribute.attributeTwo',
            'items.productAttribute.product.locales',
        ]);
        $variantOptions = $orderModel->items
            ->pluck('productAttribute')
            ->filter()
            ->unique('id')
            ->values();
    }

    $variantLabel = function ($variant) {
        if (! $variant) {
            return '';
        }
        $productName = $variant->product?->locales?->first()?->name ?? ('Product #'.($variant->product_id ?? '?'));
        $one = $variant->attributeOne?->attribute_value ?? $variant->attributeOne?->attribute_key ?? '?';
        $two = $variant->attributeTwo?->attribute_value ?? $variant->attributeTwo?->attribute_key ?? '?';

        return $productName.' ('.$one.' / '.$two.') [#'.$variant->id.']';
    };
@endphp
@if ($variantOptions->isEmpty())
<p class="text-muted small mb-2">No product variant list from OrderController — options are limited to variants already on this order (edit) or enter IDs after backend adds a lookup.</p>
@endif
<div id="order-items-table" class="order-items-table">
<div class="table-responsive">
<table class="table table-bordered mb-2">
<thead>
<tr>
<th class="text-capitalize">Product variant</th>
<th class="text-capitalize" style="width: 120px;">Qty</th>
<th class="text-capitalize" style="width: 140px;">Unit price</th>
<th class="text-capitalize text-end" style="width: 120px;">Line total</th>
<th style="width: 70px;"></th>
</tr>
</thead>
<tbody id="order-items-body">
@foreach ($itemRows as $index => $row)
@php
    $idx = is_numeric($index) ? (int) $index : $loop->index;
    $paId = is_array($row) ? ($row['product_attribute_id'] ?? '') : '';
    $qty = is_array($row) ? ($row['quantity'] ?? 1) : 1;
    $price = is_array($row) ? ($row['price'] ?? '') : '';
@endphp
<tr class="order-item-row" data-row-index="{{ $idx }}">
<td>
<select class="form-select js-order-item-variant" name="items[{{ $idx }}][product_attribute_id]" required>
<option value="">Select variant</option>
@foreach ($variantOptions as $variant)
<option value="{{ $variant->id }}" @selected((string) $paId === (string) $variant->id)>{{ $variantLabel($variant) }}</option>
@endforeach
@if ($paId && ! $variantOptions->contains(fn ($v) => (string) $v->id === (string) $paId))
<option value="{{ $paId }}" selected>Variant #{{ $paId }}</option>
@endif
</select>
</td>
<td>
<input class="form-control js-order-item-qty" name="items[{{ $idx }}][quantity]" type="number" min="1" step="1" value="{{ $qty }}" required/>
</td>
<td>
<input class="form-control js-order-item-price" name="items[{{ $idx }}][price]" type="number" min="0" step="1" value="{{ $price }}" required/>
</td>
<td class="text-end align-middle">
<span class="js-order-line-total">0</span>
</td>
<td class="text-end align-middle">
<button type="button" class="btn trans-btn btn-sm js-remove-order-item" title="Remove row"><i class="fi-rr-trash"></i></button>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
<button type="button" class="btn regular-btn" id="js-add-order-item">Add line item</button>
<div class="form-item second mb-0">
<strong>Items subtotal:</strong> $<span id="order-items-running-total">0</span>
</div>
</div>
</div>
<template id="order-item-row-template">
<tr class="order-item-row" data-row-index="__INDEX__">
<td>
<select class="form-select js-order-item-variant" name="items[__INDEX__][product_attribute_id]" required>
<option value="">Select variant</option>
@foreach ($variantOptions as $variant)
<option value="{{ $variant->id }}">{{ $variantLabel($variant) }}</option>
@endforeach
</select>
</td>
<td>
<input class="form-control js-order-item-qty" name="items[__INDEX__][quantity]" type="number" min="1" step="1" value="1" required/>
</td>
<td>
<input class="form-control js-order-item-price" name="items[__INDEX__][price]" type="number" min="0" step="1" value="" required/>
</td>
<td class="text-end align-middle">
<span class="js-order-line-total">0</span>
</td>
<td class="text-end align-middle">
<button type="button" class="btn trans-btn btn-sm js-remove-order-item" title="Remove row"><i class="fi-rr-trash"></i></button>
</td>
</tr>
</template>
@push('scripts')
<script>
$(function () {
    function lineTotal($row) {
        var q = parseFloat($row.find('.js-order-item-qty').val()) || 0;
        var p = parseFloat($row.find('.js-order-item-price').val()) || 0;
        return Math.round(q * p);
    }
    function refreshOrderItemsTotals() {
        var sum = 0;
        $('#order-items-body .order-item-row').each(function () {
            var lt = lineTotal($(this));
            $(this).find('.js-order-line-total').text(lt);
            sum += lt;
        });
        $('#order-items-running-total').text(sum);
    }
    function nextOrderItemIndex() {
        var max = -1;
        $('#order-items-body .order-item-row').each(function () {
            var idx = parseInt($(this).attr('data-row-index'), 10);
            if (!isNaN(idx) && idx > max) { max = idx; }
        });
        return max + 1;
    }
    function reindexOrderItemRows() {
        $('#order-items-body .order-item-row').each(function (i) {
            var $row = $(this);
            $row.attr('data-row-index', i);
            $row.find('[name^="items["]').each(function () {
                var name = $(this).attr('name').replace(/items\[\d+\]/, 'items[' + i + ']');
                $(this).attr('name', name);
            });
        });
    }
    $('#js-add-order-item').on('click', function () {
        var idx = nextOrderItemIndex();
        var html = $('#order-item-row-template').html().replace(/__INDEX__/g, idx);
        $('#order-items-body').append(html);
        reindexOrderItemRows();
        refreshOrderItemsTotals();
    });
    $(document).on('click', '.js-remove-order-item', function () {
        var $body = $('#order-items-body');
        if ($body.find('.order-item-row').length <= 1) {
            $(this).closest('tr').find('select, input').val('');
            refreshOrderItemsTotals();
            return;
        }
        $(this).closest('tr').remove();
        reindexOrderItemRows();
        refreshOrderItemsTotals();
    });
    $(document).on('input change', '.js-order-item-qty, .js-order-item-price', refreshOrderItemsTotals);
    refreshOrderItemsTotals();
});
</script>
@endpush
