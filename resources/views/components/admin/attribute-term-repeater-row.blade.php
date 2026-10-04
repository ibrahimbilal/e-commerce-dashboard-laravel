@php
    $index = $index ?? 0;
    $row = is_array($row ?? []) ? $row : [];
    $namePrefix = 'terms['.$index.']';
    $idToken = (string) $index;
    $oldPrefix = is_numeric($index) ? 'terms.'.$index : null;
    $field = function (string $key, $default = '') use ($row, $oldPrefix) {
        if ($oldPrefix !== null) {
            return old($oldPrefix.'.'.$key, $row[$key] ?? $default);
        }

        return $row[$key] ?? $default;
    };
    $termType = $field('type', 'text');
    $termValue = (string) $field('value', '');
    $valueInputType = 'text';
    if ($termType === 'color') {
        $valueInputType = 'color';
        if (! preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $termValue)) {
            $termValue = '#000000';
        }
    }
@endphp
<div class="repeater mb-3" data-repeater-row>
<div class="repeater-title p-3 mb-3 d-flex justify-content-between align-items-center">
<h3 class="h5 mb-0" data-repeater-title-display>{{ $field('title') ?: 'Term Title' }}</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span><span class="remove" flow="up" tooltip="Remove"><i class="fi-rr-trash"> </i></span></div>
</div>
<div class="repeater-inputs px-3 active">
@if (! empty($row['id']))
<input type="hidden" name="{{ $namePrefix }}[id]" value="{{ $row['id'] }}"/>
@endif
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="term-title-{{ $idToken }}">term title:</label>
<input class="form-control" id="term-title-{{ $idToken }}" name="{{ $namePrefix }}[title]" type="text" maxlength="100" value="{{ $field('title') }}" data-repeater-title-input data-repeater-title-fallback="Term Title"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="term-type-{{ $idToken }}">term type:</label>
<select class="form-select" id="term-type-{{ $idToken }}" name="{{ $namePrefix }}[type]" data-term-type-select>
<option value="text" @selected($termType === 'text')>Text</option>
<option value="color" @selected($termType === 'color')>Color</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="term-value-{{ $idToken }}">term value:</label>
<input class="form-control" id="term-value-{{ $idToken }}" name="{{ $namePrefix }}[value]" type="{{ $valueInputType }}" maxlength="100" value="{{ $termValue }}" data-term-value-input data-term-text-value="{{ $termType === 'color' ? $termValue : $field('value', '') }}"/>
</div>
</div>
</div>
