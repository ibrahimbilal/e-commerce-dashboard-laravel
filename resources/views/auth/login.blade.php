@extends('layouts.auth')

@section('title', 'Login')

@push('styles')
<script async="" type="text/javascript">
      // Active Dark Mode On Load Page
      if (localStorage.getItem("theme_mode") != null) {
      	document.documentElement.classList.add("dark");
      }
      
    </script>
@endpush

@section('content')
<div class="container">
<div class="image-wrapper" style="background-image: url({{ asset('assets/images/auth/login.jpg') }})">
<h1>Welcome Back</h1>
</div>
<div class="form-wrapper">
<div class="form-header">
<h2>Login</h2>
<p>Welcome back! Please login to your account and continue growing your store.</p>
</div>
<div class="form-body">
<form action="{{ route('login') }}" method="POST">
@csrf
<div class="input-wrapper">
<label for="email">Email</label>
<input id="email" name="email" placeholder="john@example.com" type="email"/>
</div>
<div class="input-wrapper">
<label for="password">Password</label>
<input id="password" name="password" placeholder="**********" type="password"/><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<div class="input-wrapper more-action">
<label>
<input id="remember-me" name="remember_me" type="checkbox"/>Remember Me
              </label><a class="form-link" href="{{ route('password.request') }}">Forgot Password?</a>
</div>
<button type="submit">Sign In</button>
</form>
</div>
<div class="form-footer">
<p>Don't have an account yet? <a class="form-link" href="{{ route('register') }}">Sign Up</a></p>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" type="text/javascript">
      // Active Dark Mode On Load Page
      if (localStorage.getItem("theme_mode") != null) {
      	document.documentElement.classList.add("dark");
      }
      
    </script>
<script type="text/javascript">
      // Show Password
      $('.show-pass').on('click', function () {
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

