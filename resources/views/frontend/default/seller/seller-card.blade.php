<div class="seller-card @isset($isTwo)seller-card-2 @endisset">
    <div class="seller-image">
        <img loading="lazy" src="{{ $seller->avatar_path }}" alt="">
    </div>
    <div class="seller-content">
        <div class="top">
            <h5>{{ $seller->username }}</h5>
            <p>{{ __('Items Sold: ') }}<span>{{ $seller->total_sold ?? 0 }}</span></p>
            @if ($seller->country)
                <div class="conutry">
                    <div class="country-image">
                        <img src="{{ $seller->flag ? $seller->flag['image'] : '' }}" alt="{{ $seller->country }}">
                    </div>
                    <p>{{ $seller->country }}</p>
                </div>
            @endif
        </div>
        <div class="bottom">
            <div class="left">
                <p>{{ __('Success Rate: ') }}</p>
            </div>
            <div class="right">
                <p
                    class="success-rate {{ $seller->order_success_rate == 0 ? '' : 'success-rate-2' }} {{ match (true) {$seller->order_success_rate >= 80 => 'success',$seller->order_success_rate >= 50 => 'warning',default => 'error'} }}">
                    {{ $seller->order_success_rate ?? 0 }}%</p>
            </div>
        </div>
        <div class="action-buttons">
            <a href="{{ route('seller.details', $seller->username) }}"
                class="primary-button w-100">{{ __('View Profile') }}</a>
            @auth
                @if (!$user->is_seller)
                    <a href="#" class="fav-button seller-favorite-btn {{ isFollowing($seller) ? 'active' : '' }}"
                        data-username="{{ $seller->username }}">
                        <iconify-icon icon="grommet-icons:favorite" class="fav-icon"></iconify-icon>
                    </a>
                @endif
            @endauth
        </div>
    </div>
    @if ($seller->portfolio)
        <div class="has-popular">
            <img data-bs-toggle="tooltip" data-bs-title="{{ $seller->portfolio->portfolio_name }}" loading="lazy"
                src="{{ asset($seller->portfolio->icon) }}" alt="">
        </div>
    @endif
</div>
