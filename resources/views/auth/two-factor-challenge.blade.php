@extends('layouts.auth')

@section('title', 'Two Step Verification')

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
<div class="image-wrapper" style="background-image: url({{ asset('assets/images/auth/2fa.jpg') }})">
<h1>Welcome Back</h1>
</div>
<div class="form-wrapper">
<div class="form-header">
<h2>Two Step Verification</h2>
<p>Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>
</div>
<div class="form-body">
<form>
<div class="input-wrapper">
<label for="code">Code</label>
<input id="code" name="code" type="text"/>
</div>
<button type="submit">Sign In</button>
</form>
</div>
<div class="form-footer">
<p><a class="form-link" href="{{ route('two-factor.recovery') }}">Use a recovery code</a></p>
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

