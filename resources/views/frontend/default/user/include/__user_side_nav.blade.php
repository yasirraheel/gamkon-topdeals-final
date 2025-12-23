<!-- Page sidebar start-->
<div class="app-sidebar-wrapper">
    <div class="app-sidebar" id="sidebar">
        <div class="main-sidebar-header">
            <button class="toggle-sidebar">
                <span class="bar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                        <path
                            d="M8.54167 7.7513C8.70833 7.91797 8.70833 8.16797 8.54167 8.33464C8.45833 8.41797 8.33333 8.45964 8.25 8.45964C8.16667 8.45964 8.04167 8.41797 7.95833 8.33464L4.45833 4.83464L0.958334 8.33464C0.875 8.41797 0.75 8.45964 0.666667 8.45964C0.583334 8.45964 0.458333 8.41797 0.375 8.33464C0.208333 8.16797 0.208333 7.91797 0.375 7.7513L3.875 4.2513L0.375 0.751302C0.208333 0.584636 0.208333 0.334635 0.375 0.167969C0.541667 0.00130209 0.791667 0.00130209 0.958334 0.167969L4.45833 3.66797L7.95833 0.167969C8.125 0.00130209 8.375 0.00130209 8.54167 0.167969C8.70833 0.334635 8.70833 0.584636 8.54167 0.751302L5.04167 4.2513L8.54167 7.7513Z"
                            fill="white" />
                    </svg>
                </span>
            </button>
        </div>

        <div class="main-sidebar" id="simple-bar">
            <nav class="main-menu-container nav nav-pills flex-column sub-open">
                <ul class="main-menu">
                    @php
                        $isSeller = $user->is_seller;

                        // Visible parents from DB
                        $navItems = $userNavigation
                            ->filter(function ($nav) use ($isSeller) {
                                return ($nav->visible_to === 'seller' && $isSeller) ||
                                    ($nav->visible_to === 'buyer' && !$isSeller);
                            })
                            ->sortBy('position');

                        // Parents that should render a dropdown using the existing util partial
                        $dropdownParents = ['listing_manage', 'history_manage', 'payout_manage', 'settings_manage'];

                        // Icon map (lucide: prefix is added in util or inline below)
                        $iconMap = [
                            'dashboard' => 'lucide:layout-dashboard',
                            'listing_manage' => 'lucide:clipboard-list',
                            'sold_items' => 'lucide:tag',
                            'purchased_items' => 'lucide:shopping-cart',
                            'history_manage' => 'lucide:history',
                            'referral_manage' => 'lucide:user-plus',
                            'subscription_history' => 'material-symbols:next-plan-outline',
                            'packages' => 'ri:planet-line',
                            'payout_manage' => 'lucide:banknote',
                            'settings_manage' => 'lucide:settings',
                            'followers' => 'lucide:user-plus',
                            'wishlist' => 'lucide:heart',
                            'following' => 'lucide:user-plus',
                            'support_ticket' => 'lucide:headset',
                            'logout' => 'lucide:log-out',
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        @php
                            $type = $item->type;
                            $displayName = __($item->name);

                            // Determine route / url
                            $resolvedUrl = $item->url
                                ? url($item->url)
                                : match ($type) {
                                    'dashboard' => buyerSellerRoute('dashboard'),
                                    'listing_manage' => buyerSellerRoute('listing.index'),
                                    'sold_items' => buyerSellerRoute('sell.index'),
                                    'purchased_items' => buyerSellerRoute('purchase.index'),
                                    'history_manage' => buyerSellerRoute('transactions'),
                                    'referral_manage' => buyerSellerRoute('referral'),
                                    'subscription_history' => buyerSellerRoute('subscriptions.history'),
                                    'packages' => route('page', 'plans'),
                                    'payout_manage' => setting($user->user_type . '_withdraw', 'permission')
                                        ? buyerSellerRoute('payment.withdraw.index')
                                        : false,
                                    'settings_manage' => buyerSellerRoute('setting.show'),
                                    'followers' => buyerSellerRoute('follow-list.followers'),
                                    'wishlist' => buyerSellerRoute('wishlist.index'),
                                    'following' => buyerSellerRoute('follow-list.following'),
                                    'support_ticket' => buyerSellerRoute('ticket.index'),
                                    'logout' => 'javascript:void(0)',
                                    default => 'javascript:void(0)',
                                };

                            if (!$resolvedUrl) {
                                continue; // Skip if no valid URL is set
                            }

                            // Build dropdown children lists when needed
                            if (in_array($type, $dropdownParents)) {
                                $routesLists = [];

                                if ($type === 'listing_manage' && $isSeller) {
                                    $routesLists = [
                                        __('My Listing') => buyerSellerRoute('listing.index'),
                                        __('Create Listing') => buyerSellerRoute('listing.create', 'category'),
                                    ];
                                    $routeValues = 'user.listing.create'; // keeps original util behavior
                                }

                                if ($type === 'history_manage') {
                                    $routesLists = [
                                        __('Transactions') => buyerSellerRoute('transactions'),
                                        __('Withdraw History') => buyerSellerRoute('transactions', 'withdraw_all'),
                                        __('Referral History') => buyerSellerRoute(
                                            'transactions',
                                            App\Enums\TxnType::Referral->value,
                                        ),
                                    ];
                                    if ($isSeller) {
                                        $routesLists[__('Plan History')] = buyerSellerRoute(
                                            'transactions',
                                            App\Enums\TxnType::PlanPurchased->value,
                                        );
                                    }
                                    $routeValues = 'user.transactions';
                                }

                                if ($type === 'payout_manage') {
                                    $routesLists = [
                                        __('Payout') => buyerSellerRoute('payment.withdraw.index'),
                                        __('Payout Account') => buyerSellerRoute('payment.withdraw.account.index'),
                                    ];
                                    $routeValues = 'user.payment.withdraw.index';
                                }

                                if ($type === 'settings_manage') {
                                    $routesLists = [
                                        __('Account') => buyerSellerRoute('setting.show'),
                                        __('Privacy & Security') => buyerSellerRoute('setting.privacy'),
                                    ];
                                    if ($isSeller) {
                                        $routesLists[__('Coupons')] = buyerSellerRoute('coupon.index');
                                        $routesLists[__('Seller Ranking')] = buyerSellerRoute('setting.portfolio');
                                    }
                                    if (setting('kyc_verification', 'permission')) {
                                        $routesLists[__('ID Verification')] = buyerSellerRoute('kyc');
                                    }
                                    $routeValues = 'user.setting.show';
                                }
                            }
                        @endphp

                        @if ($type === 'logout')
                            <li class="slide">
                                <button class="sidebar-menu-item common-modal-button-logout w-100">
                                    <span class="side-menu-icon">
                                        <iconify-icon icon="{{ $iconMap['logout'] }}"
                                            class="logout-icon dashbaord-icon"></iconify-icon>
                                    </span>
                                    <span class="sidebar-menu-label">{{ $displayName }}</span>
                                </button>
                            </li>
                        @elseif(in_array($type, $dropdownParents) && !empty($routesLists))
                            @include('frontend::user.include.__user_side_nav_utils', [
                                'routesLists' => $routesLists,
                                'icon' => $iconMap[$type] ?? 'lucide:circle',
                                'sectionName' => $displayName,
                                'routeValues' => $routeValues ?? 'user.dashboard',
                            ])
                        @else
                            @php
                                // Active states for singles (mirroring previous logic)
                                $singleActive = match ($type) {
                                    'dashboard' => isMenuOpen('*.dashboard'),
                                    'sold_items' => isMenuOpen('seller.sell.index') || isMenuOpen('user.sell.index'),
                                    'purchased_items' => isMenuOpen('user.purchase.index'),
                                    'referral_manage' => isMenuOpen('*.referral'),
                                    'subscription_history' => isMenuOpen('seller.subscriptions.history'),
                                    'packages' => url()->current() === route('page', 'seller-plans'),
                                    'followers' => isMenuOpen('*.follow-list.followers'),
                                    'wishlist' => isMenuOpen('*.wishlist.index'),
                                    'following' => isMenuOpen('*.follow-list.following'),
                                    'support_ticket' => isMenuOpen('*.ticket.index'),
                                    default => false,
                                };
                            @endphp
                            {!! sideSingleItem($type, $displayName, $resolvedUrl, $iconMap, $singleActive) !!}
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- Page sidebar end-->
<div class="app-page-body">
    <button class="toggle-sidebar d-xl-none active">
        <span class="bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="8" viewBox="0 0 6 8" fill="none">
                <path d="M5 1L1 4L5 7" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </button>
