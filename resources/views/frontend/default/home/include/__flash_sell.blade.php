@php
    if (!isset($data)) {
        $data = getLandingData('flash_sell');
    }
@endphp
@if (setting('flash_sale_status', 'flash_sale') == '1' &&
        $flashSellListing->count() > 0 &&
        now()->parse(setting('flash_sale_start_date', 'flash_sale'))->lte(now()) &&
        now()->parse(setting('flash_sale_end_date', 'flash_sale'))->gte(now()))
    @php
        $diffInSeconds = now()->parse(setting('flash_sale_end_date', 'flash_sale'))->diffInSeconds();
        $days = floor($diffInSeconds / (3600 * 24));
        $hours = floor(($diffInSeconds % (3600 * 24)) / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);
        $seconds = $diffInSeconds % 60;
        $timerText = sprintf('%02d d %02d : %02d : %02d', $days, $hours, $minutes, $seconds);
    @endphp
    <!-- flash sale section start -->
    <section class="flash-sale section_space-py {{ isset($bgClass) ? $bgClass : '' }}" id="flashSale">
        <div class="container">
            <div class="flash-sale-image-and-card">
                <div class="title-and-image">
                    <div class="title-img-box">
                        <div class="image">
                            <img loading="lazy" src="{{ asset($data['left_img']) }}" alt="FLASH SALE BANNER">
                        </div>
                        <div class="timer">
                            <div class="icon">
                                <iconify-icon icon="hugeicons:clock-01" class="clock-icon"></iconify-icon>
                            </div>
                            <p class="timer-text">{{ $timerText }}</p>
                        </div>
                        <div class="title">
                            <h2>{!! str_replace(' ', '<br>', __($data['title'])) !!}</h2>
                        </div>
                    </div>
                </div>
                <div class="flash-sale-item-cards">
                    <div class="top-part">
                        <div class="small-device-title">
                            <div class="title">
                                <h2>{{ __($data['title']) }}</h2>
                            </div>
                            <div class="timer">
                                <div class="icon">
                                    <iconify-icon icon="hugeicons:clock-01" class="clock-icon"></iconify-icon>
                                </div>
                                <p class="timer-text">{{ $timerText }}</p>
                            </div>
                        </div>
                        <div class="flash-sale-navigation-box">
                            <div class="all-swiper-navigation-btn">
                                <button class="flash-sale-swiper-prev flash-sale-swiper-btn">
                                    <iconify-icon icon="hugeicons:arrow-left-02"
                                        class="flash-sale-swiper-arrow"></iconify-icon>
                                </button>
                                <button class="flash-sale-swiper-next flash-sale-swiper-btn">
                                    <iconify-icon icon="hugeicons:arrow-right-02"
                                        class="flash-sale-swiper-arrow"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flash-sale-item has-negative-value text-black">
                        <div class="swiper myFlashSaleSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($flashSellListing as $listing)
                                    <div class="swiper-slide">
                                        <a href="{{ route('listing.details', $listing->slug) }}">
                                            <div class="flash-sale-card-new">
                                                <div class="img-box">
                                                    <img src="{{ asset($listing->thumbnail_url) }}"
                                                        alt="{{ $listing->product_name }}">
                                                </div>
                                                <div class="content-box">
                                                    <p>
                                                        <a href="{{ route('category.listing', $listing->category->slug) }}"
                                                            class="category">{{ $listing->category->name }}</a>
                                                    </p>
                                                    <a href="{{ route('listing.details', $listing->slug) }}"
                                                        class="product-title">{{ $listing->product_name }}</a>
                                                    @if ($listing->productCatalog || $listing->selected_duration || $listing->selected_plan)
                                                        <div class="d-flex gap-1 flex-wrap mt-1">
                                                            @if ($listing->productCatalog)
                                                                <span class="badge badge-sm bg-primary">{{ $listing->productCatalog->name }}</span>
                                                            @endif
                                                            @if ($listing->selected_duration)
                                                                <span class="badge badge-sm bg-warning">{{ $listing->selected_duration }}</span>
                                                            @endif
                                                            @if ($listing->selected_plan)
                                                                <span class="badge badge-sm bg-success">{{ $listing->selected_plan }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <p class="author">{{ __('By') }} <a
                                                            href="{{ route('seller.details', $listing->seller?->username ?? 404) }}">{{ $listing->seller?->username }}</a>
                                                    </p>
                                                    <div class="price-remaining">
                                                        <div class="price-discount">
                                                            <h5 class="price">
                                                                {{ $currencySymbol . $listing->final_price }}</h5>
                                                            @if ($listing->discount_value > 0)
                                                                <p class="discount">
                                                                    {{ $currencySymbol . $listing->price }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <p class="remaining">
                                                            {{ __(':quantity offers', ['quantity' => $listing->quantity]) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- flash sale section end -->
    @push('js')
        <script>
            "use strict";
            $(document).ready(function() {
                var counterEndTime = {{ $diffInSeconds }};
                var flashSaleTimer = setInterval(function() {
                    counterEndTime--;
                    var days = Math.floor(counterEndTime / (3600 * 24));
                    var hours = Math.floor((counterEndTime % (3600 * 24)) / 3600);
                    var minutes = Math.floor((counterEndTime % 3600) / 60);
                    var seconds = counterEndTime % 60;
                    var timerText = ('0' + days).slice(-2) + ' d ' + ('0' + hours).slice(-2) + ' : ' + ('0' +
                        minutes).slice(-2) + ' : ' + ('0' + seconds).slice(-2);
                    $('.timer-text').text(timerText);
                    if (counterEndTime <= 0) {
                        clearInterval(flashSaleTimer);
                        $('#flashSale').hide();
                    }
                }, 1000);
            });
        </script>
    @endpush
@endif
