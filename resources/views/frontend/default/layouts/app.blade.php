@php
    $isRtl = isRtl(app()->getLocale());
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if ($isRtl) dir="rtl" @endif>
@include('frontend::include.__head')


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

    @if (setting('preloader_status', 'global'))
        <div id="preloader" class="preloader">
            <svg viewBox="25 25 50 50">
                <circle r="20" cy="50" cx="50"></circle>
            </svg>
        </div>
    @endif

    @include('frontend::include.__header')


    <!-- Body main wrapper start -->
    <main class="">
        @yield('content')
    </main>
    @include('frontend::include.__footer')
    <!-- Body main wrapper end -->
    <!--Notification-->
    @include('frontend::include.__notify')
    <!-- JS here -->
    @include('frontend::include.__script')

    <!-- cookie policy section start -->
    @if (setting('gdpr_status', 'gdpr') && !Cookie::get('gdpr_cookies'))
        <div class="cookie gdpr">
            <div class="cookie-box shadow">
                <div class="cookie-text">
                    <div class="icon">
                        <img src="{{ themeAsset('images/icon/cookie-icon.svg') }}" alt="Cookie Icon">
                    </div>
                    <p>{{ setting('gdpr_text', 'gdpr') }} <a href="{{ url(setting('gdpr_button_url', 'gdpr')) }}"
                            target="_blank">{{ setting('gdpr_button_label', 'gdpr') }}</a></p>
                </div>
                <div class="cookie-buttons">
                    <button class="primary-button md-btn reject-btn border-btn-secondary"
                        data-value="rejected">{{ __('Reject') }}</button>
                    <button class="primary-button md-btn">{{ __('Accept') }}</button>
                </div>
            </div>
        </div>
    @endif
    <!-- cookie policy section end -->
    @if (setting('subscribed_user_first_order_bonus', 'subscribed_user_first_order_bonus') &&
            !Cookie::get('reject_signup_first_order_bonus') &&
            $firstOrderBonus)
        <!-- subscribe newsletter start -->
        <div class="popup-overlay subscribe-newsletter hidden" id="promoPopup">
            <div class="promo-popup-main">
                <div class="close-btn" id="closePopupBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        fill="none">
                        <path
                            d="M10.0007 11.1666L5.91732 15.25C5.76454 15.4028 5.5701 15.4791 5.33398 15.4791C5.09787 15.4791 4.90343 15.4028 4.75065 15.25C4.59787 15.0972 4.52148 14.9028 4.52148 14.6666C4.52148 14.4305 4.59787 14.2361 4.75065 14.0833L8.83398 9.99998L4.75065 5.91665C4.59787 5.76387 4.52148 5.56942 4.52148 5.33331C4.52148 5.0972 4.59787 4.90276 4.75065 4.74998C4.90343 4.5972 5.09787 4.52081 5.33398 4.52081C5.5701 4.52081 5.76454 4.5972 5.91732 4.74998L10.0007 8.83331L14.084 4.74998C14.2368 4.5972 14.4312 4.52081 14.6673 4.52081C14.9034 4.52081 15.0979 4.5972 15.2507 4.74998C15.4034 4.90276 15.4798 5.0972 15.4798 5.33331C15.4798 5.56942 15.4034 5.76387 15.2507 5.91665L11.1673 9.99998L15.2507 14.0833C15.4034 14.2361 15.4798 14.4305 15.4798 14.6666C15.4798 14.9028 15.4034 15.0972 15.2507 15.25C15.0979 15.4028 14.9034 15.4791 14.6673 15.4791C14.4312 15.4791 14.2368 15.4028 14.084 15.25L10.0007 11.1666Z"
                            fill="white"></path>
                    </svg>
                </div>
                <div class="promo-contents"
                    style="background-image: url('{{ themeAsset('images/promo/promo-bg.png') }}');">
                    <h2 class="heading">{{ setting('subscribed_user_first_order_bonus_title', 'fee') }}</h2>
                    <div class="discount">
                        {{ setting('subscribed_user_first_order_bonus_type', 'fee') == 'percentage' ? setting('subscribed_user_first_order_bonus_amount', 'fee') . '%' : setting('currency_symbol', 'fee') . setting('subscribed_user_first_order_bonus_amount', 'fee') }}
                    </div>
                    <p class="description">{{ setting('subscribed_user_first_order_bonus_message', 'fee') }}</p>
                    <form class="subscription-form" method="post" action="{{ route('subscriber') }}">
                        @csrf
                        <input type="email" class="email-input" name="email" placeholder="Enter your email"
                            required>
                        <button type="submit" class="primary-button submit-button">
                            {{ __('Subscribe Now') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            "use strict";
            window.onload = function() {
                setTimeout(function() {
                    $(".subscribe-newsletter").removeClass('hidden');
                }, 3000);
            }
        </script>
        <!-- subscribe newsletter end -->
    @endif



    <!-- scroll to top  -->
    @if (setting('back_to_top', 'scroll_to_top'))
        <button class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
            <div class="progress-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 20V4M12 4L18 10M12 4L6 10" stroke="#303030" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </button>
    @endif
    <div class="full-page-overlay"></div>

</body>

</html>
