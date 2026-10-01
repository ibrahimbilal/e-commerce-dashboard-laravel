@php
    /** @var \App\Models\Category $category */
    $selectedCategoryIds = $selectedCategoryIds ?? [];
    $isChecked = in_array($category->id, $selectedCategoryIds, true);
@endphp
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" @checked($isChecked)/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">{{ $category->title }}</span>
</label>
@if ($category->relationLoaded('children') && $category->children->isNotEmpty())
<ul class="my-list child-cat">
@foreach ($category->children as $child)
@include('components.product-category-tree-item', ['category' => $child, 'selectedCategoryIds' => $selectedCategoryIds])
@endforeach
</ul>
@endif
</li>
