@php
    $productModel = $product ?? null;
    $activeLang = old('langs', $activeLang ?? ($productModel?->locales->first()?->locale ?? ($langs->first()->code ?? 'en')));
    $productLocale = $productModel?->locales->firstWhere('locale', $activeLang);
    $productSlug = old('product_slug', $productLocale?->product_slug ?? '');
@endphp
<div class="form-item second justify-content-between mb-2 d-flex align-items-sm-center">
<label class="item-title meta-title" for="newitem-lang">Product Lang:</label>
<select class="form-select dropdown" id="newitem-lang" name="langs">
@foreach ($langs as $lang)
<option data-flag="{{ asset('assets/images/flags/us.png') }}" value="{{ $lang->code }}" @selected($activeLang === $lang->code)>{{ $lang->name ?? $lang->code }}</option>
@endforeach
</select>
</div>
<div class="form-item second">
<label class="item-title meta-title" for="item-slug">product slug:<span class="icon info ms-2" flow="up" tooltip="slug is the bit of text that appears after your domain name in the URL of a page"><i class="fi-rr-info"> </i></span></label>
<input class="form-control mt-2" id="item-slug" name="product_slug" type="text" value="{{ $productSlug }}"/>
<input type="hidden" name="product_img" id="product-img-input" value="{{ old('product_img', $productModel?->product_img ?? '') }}"/>
</div>
