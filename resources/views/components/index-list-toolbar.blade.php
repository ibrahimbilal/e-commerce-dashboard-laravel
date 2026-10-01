@props([
    'counts' => [],
    'filters' => [],
    'tabs' => [],
    'route' => null,
    'showSearch' => true,
])

<div {{ $attributes->merge(['class' => 'col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2 gap-2']) }}>
    <x-filter-tabs :counts="$counts" :filters="$filters" :tabs="$tabs" :route="$route" />
    @if ($showSearch)
        <x-index-search :filters="$filters" :route="$route" />
    @endif
</div>
