@props([
    'model',
    'resource',
    'destroyLabel' => 'item',
    'show' => true,
    'edit' => true,
    'permissionSection' => null,
])

@php
    $routeBase = str_starts_with($resource, 'admin.') ? $resource : 'admin.'.$resource;
    $showRoute = $routeBase.'.show';
    $editRoute = $routeBase.'.edit';
    $destroyRoute = $routeBase.'.destroy';
    $restoreRoute = $routeBase.'.restore';
    $forceDeleteRoute = $routeBase.'.force-delete';
    $section = $permissionSection ?? match ($resource) {
        'order-statuses' => 'orders',
        'coupons' => 'discounts',
        default => $resource,
    };
    $isTrashed = is_object($model) && method_exists($model, 'trashed') && $model->trashed();
    $canShow = ! $isTrashed && $show && Route::has($showRoute) && auth()->user()?->can('view '.$section);
    $canEdit = ! $isTrashed && $edit && Route::has($editRoute) && auth()->user()?->can('edit '.$section);
    $canDestroy = ! $isTrashed && Route::has($destroyRoute) && auth()->user()?->can('delete '.$section);
    $canRestore = $isTrashed && Route::has($restoreRoute) && auth()->user()?->can('restore '.$section);
    $canForceDelete = $isTrashed && Route::has($forceDeleteRoute) && auth()->user()?->can('permanently_delete '.$section);
@endphp

@if ($canShow || $canEdit || $canDestroy || $canRestore || $canForceDelete)
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
    <form method="POST" action="{{ route($destroyRoute, $model) }}" class="d-inline destroy-resource-form" data-confirm-delete="soft" data-confirm-label="{{ $destroyLabel }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-rounded me-2 py-1" data-confirm-delete="soft" data-confirm-label="{{ $destroyLabel }}">
            <span class="icon"><i class="fi-rr-trash"> </i></span>trash
        </button>
    </form>
    @endif
    @if ($canRestore)
    <form method="POST" action="{{ route($restoreRoute, $model) }}" class="d-inline" data-confirm-delete="restore" data-confirm-label="{{ $destroyLabel }}">
        @csrf
        @method('PATCH')
        <button type="button" class="btn btn-primary btn-rounded me-2 py-1" data-confirm-delete="restore" data-confirm-label="{{ $destroyLabel }}">
            <span class="icon"><i class="fi-rr-undo"> </i></span>restore
        </button>
    </form>
    @endif
    @if ($canForceDelete)
    <form method="POST" action="{{ route($forceDeleteRoute, $model) }}" class="d-inline destroy-resource-form" data-confirm-delete="permanent" data-confirm-label="{{ $destroyLabel }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-rounded me-2 py-1" data-confirm-delete="permanent" data-confirm-label="{{ $destroyLabel }}">
            <span class="icon"><i class="fi-rr-cross-circle"> </i></span>delete permanently
        </button>
    </form>
    @endif
</div>
@endif
