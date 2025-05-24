<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Champion</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    @include('components.header')
    @yield('content')
    @include('components.footer')
    @yield('scripts')
    <script>
        window.addEventListener('load', () => {
            AOS.refresh();
            $("#nav-opener").click(() => {
                $("#nav-slide").toggleClass("-top-full top-14");
                $("#nav-opener").toggleClass("rotate-180 rotate-0");
            });
            // scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>
