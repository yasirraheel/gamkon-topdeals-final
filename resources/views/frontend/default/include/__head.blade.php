<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@hasSection('seo_title') @yield('seo_title') @else {{ setting('site_title', 'global') }} - @yield('title') - {{ __('Subscription-Based On Demand Online Account Selling Marketplace') }} @endif</title>
    <meta name="description" content="@yield('meta_description', setting('meta_description', 'meta', 'TopDealsPlus is your premier subscription-based marketplace for buying and selling secure online accounts on demand. Discover exclusive deals on gaming, streaming, and premium subscriptions with instant delivery.'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('meta_keywords', 'meta'))">
    @yield('meta')
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
            @php 
                $primaryColor = setting('primary_color', 'global') ?: '#FF6229'; 
                $rgb = hexToRgb($primaryColor);
            @endphp
            --td-primary: {{ $primaryColor }} !important;
            --td-secondary: {{ $primaryColor }} !important;
            --td-primary-rgb: {{ $rgb['r'] ?? 255 }}, {{ $rgb['g'] ?? 98 }}, {{ $rgb['b'] ?? 41 }} !important;
            --td-secondary-rgb: {{ $rgb['r'] ?? 255 }}, {{ $rgb['g'] ?? 98 }}, {{ $rgb['b'] ?? 41 }} !important;
        }
    </style>
    <!-- Global Ad Head Code -->
    {!! \App\Models\Setting::where('name', 'ads_head_code')->value('val') !!}
</head>
