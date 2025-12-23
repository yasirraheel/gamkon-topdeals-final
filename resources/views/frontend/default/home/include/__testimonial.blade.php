@php
    if (!isset($data)) {
        $data = getLandingData('testimonials'); // Assuming a function to fetch testimonial data
    }
    $testimonials = App\Models\Testimonial::query()->where('locale', 'en')->get();
@endphp
<!-- testimonial area start -->
<section class="testimonial-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="section-title">
            <div class="left">
                <div class="title-text wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay="0.1s">
                    <h2>{!! highlightColor($data['testimonial_title']) !!}</h2>
                </div>
            </div>
            @if ($testimonials->isNotEmpty())
                <div class="right">
                    <div class="swiper-arrows">
                        <button class="testimonial-swiper-prev swiper-btn">
                            <iconify-icon icon="hugeicons:arrow-left-02" class="arrow-left arrow-icon"></iconify-icon>
                        </button>
                        <button class="testimonial-swiper-next swiper-btn">
                            <iconify-icon icon="hugeicons:arrow-right-02" class="arrow-right arrow-icon"></iconify-icon>
                        </button>
                    </div>
                </div>
            @endif
        </div>
        <div class="testimonial-swiper-box title_mt">
            <div class="swiper myTestimonialSwiper">
                <div class="swiper-wrapper {{ $testimonials->isEmpty() ? 'd-flex justify-content-center' : '' }}">
                    @forelse ($testimonials as $testimonial)
                        @php
                            $testimonial = $testimonial->translated;
                        @endphp
                        <div class="swiper-slide">
                            <div class="client-review-item">
                                <div class="client-review-box">
                                    <div class="client-review">
                                        <div class="name-and-star">
                                            <h5>{{ $testimonial->name }}</h5>
                                            <p>{{ $testimonial->designation }}</p>
                                            <div class="stars">
                                                @for ($i = 0; $i < ($testimonial->star ?? 5); $i++)
                                                    <img src="{{ themeAsset('images/icon/star.png') }}" alt="Star">
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review">
                                            <p>{{ $testimonial->message }}</p>
                                        </div>
                                        <div class="quote">
                                            <img src="{{ themeAsset('images/icon/quote.svg') }}" alt="Quote">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <x-luminous.no-data-found type="{{ __('Testimonials') }}" />
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
