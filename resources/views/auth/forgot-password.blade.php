@extends('layouts.auth')

@section('title', 'Forgot Password')

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
<div class="image-wrapper" style="background-image: url({{ asset('assets/images/auth/restor-account.jpg') }})">
<h1>Restore Account</h1>
</div>
<div class="form-wrapper">
<div class="form-header">
<h2>Forgot Password?</h2>
<p>Enter your email and we'll send you instructions to reset your password.</p>
</div>
<div class="form-body">
<form action="{{ route('password.email') }}" method="POST">
@csrf
<div class="input-wrapper">
<label for="email">Email</label>
<input id="email" name="email" placeholder="john@example.com" type="email"/>
</div>
<button type="submit">Send Reset Link</button>
</form>
</div>
<div class="form-footer">
<p><span class="icon"><i class="fi-rr-angle-small-left"> </i></span><a class="form-link" href="{{ route('login') }}">Back To Login</a></p>
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
@endpush

