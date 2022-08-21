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
    <title>Sign Up</title>
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
            <h1>Create an account</h1>
        </div>
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Sign Up</h2>
                <p> Welcome to store name. Enter your personal details and start journey with us.</p>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('register') }}">
					@csrf
                    <div class="input-wrapper">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" placeholder="John Doe">
						@error('name')
							<span class="error" role="alert">{{ $message }}</span>
						@enderror
                    </div>
                    <div class="input-wrapper">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="john@example.com">
						@error('email')
							<span class="error" role="alert">{{ $message }}</span>
						@enderror
                    </div>
                    <div class="input-wrapper">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="**********"><span
                            class="icon show-pass"><i class="fi-rr-eye"> </i></span>
						@error('password')
							<span class="error" role="alert">{{ $message }}</span>
						@enderror
                    </div>
                    <div class="input-wrapper">
                        <label for="confirm-password">Confirm Password</label>
                        <input id="confirm-password" type="password" name="password_confirmation"
                            placeholder="**********"><span class="icon show-pass"><i class="fi-rr-eye"> </i></span>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
            <div class="form-footer">
                <p>Already have an account? <a class="form-link" href="{{ route('login') }}">Sign In</a></p>
            </div>
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
