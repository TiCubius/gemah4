<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ "Documentation - " . $title ?? "Index" }}</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{ asset("assets/css/simplemde.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/css/docs.css")  }}">
    </head>

    <body>

        @include("docs._includes.sidebar")

        <section id="main">
            @yield("content")
        </section>

        <script src="{{ asset("assets/js/jquery-3.3.1.min.js") }}"></script>
        <script src="{{ asset("assets/js/simplemde.min.js") }}"></script>
        @yield("scripts")
    </body>
</html>
