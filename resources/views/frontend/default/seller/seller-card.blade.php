<div class="seller-card @isset($isTwo)seller-card-2 @endisset">
    <div class="seller-image">
        <img loading="lazy" src="{{ $seller->avatar_path }}" alt="">
    </div>
    <div class="seller-content">
        <div class="top">
            <h5>
                {{ $seller->username }}
                @if($seller->kyc == 1)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#3b82f6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-left: 2px;" title="{{ __('Verified Seller') }}" data-bs-toggle="tooltip">
                        <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.78 4.78 4 4 0 0 1-6.74 0 4 4 0 0 1-4.78-4.78 4 4 0 0 1 0-6.74z"></path>
                        <polyline points="9 11 12 14 22 4"></polyline>
                    </svg>
                @endif
            </h5>
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
