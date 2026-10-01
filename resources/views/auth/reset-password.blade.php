@extends('layouts.auth')

@section('title', 'Reset Password')

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
<div class="image-wrapper" style="background-image: url({{ asset('assets/images/auth/reset-password.jpg') }})">
<h1>Restore Account</h1>
</div>
<div class="form-wrapper">
<div class="form-header">
<h2>Reset Password</h2>
<p>Your new password must be different from previously used passwords.</p>
</div>
<div class="form-body">
<form action="{{ route('password.update') }}" method="POST">
@csrf
<input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}">
<div class="input-wrapper">
<label for="password">New Password</label>
<input id="password" name="password" placeholder="**********" type="password"/><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<div class="input-wrapper">
<label for="confirm-password">Confirm Password</label>
<input id="confirm-password" name="confirm_password" placeholder="**********" type="password"/><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<button type="submit">Set New Password</button>
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
<script type="text/javascript">
      // Show Password;
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

