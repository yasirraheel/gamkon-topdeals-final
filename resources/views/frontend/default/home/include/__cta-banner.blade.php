@php
    if (!$data) {
        $data = getLandingData('cta-banner');
    }
@endphp

<section class="ads-banner-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}"
    data-background="{{ asset($data['background_image']) }}">
    <div class="container">
        <div class="ads-banner-box">
            <div class="ads-banner-box-content">
                <h2 class="wow img-custom-anim-top" data-wow-duration="1s" data-wow-delay="0.1s"
                    style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: img-anim-top;">
                    {!! highlightColor($data['title'], 'deep') !!}
                </h2>
                <div class="d-flex align-items-center gap-3 wow img-custom-anim-bottom" data-wow-duration="1s"
                    data-wow-delay="0.2s"
                    style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: img-anim-bottom;">
                    <a href="{{ $data['button_url'] }}" target="{{ $data['button_target'] }}"
                        class="primary-button xl-btn">{{ $data['button_level'] }}</a>
                    <a href="{{ $data['second_button_url'] }}" target="{{ $data['second_button_target'] }}"
                        class="primary-button xl-btn border-btn-2">{{ $data['second_button_level'] }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
