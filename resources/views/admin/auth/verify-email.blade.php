@extends('admin.auth-layout')

@section('title', 'Email Verification')

@section('intro', 'Activate Account')

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>Verify Email</h2>
			<p>You must verify your email address, please check your email for a verification link</p>
		</div>
		@if ( session('status') == 'verification-link-sent' )
			<span class="alert success">{{ __('Verification link sent, please check your email.') }}</span>
		@endif
		<div class="form-body">
			<form method="POST" action="{{ route('verification.send') }}">
				@csrf
				<button type="submit">Resend Email</button>
			</form>
		</div>
	</div>
@endsection
