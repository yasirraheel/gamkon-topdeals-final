<!-- about us area start -->
@php
    $data = new \Illuminate\Support\Fluent(json_decode(getLandingData('about-us', 'both')['data'], true));
@endphp
<section class="about-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="about-area-full">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="left">
                        <h2>{{ $data['title'] }}</h2>
                        <p>{{ $data['description'] }}</p>
                        <div class="action-button">
                            <a href="{{ $data['button_url'] }}" target="{{ $data['button_target'] }}"
                                class="primary-button xl-btn">{{ $data['button_level'] }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right">
                        <div class="about-img">
                            <img src="{{ asset($data['right_img']) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about us area end -->
