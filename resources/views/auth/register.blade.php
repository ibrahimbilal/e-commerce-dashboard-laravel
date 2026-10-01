@extends('layouts.auth')

@section('title', 'Sign Up')

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
<div class="image-wrapper" style="background-image: url({{ asset('assets/images/auth/register.jpg') }})">
<h1>Create an account</h1>
</div>
<div class="form-wrapper">
<div class="form-header">
<h2>Sign Up</h2>
<p> Welcome to store name. Enter your personal details and start journey with us.</p>
</div>
<div class="form-body">
<form action="{{ route('register') }}" method="POST">
@csrf
<div class="input-wrapper">
<label for="name">Name</label>
<input id="name" name="name" placeholder="John Doe" type="text"/>
</div>
<div class="input-wrapper">
<label for="email">Email</label>
<input id="email" name="email" placeholder="john@example.com" type="email"/>
</div>
<div class="input-wrapper">
<label for="password">Password</label>
<input id="password" name="password" placeholder="**********" type="password"/><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<div class="input-wrapper">
<label for="confirm-password">Confirm Password</label>
<input id="confirm-password" name="confirm_password" placeholder="**********" type="password"/><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<button type="submit">Sign Up</button>
</form>
</div>
<div class="form-footer">
<p>Already have an account? <a class="form-link" href="{{ route('login') }}">Sign In</a></p>
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

