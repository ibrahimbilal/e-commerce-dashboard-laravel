<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="robots" content="noindex, nofollow">
<meta name="googlebot" content="noindex, nofollow">
<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/css/uicons-regular-rounded.css') }}" rel="stylesheet">
<link href="https://ibrahimbilal.com/favicon.ico" rel="icon" sizes="32x32">
<link href="https://ibrahimbilal.com/favicon.ico" rel="apple-touch-icon">

@stack('styles')

<link href="{{ asset('assets/css/bs.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/app-overrides.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet">

<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<title>{{ config('app.name', 'E-Commerce Project') }} | @yield('title', 'Admin Panel')</title>

<script src="{{ asset('assets/js/async.js') }}" type="text/javascript" async></script>
