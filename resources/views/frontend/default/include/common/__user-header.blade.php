<div class="user-header">
    <div class="container">
        <div class="all-user-navbar">
            <div class="left-scrollbar-button scrollbar-button">
                <iconify-icon icon="hugeicons:arrow-left-01" class="scrollbar-arrow"></iconify-icon>
            </div>
            <ul>
                @php
                    $isSeller = $user->is_seller;

                    // Filter parent items by visibility
                    $navItems = $userNavigation->filter(function ($nav) use ($isSeller) {
                        return ($nav->visible_to === 'seller' && $isSeller) ||
                            ($nav->visible_to === 'buyer' && !$isSeller);
                    });

                    // Parent config (icons + base route + extra active conditions)
                    $parentMap = [
                        'dashboard' => [
                            'icon' => 'material-symbols:dashboard-outline-rounded',
                            'route' => buyerSellerRoute('dashboard'),
                            'active' => isMenuOpen('user.dashboard'),
                        ],
                        'listing_manage' => [
                            'icon' => 'material-symbols:list-alt-outline',
                            'route' => buyerSellerRoute('listing.index'),
                            'active' => isMenuOpen('user.listing.index') || isMenuOpen('user.listing.create'),
                        ],
                        'sold_items' => [
                            'icon' => 'material-symbols:shopping-bag-outline',
                            'route' => buyerSellerRoute('sell.index'),
                            'active' => isMenuOpen('user.sell.index'),
                        ],
                        'purchased_items' => [
                            'icon' => 'material-symbols:shopping-cart-outline-rounded',
                            'route' => buyerSellerRoute('purchase.index'),
                            'active' => isMenuOpen('user.purchase.index'),
                        ],
                        'history_manage' => [
                            'icon' => 'material-symbols:history-rounded',
                            'route' => buyerSellerRoute('transactions'),
                            'active' =>
                                isMenuOpen('user.transactions') ||
                                isMenuOpen('user.transactions.withdraw_all') ||
                                isMenuOpen('user.transactions.referral'),
                        ],
                        'referral_manage' => [
                            'icon' => 'material-symbols:alt-route-rounded',
                            'route' => buyerSellerRoute('referral'),
                            'active' => isMenuOpen('*.referral') || isMenuOpen('*.referral.tree'),
                        ],
                        'subscription_history' => [
                            'icon' => 'material-symbols:next-plan-outline',
                            'route' => buyerSellerRoute('subscriptions.history'),
                            'active' => isMenuOpen('seller.subscriptions.history'),
                        ],

                        'payout_manage' => [
                            'icon' => 'material-symbols:money-bag-outline-rounded',
                            'route' => buyerSellerRoute('payment.withdraw.index'),
                            'active' =>
                                isMenuOpen('user.payment.withdraw.index') ||
                                isMenuOpen('user.payment.withdraw.account.index'),
                            'disabled' => setting($user->user_type . '_withdraw', 'permission') ? false : true, // Fixed typo from 'disabaled' to 'disabled'
                        ],
                        'settings_manage' => [
                            'icon' => 'material-symbols:settings-alert-outline',
                            'route' => buyerSellerRoute('setting.show'),
                            'active' => isMenuOpen('*.setting.*') || isMenuOpen('*.kyc'),
                        ],
                        'followers' => [
                            'icon' => 'lucide:user-plus',
                            'route' => buyerSellerRoute('follow-list.followers'),
                            'active' => isMenuOpen('seller.follow-list.followers'),
                        ],
                        'wishlist' => [
                            'icon' => 'lucide:heart',
                            'route' => buyerSellerRoute('wishlist.index'),
                            'active' => isMenuOpen('user.wishlist.index'),
                        ],
                        'following' => [
                            'icon' => 'lucide:user-plus',
                            'route' => buyerSellerRoute('follow-list.following'),
                            'active' => isMenuOpen('user.follow-list.following'),
                        ],
                        'support_ticket' => [
                            'icon' => 'material-symbols:chat-outline',
                            'route' => buyerSellerRoute('ticket.index'),
                            'active' => isMenuOpen('user.ticket.index'),
                        ],
                        'logout' => [
                            'icon' => 'lucide:log-out',
                            'route' => 'javascript:void(0)',
                            'active' => false,
                            'logout' => true,
                        ],
                    ];
                    // Child (dropdown) definitions generated on-the-fly (only parent stored in DB)
                    $childMap = [
                        'listing_manage' => $isSeller
                            ? [
                                [
                                    'name' => __('My Listing'),
                                    'route' => buyerSellerRoute('listing.index'),
                                    'active' => isMenuOpen('user.listing.index'),
                                ],
                                [
                                    'name' => __('Create Listing'),
                                    'route' => buyerSellerRoute('listing.create', 'category'),
                                    'active' => isMenuOpen('user.listing.create'),
                                ],
                            ]
                            : [],
                        'history_manage' => array_filter([
                            [
                                'name' => __('Transactions'),
                                'route' => buyerSellerRoute('transactions'),
                                'active' => isMenuOpen('user.transactions'),
                            ],
                            [
                                'name' => __('Withdraw History'),
                                'route' => buyerSellerRoute('transactions', 'withdraw_all'),
                                'active' => isMenuOpen('user.transactions.withdraw_all'),
                            ],
                            [
                                'name' => __('Referral History'),
                                'route' => buyerSellerRoute('transactions', App\Enums\TxnType::Referral->value),
                                'active' => isMenuOpen('user.transactions.referral'),
                            ],
                            $isSeller
                                ? [
                                    'name' => __('Plan History'),
                                    'route' => buyerSellerRoute(
                                        'transactions',
                                        App\Enums\TxnType::PlanPurchased->value,
                                    ),
                                    'active' => request()->is('*plan*'),
                                ]
                                : null,
                        ]),
                        'referral_manage' => [
                            [
                                'name' => __('Referral'),
                                'route' => buyerSellerRoute('referral'),
                                'active' => Route::is('*.referral'),
                            ],
                            [
                                'name' => __('Referral Tree'),
                                'route' => buyerSellerRoute('referral.tree'),
                                'active' => Route::is('*.referral.tree'),
                            ],
                        ],
                        'payout_manage' => [
                            [
                                'name' => __('Payout'),
                                'route' => buyerSellerRoute('payment.withdraw.index'),
                                'active' => isMenuOpen('user.payment.withdraw.index'),
                            ],
                            [
                                'name' => __('Payout Account'),
                                'route' => buyerSellerRoute('payment.withdraw.account.index'),
                                'active' => isMenuOpen('user.payment.withdraw.account.index'),
                            ],
                        ],
                        'settings_manage' => array_filter([
                            [
                                'name' => __('Account'),
                                'route' => buyerSellerRoute('setting.show'),
                                'active' => isMenuOpen('*.setting.show'),
                            ],
                            [
                                'name' => __('Privacy & Security'),
                                'route' => buyerSellerRoute('setting.privacy'),
                                'active' => isMenuOpen('*.setting.privacy'),
                            ],
                            setting('kyc_verification', 'permission')
                                ? [
                                    'name' => __('ID Verification'),
                                    'route' => buyerSellerRoute('kyc'),
                                    'active' => isMenuOpen('*.kyc'),
                                ]
                                : null,
                        ]),
                    ];
                @endphp


                @foreach ($navItems as $item)
                    @php
                        $cfg = $parentMap[$item->type] ?? null;
                        if (!$cfg || (isset($cfg['disabled']) && $cfg['disabled'])) {
                            continue;
                        } // Fixed variable name from $cgf to $cfg
                        $children = $childMap[$item->type] ?? [];
                        $hasChildren = count($children) > 0;
                        // If url column set, use that instead of mapped route
                        $href = $item->url ? url($item->url) : $cfg['route'] ?? 'javascript:void(0)';
                        $isActive = $cfg['active'] || collect($children)->contains(fn($c) => $c['active']);
                        $activeClass = $isActive ? 'active' : '';
                        $isLogout = $cfg['logout'] ?? false;
                    @endphp

                    <li>
                        @if ($isLogout)
                            <button class="user-header-link {{ $activeClass }} common-modal-button-logout">
                                <span class="icon-and-text">
                                    <span class="icon">
                                        <iconify-icon icon="{{ $cfg['icon'] }}" class="user-header-icon"></iconify-icon>
                                    </span>
                                    <span class="text">{{ __($item->name) }}</span>
                                </span>
                            </button>
                        @else
                            <a @class([
                                'user-header-link',
                                'has-dropdown' => $hasChildren,
                                $activeClass,
                            ]) href="{{ $hasChildren ? 'javascript:void(0)' : $href }}">
                                <span class="icon-and-text">
                                    <span class="icon">
                                        <iconify-icon icon="{{ $cfg['icon'] }}"
                                            class="user-header-icon"></iconify-icon>
                                    </span>
                                    <span class="text">{{ __($item->name) }}</span>
                                </span>
                                @if ($hasChildren)
                                    <span class="dropdown-indicator">
                                        <iconify-icon icon="material-symbols:keyboard-arrow-down-rounded"
                                            class="user-header-dropdown-icon"></iconify-icon>
                                    </span>
                                @endif
                            </a>
                            @if ($hasChildren)
                                <ul class="sub-menu">
                                    @foreach ($children as $child)
                                        <li>
                                            <a @class(['active' => $child['active']])
                                                href="{{ $child['route'] }}">{{ $child['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="right-scrollbar-button scrollbar-button">
                <iconify-icon icon="hugeicons:arrow-right-01" class="scrollbar-arrow"></iconify-icon>
            </div>
        </div>
    </div>
</div>
