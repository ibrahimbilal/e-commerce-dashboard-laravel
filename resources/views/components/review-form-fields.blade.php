@php
    $reviewModel = $review ?? null;
    $customerId = old('customer_id', $reviewModel?->customer_id);
    $productId = old('product_id', $reviewModel?->product_id);
    $rate = old('rate', $reviewModel?->rate ?? 5);
    $comment = old('comment', $reviewModel?->comment ?? '');
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
<label class="item-title" for="product-id">Product:</label>
<select class="form-select" id="product-id" name="product_id">
<option value="">No product</option>
@foreach ($products as $product)
@php
    $name = $product->locales->first()?->name ?? ('Product #'.$product->id);
@endphp
<option value="{{ $product->id }}" @selected((string) $productId === (string) $product->id)>{{ $name }}</option>
@endforeach
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="rate">Rating (0–5):</label>
<input class="form-control" id="rate" name="rate" type="number" min="0" max="5" value="{{ $rate }}" required/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="comment">Comment:</label>
<textarea class="form-control" id="comment" name="comment" rows="4" maxlength="191" required>{{ $comment }}</textarea>
</div>
