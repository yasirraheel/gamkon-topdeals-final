@php
    $isRtl = isRtl(app()->getLocale());
@endphp
<html lang="{{ app()->getLocale() }}" @if ($isRtl) dir="rtl" @endif>
@include('frontend::include.__head')

@stack('css')

<body class="">
    <!-- Global Ad Body Code -->
    {!! \App\Models\Setting::where('name', 'ads_body_code')->value('val') !!}
    
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    @include('frontend::include.__header')

    <div class="full-page-overlay full-page-overlay-2"></div>

    <!-- Body main wrapper start -->
    <main class="">
        @if ($user->is_seller)
            <!-- Page wrapper start-->
            <div class="page-wrapper null compact-wrapper">
                <!-- Page body start-->
                <div class="app-page-body-wrapper">
                    @include('frontend::user.include.__user_side_nav')
                    <!-- app page body contents start -->
                    <div class="app-page-full-body">
                        @yield('content')
                    </div>
                    <!-- app page body contents end -->
                </div>
                <!-- Page body end-->
            </div>
            <!-- Page wrapper end-->
        @else
            <div class="full-user-dashboard">
                @include('frontend::include.common.__user-header')
                <div class="container">
                    <div class="user-dashboard">
                        @yield('content')
                    </div>
                </div>
            </div>
        @endif
    </main>
    <!-- Body main wrapper end -->
    <!--Notification-->
    @include('frontend::include.__notify')
    <!-- JS here -->
    @include('frontend::include.__script')
    @stack('script')


</body>

</html>
