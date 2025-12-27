@php
    $isRtl = isRtl(app()->getLocale());
@endphp

<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" @if ($isRtl) dir="rtl" @endif>

@include('frontend::include.__head')
@stack('css')

<body>
    <!-- Global Ad Body Code -->
    {!! \App\Models\Setting::where('name', 'ads_body_code')->value('val') !!}


    <!--Notification-->
    @include('frontend::include.__notify')

    <!-- Body main wrapper start -->
    <main class="">
        <div class="auth-area">
            <div class="auth-area-content auth-area-content-2">
                <div class="left order-2 order-xl-1">
                    <div class="auth-img">
                        <img src="{{ isset($data['right_image']) ? asset($data['right_image']) : themeAsset('images/auth/auth-img-2.png') }}"
                            alt="">
                    </div>
                </div>
                <div class="right sign-up-right order-1 order-xl-2">
                    <div class="auth-content-box {{ !Route::is('register') ? 'auth-content-box-2' : '' }}">
                        @yield('content')
                    </div>
                </div>
            </div>
            <div class="auth-element">
                <img src="{{ themeAsset('images/auth/auth-shape.svg') }}" alt="">
            </div>
        </div>
    </main>
    <!-- Body main wrapper end -->

    <!-- JS here -->
    @include('frontend::include.__script')

    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicons = document.querySelectorAll('.eyeicon');
            let passwords = document.querySelectorAll('.password-input');

            eyeicons.forEach(function(eyeicon, index) {
                eyeicon.onclick = function() {
                    if (passwords[index].type === "password") {
                        passwords[index].type = "text";
                        eyeicon.src = '{{ asset('frontend/default/images/icons/eye.svg') }}';
                    } else {
                        passwords[index].type = "password";
                        eyeicon.src = '{{ asset('frontend/default/images/icons/eye-off.svg') }}';
                    }
                };
            });

        })(jQuery);
    </script>

</body>

</html>
