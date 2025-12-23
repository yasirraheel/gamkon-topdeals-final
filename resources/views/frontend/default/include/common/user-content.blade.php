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
        <h6 class="text-muted">{{ '@' . $user->username }}</h6>
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
