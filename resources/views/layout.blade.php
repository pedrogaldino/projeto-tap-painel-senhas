<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Caller</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @stack('head')
    </head>
    <body>
        <div id="app" style="margin-top: 80px;">
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
