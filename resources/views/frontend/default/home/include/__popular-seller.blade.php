<!-- popular seller start -->
@php
    $popularSeller = \App\Models\User::popular()->withCount('listings')->distinct()->get();
@endphp
@push('style')
    <style>
        .swiper-custom-buttons-2 .swiper-cusrom-btn i {
            color: rgb(112 112 112) !important;
        }
    </style>
@endpush
<!-- popular seller area start -->
<section class="popular-seller-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}" id="popularSeller">
    <div class="container">
        <div class="popular-seller-area-content">
            <div class="section-title">
                <div class="left">
                    <div class="title-text wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2>{{ $data['title'] ?? __('Popular Seller') }}</h2>
                    </div>
                </div>
                @if ($popularSeller->isNotEmpty())
                    <div class="right">
                        <div class="swiper-arrows">
                            <button class="swiper-prev swiper-btn">
                                <iconify-icon icon="hugeicons:arrow-left-02"
                                    class="arrow-left arrow-icon"></iconify-icon>
                            </button>
                            <button class="swiper-next swiper-btn">
                                <iconify-icon icon="hugeicons:arrow-right-02"
                                    class="arrow-right arrow-icon"></iconify-icon>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="popular-seller-cards title_mt">
                <div class="swiper myPopularSellerSwiper">
                    <div class="swiper-wrapper {{ $popularSeller->isEmpty() ? 'd-flex justify-content-center' : '' }}">
                        @forelse ($popularSeller as $seller)
                            <div class="swiper-slide">
                                @include('frontend::seller.seller-card', [
                                    'seller' => $seller,
                                    'fromHome' => true,
                                ])
                            </div>
                        @empty
                            <x-luminous.no-data-found type="{{ __('Popular Seller') }}" />
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- popular seller area end -->
<!-- popular seller end -->
