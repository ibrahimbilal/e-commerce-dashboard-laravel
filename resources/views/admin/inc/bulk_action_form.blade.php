<form class="bulk-form">
	<select name="bulk_action" class="bulk-select text-capitalize">
		<option value="">{{ __('bulk_action.option.bulk') }}</option>
		@if (request()->trashed)
			@can($restore_perms)
				<option value="restore">{{ __('bulk_action.option.restore') }}</option>
			@endcan
			@can($force_delete_perms)
				<option value="force_delete">{{ __('bulk_action.option.force_delete') }}</option>
			@endcan
		@else
			@isset($edit_perms)
				@can($edit_perms)
					<option value="delete">{{ __('bulk_action.option.edit') }}</option>
				@endcan
			@endisset
			@can($delete_perms)
				<option value="delete">{{ __('bulk_action.option.delete') }}</option>
			@endcan
		@endif
	</select>
	<input type="hidden" name="type" class="bulk-type" value="{{ $type }}">
	<button class="btn bulk-submit text-capitalize" type="submit">{{ __('bulk_action.submit') }}</button>
</form>
