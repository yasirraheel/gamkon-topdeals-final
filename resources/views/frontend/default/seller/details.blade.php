@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])
@section('title')
    {{ $seller->full_name . ' - ' . setting('site_title') }}
@endsection
@section('meta_keywords')
    {{ trim(setting('meta_keywords', 'meta')) }}
@endsection
@section('meta_description')
    {{ trim(setting('meta_description', 'meta')) }}
@endsection

@section('content')
    <!-- Seller Profile Details area start -->
    <div class="seller-profile-details-area section_space-mT">
        <div class="container">
            <div class="seller-profile-details-area-content">
                <div class="seller-profile">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-2">
                            <div class="seller-image">
                                <div class="img">
                                    <img src="{{ $seller->avatar_path }}" alt="SELLER IMAGE">
                                </div>
                                @if ($seller->portfolio)
                                    <div class="has-pro">
                                        <img data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $seller->portfolio->portfolio_name }}"
                                            src="{{ asset($seller->portfolio->icon) }}"
                                            alt="{{ $seller->portfolio->portfolio_name }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="seller-content">
                                <h5>
                                    {{ $seller->username }}
                                    @if($seller->kyc == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#3b82f6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-left: 4px;" title="{{ __('Verified Seller') }}" data-bs-toggle="tooltip">
                                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.78 4.78 4 4 0 0 1-6.74 0 4 4 0 0 1-4.78-4.78 4 4 0 0 1 0-6.74z"></path>
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                        </svg>
                                    @endif
                                </h5>
                                <p class="seller-description">{{ $seller->about }}</p>
                                <div class="seller-buttons-box">
                                    @if (auth()->check() && auth()?->id() != $seller->id)
                                        <div class="action-btns">
                                            @if (!$user->is_seller)
                                                <a href="javascript:void(0)" class="primary-button sm-btn follow-btn">
                                                    {{ isFollowing($seller) ? __('Unfollow') : __('Follow') }}
                                                </a>
                                            @endif
                                            @if ($seller->accept_profile_chat)
                                                <a href="{{ buyerSellerRoute('chat.index', $seller->username) }}"
                                                    class="primary-button sm-btn green-button">
                                                    <span>
                                                        <iconify-icon icon="hugeicons:chatting-01"
                                                            class="chat-icon"></iconify-icon>
                                                    </span>
                                                    {{ __('Chat') }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($seller->show_following_follower_list)
                                        <div class="seller-rating">
                                            <div class="followers">
                                                <h4>{{ $seller->followers()->count() }}</h4>
                                                <p>{{ __('Followers') }}</p>
                                            </div>
                                            <div class="bar"></div>
                                            <div class="following">
                                                <h4>{{ $seller->following()->count() }}</h4>
                                                <p>{{ __('Following') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="seller-stats">
                                @if ($seller->portfolio)
                                    <div class="point">
                                        <p>{{ __('Seller level') }}</p>
                                        <h6 class="level-tag">{{ $seller->portfolio->portfolio_name }}</h6>
                                    </div>
                                @endif
                                <div class="point">
                                    <p>{{ __('Items Sold') }}</p>
                                    <h6>{{ ($seller->total_sold ?? 0) . ' ' . __('Items') }}</h6>
                                </div>
                                <div class="point">
                                    <p>{{ __('Rating') }}</p>
                                    <div class="star">
                                        {{ number_format($seller->avg_rating, 1) }}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($seller->avg_rating))
                                                <img src="{{ themeAsset('images/icon/star.png') }}" alt="">
                                            @else
                                                <img src="{{ themeAsset('images/icon/empty-star.png') }}" alt="">
                                            @endif
                                        @endfor
                                        <i class="fa-solid fa-user" style="color: #6b7280; font-size: 14px; margin-left: 5px;"></i> ({{ $seller->total_reviews ?? 0 }})
                                    </div>
                                </div>
                                <div class="point">
                                    <p>{{ __('Success Rate') }}</p>
                                    <h6>{{ ($seller->order_success_rate ?? 0) . '%' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Seller Profile Details area end -->

    <!-- Seller profile-items area start -->
    <div class="seller-profile-item-area section_space-mT section_space-pB">
        <div class="container">
            <div class="common-tab">
                <div class="tab-filter" id="nav-tab" role="tablist">
                    <div class="tab-button-box">
                        <button class="profile-filter-button filter-button-2 active" id="nav-all-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                            aria-selected="true">
                            {{ __('Items') }}
                        </button>
                        @if ($seller->show_following_follower_list)
                            <button class="profile-filter-button filter-button-2" id="nav-gane-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-gane" type="button" role="tab" aria-controls="nav-gane"
                                aria-selected="false">
                                {{ __('Followers') }}
                            </button>
                            <button class="profile-filter-button filter-button-2" id="nav-software-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-software" type="button" role="tab" aria-controls="nav-software"
                                aria-selected="false">
                                {{ __('Following') }}
                            </button>
                        @endif
                    </div>
                </div>
                <div class="all-tab-content tab-content title_mt" id="nav-tabContent">
                    <div class="all common-tab-title tab-pane fade show active" id="nav-all" role="tabpanel"
                        aria-labelledby="nav-all-tab">
                        <div class="row g-4">
                            @forelse ($listings as $listing)
                                @include('frontend::listings.include.category-block', [
                                    'listing' => $listing,
                                ])
                            @empty
                                <x-luminous.no-data-found has-bg="true" type="{{ __('Items') }}" class="mt-5" />
                            @endforelse
                        </div>
                        <div class="common-pagination title_mt">
                            {{ $listings->links() }}
                        </div>
                    </div>
                    @if ($seller->show_following_follower_list)
                        <div class="games common-tab-title tab-pane fade" id="nav-gane" role="tabpanel"
                            aria-labelledby="nav-gane-tab">
                            <div class="row g-4">
                                @php
                                    $followers_list = $seller
                                        ->followers()
                                        ->paginate(perPage: 10, pageName: 'followers');
                                @endphp
                                @forelse ($followers_list as $follower)
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        @include('frontend::seller.seller-card', ['seller' => $follower])
                                    </div>
                                @empty
                                    <x-luminous.no-data-found has-bg="true" type="{{ __('Followers') }}" />
                                @endforelse
                            </div>
                            <div class="common-pagination title_mt">
                                {{ $followers_list->links() }}
                            </div>
                        </div>
                        <div class="software common-tab-title tab-pane fade" id="nav-software" role="tabpanel"
                            aria-labelledby="nav-software-tab">
                            <div class="row g-4">
                                @php
                                    $following_list = $seller
                                        ->following()
                                        ->paginate(perPage: 10, pageName: 'following');
                                @endphp
                                @forelse ($following_list as $following)
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        @include('frontend::seller.seller-card', ['seller' => $following])
                                    </div>
                                @empty
                                    <x-luminous.no-data-found has-bg="true" type="{{ __('Followings') }}" />
                                @endforelse
                            </div>
                            <div class="common-pagination title_mt">
                                {{ $following_list->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Seller profile-items area end -->
@endsection
@push('js')
    <script>
        'use strict';
        $(document).on('click', '.follow-btn', function(event) {

            event.preventDefault()

            $.ajax({
                url: "{{ route('follow.seller', $seller->username) }}",
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        if (response.action == 'added') {
                            showNotification('success',
                                '{{ __('Now you are following this seller') }}');
                            $('.follow-btn').text('{{ __('Unfollow') }}');
                        } else {
                            showNotification('error',
                                '{{ __('Now you are not following this seller') }}');
                            $('.follow-btn').text('{{ __('Follow') }}');
                        }
                    } else {
                        showNotification('error', response.message ?? 'Something went wrong!');
                    }
                },
                error: (error) => {
                    showNotification('error', 'Something went wrong!');
                }
            });
        })
    </script>
@endpush
