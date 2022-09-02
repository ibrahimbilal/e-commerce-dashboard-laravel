@extends('admin.auth-layout')

@section('title', 'Forgot Password?')

@section('intro', __('auth.pages.forget.intro'))

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>{{ __('auth.pages.forget.title') }}</h2>
			<p>{{ __('auth.pages.forget.sub_title') }}</p>
		</div>
		@if ( session('status') )
			<span class="alert success">{{ session('status') }}</span>
		@endif
		<div class="form-body">
			<form method="POST" action="{{ route('password.email') }}">
				@csrf
				<div class="input-wrapper">
					<label for="email">{{ __('forms.email') }}</label>
					<input id="email" type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
					@error('email')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<button type="submit">{{ __('buttons.reset_link') }}</button>
			</form>
		</div>
		<div class="form-footer">
			<p><span class="icon"><i class="fi-rr-angle-small-left"> </i></span>
				<a class="form-link" href="{{ route('login') }}">{{ __('buttons.back_to_login') }}</a></p>
		</div>
	</div>
@endsection
