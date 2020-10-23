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

@guest
    @yield('content')
@else
    <body class="g-sidenav-pinned">
    @include('layouts.admin.side_navigation')

    <div id="app" class="main-content" id="panel">
        <div class="bg-indigo">
            @include('layouts.admin.top_navigation')
            @include('layouts.admin.header')
        </div>

        <div class="container-fluid mt--6">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
    </div>
    @endguest

    @include('shared.modal_reorder_alert')

    {{--Scripts--}}
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('vendor/lavalamp/js/jquery.lavalamp.min.js') }}"></script>
    <script src="{{ asset('vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
    {{--Custom Page Scripts--}}
    <script src="{{ asset('js/argon.js?v=1.0.0') }}"></script>
    <script>
        $(document).ready(function () {
            @if(session()->has('has_product_below_threshold'))
                $('#modalProductBelowThreshold').modal('show');
            @endif
        });
    </script>
    @yield('scripts')

    </body>
</html>
