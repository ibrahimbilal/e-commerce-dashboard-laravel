<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">

    <link href="{{ asset('assets/css/uicons-regular-rounded.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.min.css') }}" rel="stylesheet">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <title>@yield('title', 'Auth')</title>

    <script type="text/javascript" async>
        if (localStorage.getItem("theme_mode") != null) {
            document.documentElement.classList.add("dark");
        }
    </script>
</head>

<body class="body-class">
    @yield('content')
    <script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>
