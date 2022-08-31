@extends('admin.auth-layout')

@section('title', 'Login')

@section('intro', 'Welcome Back')

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>Login</h2>
			<p>Welcome back! Please login to your account and continue growing your store.</p>
		</div>
		<div class="form-body">
			<form method="POST" action="{{ url('admin/login') }}">
				@csrf
				<div class="input-wrapper">
					<label for="email">Email</label>
					<input id="email" type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
					@error('email')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper">
					<label for="password">Password</label>
					<input id="password" type="password" name="password" placeholder="**********"  value="{{ old('password') }}">
					<span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
					@error('password')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<div class="input-wrapper more-action">
					<label>
						<input id="remember-me" type="checkbox" name="remember_token" @checked(old('remember_token') == 'on')>Remember Me
					</label>
					<a class="form-link" href="{{ route('password.email') }}">Forgot Password?</a>
				</div>
				<button type="submit">Sign In</button>
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
