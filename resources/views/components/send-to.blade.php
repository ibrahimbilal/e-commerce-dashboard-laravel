<div class="item-title">{{ __('forms.send_to.title') }}
	<span class="icon info ms-2" tooltip="{{ __('forms.send_to.tooltip') }}" flow="up">
		<i class="fi-rr-info"></i>
	</span>
</div>
<div class="controls-wrapper d-flex align-items-start mt-2">
	<select class="form-select w-mc me-2" name="{{ $typeName }}">
		<option value="">{{ __('forms.send_to.options.no') }}</option>
		<option value="custom" @isset($sets[$typeName]) @selected($sets[$typeName] == 'custom') @endisset>{{ __('forms.send_to.options.custom') }}</option>
		<option value="recipients-role" @isset($sets[$typeName]) @selected($sets[$typeName] == 'recipients-role') @endisset>{{ __('forms.send_to.options.by_role') }}</option>
	</select>
	<div class="select2-wrapper w-100">
		<select class="form-select multi-select"
			id="{{ $id }}"
			name="{{ $selName }}[]"
			placeholder="{{ __('forms.send_to.placeholder') }}"
			multiple>
			@if ($sets[$typeName] == 'custom')
				@foreach ( $users as $user )
					<option value="{{ $user->id }}" @isset($sets[$selName]) @selected(in_array($user->id, $sets[$selName])) @endisset>{{ $user->email }}</option>
				@endforeach
			@elseif ($sets[$typeName] == 'recipients-role')
				@foreach ( $roles as $role )
					<option value="{{ $role->id }}" @isset($sets[$selName]) @selected(in_array($role->id, $sets[$selName])) @endisset>{{ $role->name }}</option>
				@endforeach
			@endif
		</select>
	</div>
</div>
