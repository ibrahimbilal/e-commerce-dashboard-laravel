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
    <title>Two Step Verification</title>
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
        <div class="image-wrapper" style="background-image: url({{ asset('images/auth/2fa.jpg') }})">
            <h1>Welcome Back</h1>
        </div>
        <div class="form-wrapper" data-form="code">
            <div class="form-header">
                <h2>Two Step Verification</h2>
                <p>Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>
            </div>
			@error('code')
				<span class="alert danger" role="alert">{{ $message }}</span>
			@enderror
            <div class="form-body">
                <form method="POST" action="{{ url('/two-factor-challenge') }}">
					@csrf
                    <div class="input-wrapper">
                        <label for="code">Code</label>
                        <input id="code" type="text" name="code">
                    </div>
                    <button type="submit">Sign In</button>
                </form>
            </div>
            <div class="form-footer">
                <p><a class="form-link" href="javascript:void(0)" data-btn="recovery">Use a recovery code</a></p>
            </div>
        </div>

		<div class="form-wrapper" data-form="recovery" style="display: none">
			<div class="form-header">
				<h2>Two Step Verification</h2>
				<p>Please confirm access to your account by entering one of your emergency recovery codes.</p>
			</div>
			<div class="form-body">
				<form method="POST" action="{{ url('/two-factor-challenge') }}">
					@csrf
					<div class="input-wrapper">
						<label for="code">Recovery Code</label>
						<input id="code" type="text" name="recovery_code">
					</div>
					<button type="submit">Sign In</button>
				</form>
			</div>
			<div class="form-footer">
				<p><a class="form-link" href="javascript:void(0)" data-btn="code">Use an authentication code</a></p>
			</div>
		</div>
    </div>

	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Toggle Form;
        $('.form-link').on('click', function() {
            var formType = $(this).data('btn');
			$('.form-wrapper').data('form', formType).toggle();
        });
    </script>
</body>

</html>
