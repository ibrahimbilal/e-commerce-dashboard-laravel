<script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@stack('scripts')
<script src="{{ asset('assets/js/script.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $(document).on('click', '.js-destroy-submit', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            var label = $(this).data('confirm-label') || 'item';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--main-color)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $form.trigger('submit');
                }
            });
        });
    });
</script>
