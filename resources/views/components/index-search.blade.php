@props([
    'filters' => [],
    'route' => null,
])

@php
    $filters = is_array($filters ?? null) ? $filters : [];
    $routeName = $route ?? request()->route()?->getName();
    $searchValue = old('search', $filters['search'] ?? request('search', ''));

    $preserve = collect($filters)
        ->except('search')
        ->filter(fn ($value) => $value !== null && $value !== '');

    if ($preserve->isEmpty()) {
        $preserve = collect(request()->query())
            ->except(['search', 'page'])
            ->filter(fn ($value) => $value !== null && $value !== '');
    }
@endphp

@if ($routeName)
    <form method="GET" action="{{ route($routeName) }}" class="index-search-form search-form d-flex align-items-center">
        @foreach ($preserve as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}"/>
        @endforeach
        <input
            autocomplete="off"
            class="search-input form-control"
            name="search"
            placeholder="Search..."
            type="search"
            value="{{ $searchValue }}"
        />
        <button class="submit btn btn-sm ms-1" type="submit"><i class="fi-rr-search"></i></button>
    </form>
@endif
