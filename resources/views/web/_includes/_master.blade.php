<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

        @yield('css')

        <title>{{ $title ?? 'GEMAH' }}</title>
    </head>
    <body>
        @include("web._includes.navbar")
        <div class="container-fluid">
            @include("web._includes.flash")
            @yield("content")
        </div>

        <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/poppers.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        @yield("scripts")
    </body>
</html>