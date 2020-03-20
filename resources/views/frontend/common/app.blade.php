<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __(config('app.name')) }} | @yield('title')</title>

        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @section('styles')
        <!-- Css Files -->

        <link href="{{ mix('/frontend/css/app.min.css') }}" rel="stylesheet">
        <link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
                @show

        <!-- Favicons -->
        <link rel="shortcut icon" href="{{ asset('/frontend/images/faveicon.png') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    </head>

    <body>

        <div id="loading">
            <div class="loading">
            </div>
        </div>

        <div class="wrapper col-xs-12">

            @yield('header')

            <main class="main-content col-xs-12">
                @yield('content')
            </main>

            @yield('footer')

            <div class="toTop col-xs-12 text-center">
                <i class="fa fa-angle-up"></i>
            </div>
        </div>

        @section('scripts')
            <script src="{{ mix('/frontend/js/app.min.js') }}" type="text/javascript"></script>
        @show
    </body>
</html>
