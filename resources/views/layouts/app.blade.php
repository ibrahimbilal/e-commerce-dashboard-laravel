<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    @include('layouts.partials.head')
</head>

<body class="body-class">
    <aside>
        @include('layouts.partials.sidebar')
    </aside>
    <main>
        @include('layouts.partials.header')
        @yield('content')
    </main>
    @include('layouts.partials.footer')

    @include('layouts.partials.scripts')
</body>

</html>
