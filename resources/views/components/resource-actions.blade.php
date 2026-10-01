@props([
    'model',
    'resource',
    'destroyLabel' => 'item',
    'show' => true,
    'edit' => true,
])

@php
    $showRoute = $resource.'.show';
    $editRoute = $resource.'.edit';
    $destroyRoute = $resource.'.destroy';
    $canShow = $show && Route::has($showRoute);
    $canEdit = $edit && Route::has($editRoute);
    $canDestroy = Route::has($destroyRoute);
@endphp

<div class="btn-group">
    @if ($canShow)
        <a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route($showRoute, $model) }}">
            <span class="icon"><i class="fi-rr-eye"> </i></span>view
        </a>
    @endif
    @if ($canEdit)
        <a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route($editRoute, $model) }}">
            <span class="icon"><i class="fi-rr-edit"> </i></span>edit
        </a>
    @endif
    @if ($canDestroy)
    <form method="POST" action="{{ route($destroyRoute, $model) }}" class="d-inline destroy-resource-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="{{ $destroyLabel }}">
            <span class="icon"><i class="fi-rr-trash"> </i></span>trash
        </button>
    </form>
    @endif
</div>
