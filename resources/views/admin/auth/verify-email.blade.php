@extends('admin.auth-layout')

@section('title', 'Email Verification')

@section('intro', __('auth.pages.verify.intro'))

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>{{ __('auth.pages.verify.title') }}</h2>
			<p>{{ __('auth.pages.verify.sub_title') }}</p>
		</div>
		@if ( session('status') == 'verification-link-sent' )
			<span class="alert success">{{ __('auth.verification-link-sent') }}</span>
		@endif
		<div class="form-body">
			<form method="POST" action="{{ route('verification.send') }}">
				@csrf
				<button type="submit">{{ __('buttons.resend') }}</button>
			</form>
		</div>
	</div>
@endsection
