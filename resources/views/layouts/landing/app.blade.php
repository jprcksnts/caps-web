<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{--Favicon--}}
    <link rel="icon" href="{{ asset('img/brand/favicon.png') }}" type="image/png">
    {{--Fonts--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    {{--Styles--}}
    <link href="{{ asset('vendor/nucleo/css/nucleo.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    {{--Custom Page Styles--}}
    @yield('styles')
    <link href="{{ asset('css/argon.css?v=1.0.0') }}" rel="stylesheet" type="text/css">
</head>

<body class="bg-secondary">

<div class="main-content" id="panel">
    @include('layouts.landing.top_navigation')
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

{{--Scripts--}}
<script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
{{--Custom Page Scripts--}}
@yield('scripts')
<script src="{{ asset('js/argon.js?v=1.0.0') }}"></script>

</body>

</html>
