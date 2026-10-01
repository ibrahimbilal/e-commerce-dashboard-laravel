<script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@stack('scripts')
<script src="{{ asset('assets/js/script.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $(document).on('click', '.js-destroy-submit', function (e) {
            e.preventDefault();
            var formId = $(this).attr('form');
            var $form = formId ? $('#' + formId) : $(this).closest('form');
            var label = $(this).data('confirm-label') || 'item';
            var isPermanent = $(this).data('permanent-delete') === 1 || $(this).data('permanent-delete') === '1';
            Swal.fire({
                title: 'Are you sure?',
                text: isPermanent
                    ? 'This will permanently delete this ' + label + '. This action cannot be undone.'
                    : "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--main-color)',
                cancelButtonColor: '#d33',
                confirmButtonText: isPermanent ? 'Yes, delete permanently!' : 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $form.trigger('submit');
                }
            });
        });
    });
</script>
