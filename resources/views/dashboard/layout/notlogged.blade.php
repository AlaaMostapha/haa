<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __(config('app.name')) }} | @yield('title')</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('/dashboard/css/vendor.css') }}" rel="stylesheet">
        <link href="{{ mix('/dashboard/css/app.css') }}" rel="stylesheet">
        @if(app()->getLocale() === 'ar')
        <link href="{{ mix('/dashboard/css/rtl.min.css') }}" rel="stylesheet">
        @endif
    </head>

    <body class="gray-bg @if(app()->getLocale() === 'ar')rtls @endif">
        @yield('content')
    </body>
</html>
