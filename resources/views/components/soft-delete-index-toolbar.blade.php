@props([
    'counts' => [],
    'filters' => [],
    'route' => null,
    'showSearch' => true,
])

@php
    $softDeleteFilterTabs = [
        ['label' => __('admin.filters.all'), 'key' => 'all', 'params' => []],
        ['label' => __('admin.filters.trashed'), 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
@endphp

<x-index-list-toolbar
    :counts="$counts"
    :filters="$filters"
    :tabs="$softDeleteFilterTabs"
    :route="$route"
    :showSearch="$showSearch"
/>
