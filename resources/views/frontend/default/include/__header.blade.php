<!-- Header section start -->
<header @class([
    'header',
    'header-2' =>
        (Route::is('seller*') || Route::is('user*')) &&
        !Route::is('seller.details'),
    'sticky-header' =>
        (!Route::is('user*') && !Route::is('seller*')) ||
        Route::is('seller.details'),
])>
    <div class="has-container-fluid">
        <div class="header-full">
            <div class="left">
                <div class="logo-flag-container" style="display: flex; align-items: center; gap: 8px;">
                    <a href="{{ route('home') }}" class="logo">
                        <x-luminous.logo />
                    </a>
                    @php
                        $userLocation = getLocation();
                    @endphp
                    @if($userLocation->country_code)
                        <img src="https://flagcdn.com/w40/{{ strtolower($userLocation->country_code) }}.png" 
                             srcset="https://flagcdn.com/w80/{{ strtolower($userLocation->country_code) }}.png 2x"
                             width="30" 
                             alt="{{ $userLocation->name }}" 
                             class="country-flag" 
                             title="{{ $userLocation->name }}"
                             style="display: inline-block;">
                    @endif
                </div>
                @includeWhen(
                    !$user?->is_seller || !Route::is('seller.*') || Route::is('seller.details'),
                    'frontend::include.common.search-form')
            </div>
            <div class="middle">
                @if (!Route::is('seller.*') || Route::is('seller.details'))
                    <div class="navigation-menu">
                        <ul>
                            @foreach ($navigations as $navigation)
                                @if ($navigation->page_id == null)
                                    <li>
                                        <a href="{{ url($navigation->url) }}"
                                            @class([
                                                'active' => url()->current() == url($navigation->url),
                                            ])>{{ $navigation->tname }}</a>
                                    </li>
                                @elseif ($navigation->page->status)
                                    <li>
                                        <a href="{{ url($navigation->page->url) }}"
                                            @class([
                                                'active' => url()->current() == url($navigation->page->url),
                                            ])>{{ $navigation->tname }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="right">

                <div class="has-enable-disable-search-button">
                    <button aria-label="Search" class="mobile-search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M14 14L11.1 11.1M12.6667 7.33333C12.6667 10.2789 10.2789 12.6667 7.33333 12.6667C4.38781 12.6667 2 10.2789 2 7.33333C2 4.38781 4.38781 2 7.33333 2C10.2789 2 12.6667 4.38781 12.6667 7.33333Z"
                                stroke="#303030" stroke-width="1.28" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                @if (auth()->check())
                    <div class="notification">
                        <button aria-label="Notification"
                            class="notification-btn @if ($totalUnreadNotification > 0) active @endif">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.02 12.3476L14.9741 11.282C14.8278 11.1333 14.7473 10.9364 14.7473 10.7279V7.50586C14.7473 4.905 13.0109 2.70246 10.6365 1.99582C10.6579 1.88895 10.6692 1.77961 10.6692 1.66992C10.6692 0.74918 9.92 0 8.99926 0C8.07851 0 7.32933 0.74918 7.32933 1.66992C7.32933 1.78066 7.34023 1.88965 7.36097 1.99617C4.98722 2.70316 3.25121 4.90535 3.25121 7.50586V10.7279C3.25121 10.9364 3.1707 11.1333 3.02445 11.282L1.97855 12.3476C1.39777 12.9389 1.23605 13.7812 1.55703 14.5459C1.87765 15.3102 2.59203 15.7852 3.42101 15.7852H6.50387C6.65223 17.0307 7.7143 18 8.99926 18C10.2842 18 11.3463 17.0307 11.4946 15.7852H14.5775C15.4065 15.7852 16.1209 15.3102 16.4415 14.5459C16.7625 13.7812 16.6007 12.9389 16.02 12.3476ZM8.5598 1.66992C8.5598 1.4277 8.75703 1.23047 8.99926 1.23047C9.24148 1.23047 9.43871 1.4277 9.43871 1.66992C9.43871 1.70789 9.43379 1.74199 9.42605 1.77363C9.28508 1.76344 9.14269 1.75781 8.99926 1.75781C8.85582 1.75781 8.71344 1.76344 8.57246 1.77363C8.56473 1.74234 8.5598 1.70789 8.5598 1.66992ZM8.99926 16.7695C8.39457 16.7695 7.88656 16.3491 7.75156 15.7852H10.247C10.112 16.3491 9.60394 16.7695 8.99926 16.7695ZM15.307 14.0699C15.2592 14.1838 15.0655 14.5547 14.5775 14.5547H3.42101C2.93305 14.5547 2.73933 14.1834 2.69152 14.0699C2.64371 13.956 2.51469 13.558 2.8564 13.2096L3.90265 12.144C4.27601 11.7636 4.48168 11.2609 4.48168 10.7279V7.50586C4.48168 5.01504 6.50808 2.98828 8.99926 2.98828C11.4904 2.98828 13.5168 5.01504 13.5168 7.50586V10.7279C13.5168 11.2609 13.7225 11.7636 14.0959 12.144L15.1421 13.2096C15.4838 13.5577 15.3548 13.956 15.307 14.0699Z"
                                    fill="black"></path>
                            </svg>
                        </button>
                        <div class="notification-box">
                            <div class="notification-navigation">
                                <h4>{{ __('Notification') }}</h4>
                                <a href="{{ buyerSellerRoute('read-notification', 0) }}"
                                    class="mark-all-read">{{ __('Mark all as read') }}</a>
                            </div>
                            <div class="all-notification-list">
                                @include('frontend::include.common.notification')
                            </div>
                        </div>
                    </div>
                    <div class="chat">
                        <button aria-label="Chat" class="chat-btn @if ($unseenChatCount) active @endif">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.00074 16.725C7.6489 16.7337 6.3171 16.3982 5.13074 15.75C5.10698 15.7401 5.08149 15.735 5.05574 15.735C5.03 15.735 5.00451 15.7401 4.98074 15.75L2.33324 16.5C2.1712 16.5516 1.99813 16.5577 1.83285 16.5178C1.66756 16.4779 1.51639 16.3934 1.39576 16.2735C1.27514 16.1537 1.18968 16.0031 1.14869 15.838C1.10769 15.673 1.11273 15.4999 1.16324 15.3375L1.95824 12.675C1.97551 12.6291 1.97551 12.5785 1.95824 12.5325C1.14517 11.0465 0.820802 9.3421 1.03118 7.66128C1.24156 5.98046 1.97599 4.4086 3.13024 3.1688C4.2845 1.92899 5.79992 1.08423 7.46144 0.754408C9.12295 0.424587 10.8461 0.626466 12.3864 1.33139C13.9267 2.03631 15.2059 3.20847 16.0423 4.68149C16.8787 6.15451 17.23 7.85356 17.0461 9.53749C16.8623 11.2214 16.1528 12.8047 15.0183 14.0626C13.8837 15.3204 12.3818 16.189 10.7257 16.545C10.1583 16.663 9.58034 16.7233 9.00074 16.725ZM5.03324 14.5725C5.2559 14.5756 5.47456 14.6322 5.67074 14.7375C6.64132 15.2698 7.72519 15.5621 8.83179 15.59C9.93839 15.6179 11.0356 15.3806 12.0318 14.8979C13.028 14.4152 13.8942 13.7011 14.558 12.8154C15.2219 11.9296 15.6642 10.8978 15.8479 9.80617C16.0316 8.71457 15.9515 7.59485 15.6142 6.54055C15.2768 5.48624 14.6921 4.52797 13.9088 3.74577C13.1255 2.96358 12.1665 2.38017 11.1117 2.04429C10.0569 1.7084 8.93709 1.6298 7.84574 1.81503C6.75228 1.9967 5.71844 2.43828 4.83116 3.10265C3.94388 3.76702 3.22911 4.63474 2.74697 5.63283C2.26482 6.63093 2.02941 7.73021 2.06052 8.83822C2.09163 9.94622 2.38835 11.0306 2.92574 12C3.01024 12.1531 3.06367 12.3213 3.08298 12.4951C3.10229 12.6688 3.08708 12.8447 3.03824 13.0125L2.34074 15.33L4.65824 14.6325C4.77962 14.5942 4.90597 14.574 5.03324 14.5725Z"
                                    fill="black"></path>
                                <path
                                    d="M6 9.9375C6.51777 9.9375 6.9375 9.51777 6.9375 9C6.9375 8.48223 6.51777 8.0625 6 8.0625C5.48223 8.0625 5.0625 8.48223 5.0625 9C5.0625 9.51777 5.48223 9.9375 6 9.9375Z"
                                    fill="black"></path>
                                <path
                                    d="M9 9.9375C9.51777 9.9375 9.9375 9.51777 9.9375 9C9.9375 8.48223 9.51777 8.0625 9 8.0625C8.48223 8.0625 8.0625 8.48223 8.0625 9C8.0625 9.51777 8.48223 9.9375 9 9.9375Z"
                                    fill="black"></path>
                                <path
                                    d="M12 9.9375C12.5178 9.9375 12.9375 9.51777 12.9375 9C12.9375 8.48223 12.5178 8.0625 12 8.0625C11.4822 8.0625 11.0625 8.48223 11.0625 9C11.0625 9.51777 11.4822 9.9375 12 9.9375Z"
                                    fill="black"></path>
                            </svg>
                        </button>
                        <div class="chat-box">
                            <div class="chat-navigation">
                                <h4>{{ __('Chat') }}</h4>
                            </div>
                            @include('frontend::include.common.chat')
                            @if ($allChats->count() > 0)
                                <div class="action-btn">
                                    <a href="{{ buyerSellerRoute('chat.index') }}">{{ __('View All Chat') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="auth-language-cta">
                    <div class="auth-language-cta-inside">
                        @include('frontend::include.common.lang-switcher', ['langSwitcherClass' => ''])

                        @auth
                            <div class="auth-cta auth-cta-2">
                                <div class="start-selling">
                                    @if ($user->is_seller)
                                        <a href="{{ buyerSellerRoute('listing.create', 'category') }}"
                                            class="primary-button">{{ __('Add Listing') }}</a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="auth-btn d-none d-md-block">
                                <a href="{{ route('login') }}" class="primary-button">{{ __('Sign In') }}</a>
                            </div>
                        @endauth
                    </div>
                    @auth
                        <div class="user-box">
                            <a href="javascript:void(0)" class="user">
                                <img src="{{ auth()->user()->avatar_path ?? asset('frontend/default/images/user/user-default.png') }}"
                                    alt="AVATER IAMGE"> </a>
                            @includeWhen(auth()->check(), 'frontend::include.common.user-content')
                        </div>
                    @endauth
                    <div class="bar-button">
                        <button aria-label="Menu" class="td-offcanvas-toggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header section end -->

<!-- mobile search modal start -->
<div class="mobile-search-popup">
    <div class="container">
        <div class="logo-and-close">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset(setting('site_logo_dark', 'global')) }}" alt="LOGO">
            </a>
            <button aria-label="Close" class="close">
                <svg id="fi_2961937" height="20" viewBox="0 0 64 64" width="20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="m4.59 59.41a2 2 0 0 0 2.83 0l24.58-24.58 24.59 24.58a2 2 0 0 0 2.83-2.83l-24.59-24.58 24.58-24.59a2 2 0 0 0 -2.83-2.83l-24.58 24.59-24.59-24.58a2 2 0 0 0 -2.82 2.82l24.58 24.59-24.58 24.59a2 2 0 0 0 0 2.82z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
    <div class="search-box">
        <div class="container">
            <div class="search search-modal">
                @include('frontend::include.common.search-form', [
                    'searchFormClass' => '',
                    'fromMobileSearchModal' => true,
                ])
            </div>
        </div>
    </div>
</div>
<!-- mobile search modal end -->
<div class="td-offcanvas-overlay"></div>
<!-- offcanvas or mobilemenu part start -->
<div class="td-offcanvas">
    <div class="td-offcanvas-wrapper">
        <div class="td-offcanvas-header">
            <a href="{{ route('home') }}" class="td-offcanvas-logo">
                <img src="{{ asset(setting('site_logo', 'global')) }}" alt="{{ setting('site_title', 'global') }}">
            </a>
            @if($userLocation->country_code)
                <img src="https://flagcdn.com/w40/{{ strtolower($userLocation->country_code) }}.png" 
                     srcset="https://flagcdn.com/w80/{{ strtolower($userLocation->country_code) }}.png 2x"
                     width="30" 
                     alt="{{ $userLocation->name }}" 
                     class="country-flag ms-2" 
                     title="{{ $userLocation->name }}">
            @endif
            <div class="authentication-and-close">
                <div class="auth">
                    @auth
                        <div class="user">
                            <div class="user-box user-box-mobile">
                                <a href="javascript:void(0)" class="user">
                                    <img src="{{ auth()->user()->avatar_path ?? themeAsset('images/chat/avater-1.png') }}"
                                        alt="AVATER IAMGE">
                                </a>
                                @include('frontend::include.common.user-content')
                            </div>
                        </div>
                    @else
                        <div class="login">
                            <a href="{{ route('login') }}" class="auth-btn">{{ __('Sign In') }}</a>
                        </div>
                    @endauth
                </div>
                <div class="td-offcanvas-close">
                    <button class="td-offcanvas-close-toggle">
                        <svg id="fi_29619374" height="20" viewBox="0 0 64 64" width="20" fill="white"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="white"
                                d="m4.59 59.41a2 2 0 0 0 2.83 0l24.58-24.58 24.59 24.58a2 2 0 0 0 2.83-2.83l-24.59-24.58 24.58-24.59a2 2 0 0 0 -2.83-2.83l-24.58 24.59-24.59-24.58a2 2 0 0 0 -2.82 2.82l24.58 24.59-24.58 24.59a2 2 0 0 0 0 2.82z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="td-offcanvas-navbars">
            <div class="offcanvas-nav">
                <ul>
                    @foreach ($navigations as $navigation)
                        @if ($navigation->page->status || $navigation->page_id == null)
                            <li>
                                <a href="{{ url($navigation->url) }}"
                                    @class([
                                        'active' => url()->current() == url($navigation->url),
                                    ])>{{ $navigation->tname }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="language-switch-mobile">
                @include('frontend::include.common.lang-switcher', [
                    'langSwitcherClass' => 'language-button-mobile',
                ])
            </div>
            @if ((!auth()->check() || $user?->is_seller) && !Route::is('*.dashboard'))
                <div class="start-selling-mobile-btn">
                    <a href="{{ buyerSellerRoute('listing.create', 'category') }}"
                        class="primary-button primary-button-white primary-button-offcanvas">{{ __('Create Listing') }}</a>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- offcanvas or mobilemenu part end -->

{{-- common header & logout modal for user dash and frontend --}}

<div class="log-out-modal">
    <div class="common-modal-box common-modal-box-2">
        <div class="content">
            <div class="logout-content text-center">
                <h3>{{ __('Are you sure you want to log out?') }}</h3>
                <div class="logout-buttons">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="primary-button">{{ __('Logout') }}</button>
                    </form>
                    <button class="primary-button border-btn close">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
