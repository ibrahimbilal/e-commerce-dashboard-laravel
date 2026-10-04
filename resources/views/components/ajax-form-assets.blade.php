@once
    @push('scripts')
        <script>
            window.AdminAjaxFormMessages = {
                ops: @json(__('alerts.ops')),
                ok: @json(__('alerts.btn_text')),
            };
        </script>
        <script src="{{ asset('assets/js/ajax-form.js') }}" type="text/javascript"></script>
    @endpush
@endonce
