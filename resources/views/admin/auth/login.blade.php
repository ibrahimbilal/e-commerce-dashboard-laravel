<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <!-- Meta Tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Icons-->
    <link href="{{ asset('css/uicons-regular-rounded.css') }}" rel="stylesheet">
    <!-- Style-->
    <link href="{{ asset('css/auth.min.css') }}" rel="stylesheet">
    <!-- Fonts-->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet">
    <title>Login</title>
    <!-- async scripts-->
    <script type="text/javascript" async>
        // Active Dark Mode On Load Page
        if (localStorage.getItem("theme_mode") != null) {
            document.documentElement.classList.add("dark");
        }
    </script>
</head>

<body class="body-class">
    <div class="container">
        <div class="image-wrapper" style="background-image: url({{ asset('images/auth/login.jpg') }})">
            <h1>Welcome Back</h1>
        </div>
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Login</h2>
                <p>Welcome back! Please login to your account and continue growing your store.</p>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('login') }}">
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
                            <input id="remember-me" type="checkbox" name="remember_token" {{ old('remember_token') == 'on' ? 'checked' : '' }}>Remember Me
                        </label>
						<a class="form-link" href="{{ route('password.email') }}">Forgot Password?</a>
                    </div>
                    <button type="submit">Sign In</button>
                </form>
            </div>
			{{-- <div class="form-footer">
				<p>Don't have an account yet? <a class="form-link" href="{{ route('register') }}">Sign Up</a></p>
			</div> --}}
        </div>
    </div>
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
</body>

</html>
