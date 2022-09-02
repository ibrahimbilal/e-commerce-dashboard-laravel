@extends('admin.auth-layout')

@section('title', 'Reset Password')

@section('intro', __('auth.pages.restore.intro'))

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>{{ __('auth.pages.restore.title') }}</h2>
			<p>{{ __('auth.pages.restore.sub_title') }}</p>
		</div>
		<div class="form-body">
			<form method="POST" action="{{ route('password.update') }}">
				<input type="hidden" name="token" value="{{ request()->route('token') }}">
				@csrf
				<div class="input-wrapper">
					<label for="email">{{ __('forms.email') }}</label>
					<input id="email" type="email" name="email" placeholder="john@example.com" value="{{ request()->email }}">
					@error('email')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper">
					<label for="password">{{ __('forms.new_password') }}</label>
					<input id="password" type="password" name="password" placeholder="**********"><span
						class="icon show-pass"><i class="fi-rr-eye"> </i></span>
					@error('password')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper">
					<label for="confirm-password">{{ __('forms.confirm_password') }}</label>
					<input id="confirm-password" type="password" name="password_confirmation"
						placeholder="**********"><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
				</div>
				<button type="submit">{{ __('buttons.set_password') }}</button>
			</form>
		</div>
		<div class="form-footer">
			<p><span class="icon"><i class="fi-rr-angle-small-left"> </i></span><a class="form-link"
					href="{{ route('login') }}">{{ __('buttons.back_to_login') }}</a></p>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Show Password
        $('.show-pass').on('click', function() {
            var type = $(this).prev('input').attr('type');
            if (type == 'password') {
                $(this).prev('input').attr('type', 'text');
                $(this).find('i').removeClass('fi-rr-eye').addClass('fi-rr-eye-crossed');
            } else {
                $(this).prev('input').attr('type', 'password');
                $(this).find('i').removeClass('fi-rr-eye-crossed').addClass('fi-rr-eye');
            }
        });
    </script>
@endpush
