<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site_title', 'global') }} - @yield('title') -
        {{ __('Subscription-Based On Demand Online Account Selling Marketplace') }}</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset(setting('site_favicon', 'global')) }}" type="image/*" />


    <!-- CSS here -->
    <link rel="stylesheet" href="{{ themeAsset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/styles.css') }}">
    @if (setting('site_animation', 'permission'))
        <link rel="stylesheet" href="{{ themeAsset('css/custom-animation.css') }}">
    @endif
    @if (Route::is('seller.*') || Route::is('user.*'))
        <link rel="stylesheet" href="{{ asset('global/css/luminous/custom.css') }}">
    @endif
    @stack('style')

    <link rel="preload" as="image" href="{{ asset(setting('site_logo', 'global')) }}">
    @stack('css')
    <style>
        body {
            height: auto;
            min-height: 100%;
            overflow-x: hidden;
        }

        :root {
            --td-secondary:
                {{ setting('primary_color', 'global') }} !important;
            @php $rgb =hexToRgb(setting('primary_color', 'global'));
        @endphp
        --td-secondary-rgb: {{ $rgb['r'] }},
        {{ $rgb['g'] }},
        {{ $rgb['b'] }} !important;
        }
    </style>
</head>
