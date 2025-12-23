<!-- about section start -->
@php
    if (!$data) {
        $data = getLandingData('about');
    }
@endphp

<div class="about-us-page-area">
    <div class="top-part section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="left">
                        <h2>{{ $data['left_title'] }}ons</h2>
                        <p class="des-1">{{ $data['left_description'] }}
                        </p>
                        <div class="action-btn">
                            <a href="{{ $data['about_us_button_url'] }}" target="{{ $data['about_us_button_target'] }}"
                                class="primary-button xl-btn">{{ $data['about_us_button_level'] }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="right">
                        <div class="top-img">
                            <img src="{{ asset($data['right_top_img']) }}" alt="">
                        </div>
                        <div class="middle-img">
                            <img src="{{ asset($data['right_middle_img']) }}" alt="">
                        </div>
                        <div class="bottom-img">
                            <img src="{{ asset($data['right_bottom_img']) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="extra-pb-for-img"></div>
        <div class="company-stats">
            <div class="seller-count">
                <div class="icon">
                    <iconify-icon icon="solar:cart-bold" class="count-icon"></iconify-icon>
                </div>
                <div class="text">
                    <h4>{{ $data['right_image_level'] }}</h4>
                    <p>{{ $data['right_image_title'] }}</p>
                </div>
            </div>
            <p>{{ $data['total_seller_description'] }}</p>
        </div>
    </div>
    <div class="bottom-part section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
        <div class="container">
            {!! $data['content'] !!}
        </div>
    </div>
</div>
