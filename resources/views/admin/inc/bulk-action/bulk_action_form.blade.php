<form class="bulk-form">
	<select name="bulk_action" class="bulk-select text-capitalize">
		<option value="">{{ __('bulk_action.option.bulk') }}</option>
		@if (request()->trashed)
			<option value="restore">{{ __('bulk_action.option.restore') }}</option>
			<option value="force_delete">{{ __('bulk_action.option.force_delete') }}</option>
		@else
			<option value="delete">{{ __('bulk_action.option.delete') }}</option>
		@endif
	</select>
	<input type="hidden" name="type" class="bulk-type" value="{{ $type }}">
	<button class="btn bulk-submit text-capitalize" type="submit">{{ __('bulk_action.submit') }}</button>
</form>
