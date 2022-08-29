<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/uicons-regular-rounded.css') }}">

    @yield('stylesheet')

	@php
		$rtl = is_rtl() ? '.rtl' : ''
	@endphp

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset("css/bs$rtl.min.css") }}">
    <!-- Main Css File -->
    <link rel="stylesheet" href="{{ asset("css/style$rtl.min.css") }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap">

    <title>{{ config('app.name') }} | @yield('title', 'Admin Panel')</title>

    <!-- async scripts -->
    <script src="{{ asset('js/async.js') }}" type="text/javascript" async></script>
</head>

<body>

    <aside>
        @include('admin.inc.menu')
    </aside>
    <main>
        @include('admin.inc.header')
        @yield('content')
    </main>
    <footer>
        <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
            <div class="developer">Made With <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.057"
                    viewBox="0 0 16 14.057">
                    <path id="Path_160" data-name="Path 160"
                        d="M11.66,1.917A4.265,4.265,0,0,0,8,4.116a4.265,4.265,0,0,0-3.665-2.2A4.531,4.531,0,0,0,0,6.615c0,3.03,3.189,6.339,5.864,8.583a3.315,3.315,0,0,0,4.265,0c2.675-2.244,5.864-5.553,5.864-8.583a4.531,4.531,0,0,0-4.332-4.7Z"
                        transform="translate(0.006 -1.918)" fill="#fe2b2b" />
                </svg> By <a class="link" target="_blank" href="https://ibrahimbilal.tk/">Ibrahim Bilal</a></div>
            <div class="copyright">Copyright &copy; {{ now()->year }}</div>
        </div>
    </footer>

    <!-- jQuery-->
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>

    @yield('scripts')

    <!-- Main Site JS Script-->
    <script src="{{ asset('js/script.min.js') }}" type="text/javascript"></script>
</body>

</html>
