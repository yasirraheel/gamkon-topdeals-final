<!-- all games area start -->
@push('css')
    <style>
        .all-games-area .all-games-filter .filter-button-box .filter-button img {
            width: 20px;
            height: 20px;
            object-fit: cover;
        }
    </style>
@endpush

<section class="all-games-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="section-title">
            <div class="left">
                <div class="title-text wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <img src="{{ themeAsset('images/icon/fire.svg') }}" alt="Fire Icon">
                    <h2>{{ $data['title'] ?? __('Trending Items') }}</h2>
                </div>
            </div>
            <div class="right wow img-custom-anim-right" data-wow-duration="1.5s" data-wow-delay="0.2s">
                <a href="{{ route('all.listing', ['sort' => 'trending']) }}" class="view-all">{{ __('View All') }}</a>
            </div>
        </div>
        <div class="title_mt">
            <div class="row g-4 category">
                @forelse ($trendingItemListing ?? [] as $listingIndex => $listing)
                    @include('frontend::listings.include.category-block', ['listing' => $listing])
                @empty
                    <x-luminous.no-data-found type="{{ __('Trending Items') }}" />
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- all games area end -->
