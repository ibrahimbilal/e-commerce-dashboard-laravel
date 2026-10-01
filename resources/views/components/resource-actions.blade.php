@props([
    'model',
    'resource',
    'destroyLabel' => 'item',
    'show' => true,
    'edit' => true,
])

<div class="btn-group">
    @if ($show)
        <a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route($resource . '.show', $model) }}">
            <span class="icon"><i class="fi-rr-eye"> </i></span>view
        </a>
    @endif
    @if ($edit)
        <a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route($resource . '.edit', $model) }}">
            <span class="icon"><i class="fi-rr-edit"> </i></span>edit
        </a>
    @endif
    <form method="POST" action="{{ route($resource . '.destroy', $model) }}" class="d-inline destroy-resource-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="{{ $destroyLabel }}">
            <span class="icon"><i class="fi-rr-trash"> </i></span>trash
        </button>
    </form>
</div>
