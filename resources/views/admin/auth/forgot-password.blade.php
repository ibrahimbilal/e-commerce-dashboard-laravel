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
    <title>Forgot Password?</title>
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
        <div class="image-wrapper" style="background-image: url({{ asset('images/auth/restor-account.jpg') }})">
            <h1>Restore Account</h1>
        </div>
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Forgot Password?</h2>
                <p>Enter your email and we'll send you instructions to reset your password.</p>
            </div>
			@if ( session('status') )
				<span class="alert success">{{ session('status') }}</span>
			@endif
            <div class="form-body">
                <form method="POST" action="{{ route('password.request') }}">
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
                <p><span class="icon"><i class="fi-rr-angle-small-left"> </i></span><a class="form-link"
                        href="{{ route('login') }}">Back To Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>
