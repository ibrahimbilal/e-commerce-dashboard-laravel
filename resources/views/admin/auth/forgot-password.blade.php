@extends('admin.auth-layout')

@section('title', 'Forgot Password?')

@section('intro', 'Restore Account')

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>Forgot Password?</h2>
			<p>Enter your email and we'll send you instructions to reset your password.</p>
		</div>
		@if ( session('status') )
			<span class="alert success">{{ session('status') }}</span>
		@endif
		<div class="form-body">
			<form method="POST" action="{{ route('password.email') }}">
				@csrf
				<div class="input-wrapper">
					<label for="email">Email</label>
					<input id="email" type="email" name="email" placeholder="john@example.com">
					@error('email')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<button type="submit">Send Reset Link</button>
			</form>
		</div>
		<div class="form-footer">
			<p><span class="icon"><i class="fi-rr-angle-small-left"> </i></span>
				<a class="form-link" href="{{ route('login') }}">Back To Login</a></p>
		</div>
	</div>
@endsection
