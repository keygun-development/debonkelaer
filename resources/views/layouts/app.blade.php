<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pageTitle') - TC Lievelde</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="relative min-h-screen">
    @include('notify::components.notify')
    @notifyJs
    <div id="header">
        @include('partials.navigation')
        @can('isAdmin')
            @include('partials.authNavigation')
        @endcan
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="main-container">
                    {{ $header }}
                </div>
            </header>
        @endif
    </div>
    <div class="site-content" id="app">
        @yield('content')
    </div>
    <div id="footer">
        @include('partials.footer')
    </div>
</div>
</body>
