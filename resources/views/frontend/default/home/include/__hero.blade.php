@php
    if (!$data) {
        $data = getLandingData('hero');
    }
@endphp
<!-- hero area start -->
@push('css')
    <link rel="preload" as="image" href="{{ asset($data['background_image']) }}">
    <link rel="preload" as="image" href="{{ asset($data['hero_avatar']) }}">
@endpush
<section class="hero-area" data-background="{{ asset($data['background_image']) }}">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="left">
                    <div class="hero-text-container">
                        <h1>
                            {!! highlightColor($data['hero_title']) !!}
                        </h1>
                        <p>
                            {{ $data['hero_description'] }}
                        </p>
                        <div class="hero-stats">
                            <div class="positive-review">
                                <div class="left-content">
                                    <img src="{{ asset($data['hero_user']) }}" alt="User 1">
                                </div>
                                <div class="right-content">
                                    <h6>{{ $data['all_users_count'] ?? '500+' }}</h6>
                                    <p>{{ $data['all_users_text'] ?? 'All User' }}</p>
                                </div>
                            </div>
                            <div class="positive-review">
                                <div class="left-content">
                                    <img src="{{ asset($data['positive_review_icon']) }}" alt="Positive Review">
                                </div>
                                <div class="right-content">
                                    <h6>{{ $data['positive_review_count'] ?? '200+' }}</h6>
                                    <p>{{ $data['positive_review_text'] ?? 'Positive Review' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="action-button">
                            <a href="{{ $data['hero_button_url'] }}" target="{{ $data['hero_button_target'] }}"
                                class="primary-button xl-btn">
                                {{ $data['hero_button_level'] ?? 'Get Started' }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="right">
                    <div class="hero-main-img">
                        <img src="{{ asset($data['hero_avatar']) }}" alt="Hero Avatar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- hero area end -->
