@php
    $selectedCategoryIds = array_map('intval', (array) ($selectedCategoryIds ?? []));
@endphp
<div class="cat-list-holder">
<ul class="my-list main-list">
@forelse ($categories as $category)
@include('components.product-category-tree-item', ['category' => $category, 'selectedCategoryIds' => $selectedCategoryIds])
@empty
<li class="my-item"><span class="text-muted">No categories yet.</span></li>
@endforelse
</ul>
</div>
