@props([
    'counts' => [],
    'filters' => [],
    'route' => null,
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
/>
