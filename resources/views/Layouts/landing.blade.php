<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @yield('styles')
    <script src="https://kit.fontawesome.com/fa04600604.js" crossorigin="anonymous"></script>
    <title>@yield('title') </title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    
</head>
<body>
    <header>
        @yield('header')
    </header>
    {{--@include('Layouts.partials.menu')--}}
    @yield('contenido')
    @yield('scripts')
    <footer>
        @yield('footer')
    </footer>
</body>
</html>