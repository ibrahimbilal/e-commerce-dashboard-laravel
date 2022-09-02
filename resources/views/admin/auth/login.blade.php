@extends('admin.auth-layout')

@section('title', 'Login')

@section('intro', __('auth.pages.login.intro'))

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>{{ __('auth.pages.login.title') }}</h2>
			<p>{{ __('auth.pages.login.sub_title') }}</p>
		</div>
		<div class="form-body">
			<form method="POST" action="{{ url('admin/login') }}">
				@csrf
				<div class="input-wrapper">
					<label for="email">{{ __('forms.email') }}</label>
					<input id="email" type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
					@error('email')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper">
					<label for="password">{{ __('forms.password') }}</label>
					<input id="password" type="password" name="password" placeholder="**********"  value="{{ old('password') }}">
					<span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
					@error('password')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper more-action">
					<label>
						<input id="remember-me" type="checkbox" name="remember_token" @checked(old('remember_token') == 'on')>{{ __('forms.remember') }}
					</label>
					<a class="form-link" href="{{ route('password.email') }}">{{ __('forms.forget_password') }}</a>
				</div>
				<button type="submit">{{ __('buttons.login') }}</button>
			</form>
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
