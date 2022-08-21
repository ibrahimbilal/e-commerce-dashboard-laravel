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
    <title>Email Verification</title>
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
        <div class="image-wrapper" style="background-image: url({{ asset('images/auth/register.jpg') }})">
            <h1>Activate Account</h1>
        </div>
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Verify Email</h2>
                <p>You must verify your email address, please check your email for a verification link</p>
            </div>
			@if ( session('status') )
				<span class="alert success">{{ session('status') }}</span>
			@endif
            <div class="form-body">
                <form method="POST" action="{{ route('verification.send') }}">
					@csrf
                    <button type="submit">Resend Email</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
