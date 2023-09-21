<div class="repeater d-flex mb-3">
	<select class="form-select" name="multi_currencies[]">
		@foreach (currencies_list() as $code => $name)

				<option
					value="{{ $code }}"
					@isset($current) @selected($current == $code) @endisset
					@if (isset($datas['main_currency']) && $datas['main_currency'] == $code) {{ 'disabled' }} @endif
					@if (isset($datas['multi_currencies']) && in_array($code, $datas['multi_currencies'])) {{ 'disabled' }} @endif
					>
					{{ $name }}
				</option>

		@endforeach
	</select>
	<div class="icons d-flex align-items-center ms-2">
		<span class="remove" tooltip="{{ __('buttons.remove') }}" flow="up">
			<i class="fi-rr-trash"></i>
		</span>
	</div>
</div>
