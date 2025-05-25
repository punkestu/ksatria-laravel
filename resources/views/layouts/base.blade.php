<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <title>Champion</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    @include('components.alert')
    @include('components.header')
    @yield('content')
    @include('components.footer')
    <script>
        const onloads = [];
    </script>
    @stack('scripts')
    <script>
        window.addEventListener('load', () => {
            AOS.refresh();
            // scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            if (onloads.length > 0) {
                onloads.forEach((onload) => {
                    if (typeof onload === 'function') {
                        onload();
                    }
                });
            }
        });
    </script>
</body>

</html>
