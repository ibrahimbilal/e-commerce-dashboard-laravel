@props([
    'counts' => [],
    'filters' => [],
    'route' => null,
    'showSearch' => true,
])

@php
    $softDeleteFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
@endphp

<x-index-list-toolbar
    :counts="$counts"
    :filters="$filters"
    :tabs="$softDeleteFilterTabs"
    :route="$route"
    :showSearch="$showSearch"
/>
