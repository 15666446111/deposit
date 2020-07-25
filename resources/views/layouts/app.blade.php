<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="referrer" content="origin">

    <meta http-equiv="Cache-Control" content="no-store"/>

    <meta http-equiv="Pragma" content="no-cache"/>

    <meta http-equiv="Expires" content="0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->
    <link rel="stylesheet" href="https://daneden.github.io/animate.css/animate.min.css">
    <link rel="stylesheet" media="screen" href="{{ URL::asset('css/login.main.css') }}" />

    <style>.dowebok {animation-delay: .5s;-webkit-animation-delay:.5s;}</style>
</head>
<body class="animated fadeIn">

    @yield('content')
</body>
</html>
