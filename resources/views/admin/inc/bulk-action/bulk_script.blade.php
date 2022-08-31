<script id="bulk-action-script">

	// let SwalOptions = {
	// 	showConfirmButton: true,
	// 	confirmButtonColor: 'var(--main-color)',
	// 	confirmButtonText: "{{ __('alerts.btn_text') }}",
	// 	scrollbarPadding: false,
	// };

    $('.bulk-form').on('submit', function(e) {
        e.preventDefault();
        let rows = $('.table tr.selected');
        let action = $(this).find('.bulk-select').val();
        let type = $(this).find('.bulk-type').val();
        let ids = [];
		let confirmTitle = confirmText = confirmYesBtn = deleteText = '';

        rows.each(function(i, el) {
            ids.push($(this).data('id'));
        });

        // return error if no action selected
        if (action == '') {
            Swal.fire({
				...SwalOptions,
                icon: 'error',
                title: "{{ __('alerts.ops') }}",
                text: "{{ __('bulk_action.no_action') }}",
            });
            return;
        }
        // return error if no items selected
        if (ids.length == 0) {
            Swal.fire({
				...SwalOptions,
                icon: 'error',
                title: "{{ __('alerts.ops') }}",
                text: "{{ __('bulk_action.no_items') }}",
            });
            return;
        }

        if (action == 'restore') {
			confirmText = "{{ __('bulk_action.confirm.restore.text') }}";
			confirmYesBtn = "{{ __('bulk_action.confirm.restore.yes') }}";
			cancelText = "{{ __('bulk_action.cancel.restore.text') }}";
        }

        if (action == 'delete' || action == 'force_delete') {
			confirmText = "{{ __('bulk_action.confirm.delete.text') }}";
			confirmYesBtn = "{{ __('bulk_action.confirm.delete.yes') }}";
			cancelText = "{{ __('bulk_action.cancel.delete.text') }}";
		}

		Swal.fire({
			...SwalOptions,
			title: "{{ __('bulk_action.confirm.title') }}",
			text: confirmText,
			icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonText: confirmYesBtn,
			cancelButtonText: "{{ __('bulk_action.confirm.no') }}",
		}).then((result) => {
			if (result.isConfirmed) {
				doBulkAction(ids, action, type);
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				Swal.fire({
					...SwalOptions,
					title: "{{ __('bulk_action.cancel.title') }}",
					text: cancelText,
					icon: 'error',
					timer: 1500,
					timerProgressBar: true,
					showConfirmButton: false,
				})
			}
		})

        function doBulkAction(ids = [], action = 'delete', type) {
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.bulk_action') }}",
                data: {
                    items: ids,
                    action: action,
                    type: type
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
							...SwalOptions,
                            title: res.title,
                            text: res.text,
                            icon: 'success',
                            willClose: () => {
                                rows.each(function(i, el) {
                                    if (jQuery.inArray($(this).data('id'),
                                        ids) >= 0) {
                                        $(this).hide(500);
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
							...SwalOptions,
                            icon: 'warning',
                            title: res.title,
                            text: res.text,
                        });
                    }
                },
                error: function(res) {
                    Swal.fire({
						...SwalOptions,
                        icon: 'error',
                        title: "{{ __('alerts.ops') }}",
                        html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                            Object.keys(res.responseJSON.errors).map(k =>
                                '<li class="content">' + res.responseJSON.errors[k] +
                                '</li>').join('') + '</ul></div>',
                    });
                }
            });
        }

    });
</script>
