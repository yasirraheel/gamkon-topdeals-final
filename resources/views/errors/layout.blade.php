<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site_title', 'global') }} - @stack('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon"/>

    <!-- CSS here -->
    <link rel="stylesheet" href="{{themeAsset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/flag-icon.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/flaticon_gamecon.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/nice-select.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/styles.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/custom.css')}}">


    @stack('style')
</head>
@inject('response', 'Illuminate\Http\Response')
<body class="">
    <main>
        <div class="error-404">
            <div class="error-404-content">
                <div class="content">
                    <h2>{{ $exception->getStatusCode() ?? 404 }}</h2>
                    <p>@stack('title')</p>
                    <div class="action-btn">
                        <a href="{{ route('home') }}" class="primary-button primary-button-inline primary-button-blue">{{ __('Back Home') }}</a>
                    </div>
                </div>
                <div class="element">
                    <div class="top-element">
                        <img src="{{ asset('global/images/error-404/error-img.png') }}" alt="">
                    </div>
                    <div class="left-element">
                        <img src="{{ asset('global/images/error-404/error-object-2.png') }}" alt="">
                    </div>
                    <div class="right-element">
                        <img src="{{ asset('global/images/error-404/error-object-1.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>


