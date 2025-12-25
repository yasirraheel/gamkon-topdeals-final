<div class="user-content">
    <div class="user-box-content">
        <div class="title">
            <h5>{{ $user->full_name }}</h5>
            @if ($user->portfolio)
                <a href="{{ route('seller.setting.portfolio') }}" class="badge-icon"><img
                        src="{{ asset($user->portfolio->icon) }}" alt="" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="{{ $user->portfolio->portfolio_name }}">
                </a>
            @endif
        </div>
        <h6 class="text-muted">
            {{ '@' . $user->username }}
            @if($user->kyc == 1)
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#3b82f6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-left: 2px;" title="{{ __('Verified Seller') }}" data-bs-toggle="tooltip">
                    <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.78 4.78 4 4 0 0 1-6.74 0 4 4 0 0 1-4.78-4.78 4 4 0 0 1 0-6.74z"></path>
                    <polyline points="9 11 12 14 22 4"></polyline>
                </svg>
            @endif
        </h6>
    </div>
    @if (setting($user->user_type . '_deposit', 'permission') && $user->deposit_status)
        <div class="topup">
            <h5>{{ __(':type Balance', ['type' => $user->is_seller ? '' : 'Topup']) }}:
                {{ $currencySymbol . ($user->is_seller ? auth()->user()->balance : auth()->user()->topup_balance) }}
            </h5>
            <a href="{{ buyerSellerRoute($user->is_seller ? 'deposit.index' : 'topup.index') }}"
                class="topup-btn">{{ __($user->is_seller ? 'Deposit' : 'Top Up') }}</a>
        </div>
    @endif
    <div class="content">
        <ul>
            <li>
                <a href="{{ buyerSellerRoute('dashboard') }}" class="{{ isMenuOpen('*.dashboard') }}">
                    <span class="icon">
                        <img src="{{ themeAsset('images/icon/overview.svg') }}" alt="">
                    </span>
                    <span class="text">{{ __('Dashboard') }}</span>
                </a>
            </li>
            @if ($user->is_seller)
                <li>
                    <a href="{{ buyerSellerRoute('sell.index') }}" class="{{ isMenuOpen('*.sell.index') }}">
                        <span class="icon">
                            <img src="{{ themeAsset('images/icon/selling.svg') }}" alt="">
                        </span>
                        <span class="text">{{ __('Selling') }}</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ buyerSellerRoute('purchase.index') }}" class="{{ isMenuOpen('*.purchase.index') }}">
                        <span class="icon">
                            <img src="{{ themeAsset('images/icon/purchase.svg') }}" alt="">
                        </span>
                        <span class="text">{{ __('Purchased Items') }}</span>
                    </a>
                </li>

                {{-- following --}}
                <li>
                    <a href="{{ buyerSellerRoute('follow-list.following') }}"
                        class="{{ isMenuOpen('*.follow-list.following') }}">
                        <span class="icon">
                            <img src="{{ themeAsset('images/icon/following.svg') }}" alt="">
                        </span>
                        <span class="text">{{ __('Following') }}</span>
                    </a>
                </li>
                {{-- wishlist --}}
                <li>
                    <a href="{{ buyerSellerRoute('wishlist.index') }}" class="{{ isMenuOpen('*.wishlist.index') }}">
                        <span class="icon">
                            <img src="{{ themeAsset('images/icon/wishlist.svg') }}" alt="">
                        </span>
                        <span class="text">{{ __('Wishlist') }}</span>
                    </a>
                </li>
            @endif
            {{-- chat --}}
            <li>
                <a href="{{ buyerSellerRoute('chat.index') }}" class="{{ isMenuOpen('*.chat.index') }}">
                    <span class="icon">
                        <img src="{{ themeAsset('images/icon/chat.svg') }}" alt="">
                    </span>
                    <span class="text">{{ __('Chat') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ buyerSellerRoute('referral') }}" class="{{ isMenuOpen('*.referral') }}">
                    <span class="icon">
                        <img src="{{ themeAsset('images/icon/referral.svg') }}" alt="">
                    </span>
                    <span class="text">{{ __('Referral Program') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ buyerSellerRoute('setting.show') }}" class="{{ isMenuOpen('*.setting.show') }}">
                    <span class="icon">
                        <img src="{{ themeAsset('images/icon/settings.svg') }}" alt="">
                    </span>
                    <span class="text">{{ __('Settings') }}</span>
                </a>
            </li>
            <li>
                <a class="logout-modal common-modal-button-logout" href="javascript:void(0)">
                    <span class="icon">
                        <img src="{{ themeAsset('images/icon/logout.svg') }}" alt="">
                    </span>
                    <span class="text">{{ __('Logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
