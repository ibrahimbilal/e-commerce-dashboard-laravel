@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mt-3 mb-2">
        {{ $paginator->links() }}
    </div>
@endif
