@php
    $landingContents = getLandingContents('about-stats');

    if (!$data) {
        $data = getLandingData('about-stats');
    }
@endphp
<!-- about stats area start -->
<section class="about-stats-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="about-stats-area-content">
            <div class="all-stats-card">
                <div class="row g-4">
                    @foreach ($landingContents as $content)
                        <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                            <div class="stats-card">
                                <div class="icon">
                                    <img src="{{ asset($content->icon) }}" alt="">
                                </div>
                                <h2 class="count" data-count="{{ preg_replace('/[^0-9]/', '', $content->title) }}">
                                    <span
                                        class="count-number">{{ preg_replace('/[^0-9]/', '', $content->title) }}</span>
                                    <span class="count-suffix">{{ preg_replace('/[0-9]/', '', $content->title) }}</span>
                                </h2>
                                <p>{{ $content->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about stats area end -->
