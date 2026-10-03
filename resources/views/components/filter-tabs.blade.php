@props([
    'counts' => [],
    'filters' => [],
    'tabs' => [],
    'route' => null,
])

@php
    $counts = is_array($counts ?? null) ? $counts : [];
    $filters = is_array($filters ?? null) ? $filters : [];
    $routeName = $route ?? request()->route()?->getName();

    $searchValue = $filters['search'] ?? request('search');
    if ($searchValue !== null && $searchValue !== '') {
        $filters['search'] = $searchValue;
    }

    $tabParamKeys = collect($tabs)
        ->flatMap(fn (array $tab) => array_keys($tab['params'] ?? []))
        ->unique()
        ->values()
        ->all();

    $activeFilters = collect($filters)
        ->filter(fn ($value, $key) => $key !== 'search' && $value !== null && $value !== '');

    $isTabActive = function (array $tab) use ($activeFilters, $tabParamKeys): bool {
        $params = $tab['params'] ?? [];
        $key = $tab['key'] ?? '';

        if ($key === 'all' || $params === []) {
            return $activeFilters->keys()->intersect($tabParamKeys)->isEmpty();
        }

        foreach ($params as $paramKey => $paramValue) {
            if ((string) ($activeFilters[$paramKey] ?? '') !== (string) $paramValue) {
                return false;
            }
        }

        return $activeFilters->keys()->diff(array_keys($params))->isEmpty();
    };

    $buildQuery = function (array $params) use ($searchValue): array {
        $query = $params;
        if ($searchValue !== null && $searchValue !== '') {
            $query['search'] = $searchValue;
        }

        return $query;
    };
@endphp

@if ($routeName && count($tabs) > 0)
    <div {{ $attributes->merge(['class' => 'dash-filters']) }}>
        @foreach ($tabs as $tab)
            @php
                $countKey = $tab['key'] ?? null;
                $showTab = $countKey === null
                    || $countKey === 'all'
                    || array_key_exists($countKey, $counts);

                if (! $showTab) {
                    continue;
                }

                $label = $tab['label'] ?? ucfirst((string) $countKey);
                $countSuffix = array_key_exists($countKey, $counts)
                    ? ' ('.$counts[$countKey].')'
                    : '';
                $href = route($routeName, $buildQuery($tab['params'] ?? []));
                $activeClass = $isTabActive($tab) ? ' active' : '';
            @endphp
            <a class="item text-capitalize{{ $activeClass }}" href="{{ $href }}" data-count-key="{{ $countKey }}" data-count-label="{{ $label }}">{{ $label }}{{ $countSuffix }}</a>
        @endforeach
    </div>
@endif
