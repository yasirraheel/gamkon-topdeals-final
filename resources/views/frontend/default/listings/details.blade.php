@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])
@section('title')
    {{ __($listing->product_name) . ' - ' . setting('site_title') }}
@endsection
@section('meta_keywords')
    {{ trim(setting('meta_keywords', 'meta')) }}
@endsection
@section('meta_description')
    {{ trim(setting('meta_description', 'meta')) }}
@endsection
@push('style')
    <link rel="stylesheet" href="{{ themeAsset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/all.min.css') }}">
@endpush
@section('content')
    <div class="product-details-area section_space-my">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="left">
                        <div class="common-product-design">
                            <div class="product-details">
                                <div class="top">
                                    <div class="product-breadcrumb">
                                        <h4 class="fw-bold mb-1">{{ $listing->product_name }}</h4>
                                        <ul>
                                            <li><a href="{{ route('home') }}" class="active">{{ __('Home') }}</a></li>
                                            <li>
                                                <div class="icon">
                                                    <iconify-icon icon="iconamoon:arrow-right-2"
                                                        class="arrow-right"></iconify-icon>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="{{ route('category.listing', $listing->category->slug) }}"
                                                    class="active">{{ $listing->category->name }}</a>
                                            </li>
                                            @if ($listing->subcategory_id)
                                                <li>
                                                    <div class="icon">
                                                        <iconify-icon icon="iconamoon:arrow-right-2"
                                                            class="arrow-right"></iconify-icon>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="{{ route('category.listing', $listing->subcategory->slug) }}"
                                                        class="active">{{ $listing->subcategory->name }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="price-share">
                                        <h3>{{ amountWithCurrency($listing->final_price) }}
                                            @if ($listing->discount_value > 0)
                                                <span>
                                                    <del>{{ amountWithCurrency($listing->price) }}</del>
                                                </span>
                                            @endif
                                        </h3>
                                        <div class="wish-share">
                                            <div class="wish {{ $isWishlisted ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M9 15.75L7.9125 14.775C6.65 13.6375 5.60625 12.6563 4.78125 11.8313C3.95625 11.0063 3.3 10.2655 2.8125 9.60902C2.325 8.95252 1.9845 8.34952 1.791 7.80002C1.5975 7.25052 1.5005 6.68802 1.5 6.11252C1.5 4.93752 1.89375 3.95627 2.68125 3.16877C3.46875 2.38127 4.45 1.98752 5.625 1.98752C6.275 1.98752 6.89375 2.12502 7.48125 2.40002C8.06875 2.67502 8.575 3.06252 9 3.56252C9.425 3.06252 9.93125 2.67502 10.5187 2.40002C11.1062 2.12502 11.725 1.98752 12.375 1.98752C13.55 1.98752 14.5312 2.38127 15.3187 3.16877C16.1062 3.95627 16.5 4.93752 16.5 6.11252C16.5 6.68752 16.4033 7.25002 16.2098 7.80002C16.0163 8.35002 15.6755 8.95302 15.1875 9.60902C14.6995 10.265 14.0432 11.0058 13.2188 11.8313C12.3943 12.6568 11.3505 13.638 10.0875 14.775L9 15.75Z"
                                                        fill="#303030"></path>
                                                </svg>
                                                <span
                                                    class="wishlist-text">{{ $isWishlisted ? __('Wishlisted') : __('Wishlist') }}</span>
                                            </div>
                                            <div class="share cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M12.75 16.5C12.125 16.5 11.5937 16.2812 11.1562 15.8438C10.7188 15.4063 10.5 14.875 10.5 14.25C10.5 14.175 10.5187 14 10.5562 13.725L5.2875 10.65C5.0875 10.8375 4.85625 10.9845 4.59375 11.091C4.33125 11.1975 4.05 11.2505 3.75 11.25C3.125 11.25 2.59375 11.0312 2.15625 10.5938C1.71875 10.1563 1.5 9.625 1.5 9C1.5 8.375 1.71875 7.84375 2.15625 7.40625C2.59375 6.96875 3.125 6.75 3.75 6.75C4.05 6.75 4.33125 6.80325 4.59375 6.90975C4.85625 7.01625 5.0875 7.163 5.2875 7.35L10.5562 4.275C10.5312 4.1875 10.5157 4.10325 10.5097 4.02225C10.5037 3.94125 10.5005 3.8505 10.5 3.75C10.5 3.125 10.7188 2.59375 11.1562 2.15625C11.5937 1.71875 12.125 1.5 12.75 1.5C13.375 1.5 13.9063 1.71875 14.3438 2.15625C14.7812 2.59375 15 3.125 15 3.75C15 4.375 14.7812 4.90625 14.3438 5.34375C13.9063 5.78125 13.375 6 12.75 6C12.45 6 12.1687 5.94675 11.9062 5.84025C11.6438 5.73375 11.4125 5.587 11.2125 5.4L5.94375 8.475C5.96875 8.5625 5.9845 8.647 5.991 8.7285C5.9975 8.81 6.0005 8.9005 6 9C5.9995 9.0995 5.9965 9.19025 5.991 9.27225C5.9855 9.35425 5.96975 9.4385 5.94375 9.525L11.2125 12.6C11.4125 12.4125 11.6438 12.2657 11.9062 12.1597C12.1687 12.0537 12.45 12.0005 12.75 12C13.375 12 13.9063 12.2188 14.3438 12.6562C14.7812 13.0937 15 13.625 15 14.25C15 14.875 14.7812 15.4063 14.3438 15.8438C13.9063 16.2812 13.375 16.5 12.75 16.5Z"
                                                        fill="#26B4FB"></path>
                                                </svg>
                                                {{ __('Share') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product Gallery -->
                                <div class="product-gallery">
                                    @if ($listing->is_trending)
                                        <div class="has-trending">
                                            <img src="{{ themeAsset('images/icon/flash-icon.png') }}" alt="">
                                        </div>
                                    @endif
                                    <div class="slider-container">
                                        <div class="main-slider">
                                            <div>
                                                <img src="{{ asset($listing->thumbnail) }}" alt="">
                                            </div>
                                            @foreach ($listing->images as $index => $image)
                                                <div>
                                                    <img src="{{ asset($image->image_path) }}"
                                                        alt="{{ $listing->product_name }} Slide {{ $index + 1 }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="nav-slider">
                                            <div>
                                                <img src="{{ asset($listing->thumbnail) }}" alt="">
                                            </div>
                                            @foreach ($listing->images as $index => $image)
                                                <div>
                                                    <img src="{{ asset($image->image_path) }}"
                                                        alt="{{ $listing->product_name }} Thumb {{ $index + 1 }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if ($listing->productCatalog || $listing->selected_duration || $listing->selected_plan)
                                    <div class="delivery-method-and-speed">
                                        @if ($listing->productCatalog)
                                            <div class="delivery-method">
                                                <p>{{ __('Product') }}:</p>
                                                <button class="tag-btn">
                                                    <span>
                                                        <iconify-icon icon="lucide:package"
                                                            class="tag-icon"></iconify-icon>
                                                    </span>
                                                    {{ $listing->productCatalog->name }}
                                                </button>
                                            </div>
                                        @endif
                                        @if ($listing->selected_duration)
                                            <div class="speed">
                                                <p>{{ __('Duration') }}:</p>
                                                <button class="tag-btn">
                                                    <span>
                                                        <iconify-icon icon="lucide:clock"
                                                            class="tag-icon"></iconify-icon>
                                                    </span>
                                                    {{ $listing->selected_duration }}
                                                </button>
                                            </div>
                                        @endif
                                        @if ($listing->selected_plan)
                                            <div class="speed">
                                                <p>{{ __('Plan') }}:</p>
                                                <button class="tag-btn">
                                                    <span>
                                                        <iconify-icon icon="lucide:tag"
                                                            class="tag-icon"></iconify-icon>
                                                    </span>
                                                    {{ $listing->selected_plan }}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="delivery-method-and-speed">
                                    <div class="delivery-method">
                                        <p>{{ __('Delivery Method') }}:</p>
                                        <button class="tag-btn">
                                            <span>
                                                <iconify-icon icon="icon-park-solid:flash-payment"
                                                    class="tag-icon"></iconify-icon>
                                            </span>
                                            {{ ucwords($listing->delivery_method) ?? 'Auto' }}
                                        </button>
                                    </div>
                                    <div class="speed">
                                        <p>{{ __('Delivery Speed') }}:</p>
                                        <button class="tag-btn">
                                            <span>
                                                <iconify-icon icon="material-symbols:speed-rounded"
                                                    class="tag-icon"></iconify-icon>
                                            </span>
                                            {{ $listing->delivery_method == 'auto' ? 'Instant' : $listing->delivery_speed . ' ' . $listing->delivery_speed_unit }}
                                        </button>
                                    </div>
                                </div>
                                <hr class="details-saperator">
                                <div class="product-details-box">
                                    <h4>{{ __('Details') }}:</h4>
                                    {!! $listing->description !!}
                                </div>
                                <hr class="details-saperator">
                                <div class="product-review-section section_space-mT">
                                    <div class="container">
                                        <div class="product-review-box">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4>{{ __('Product Reviews') }}
                                                </h4>
                                                @if ($listing->total_reviews > 0)
                                                    <div class="title-and-count">

                                                        <div class="review-count">
                                                            <div class="star">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if (round($listing->average_rating) >= $i)
                                                                        <img src="{{ themeAsset('images/icon/star.png') }}"
                                                                            alt="star" class="star-filled">
                                                                    @else
                                                                        <img src="{{ themeAsset('images/icon/empty-star.png') }}"
                                                                            alt="star" class="star-filled">
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <p>({{ $listing->total_reviews }}
                                                                {{ __('reviews') }})</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($listing->total_reviews > 0)
                                                <div class="review-stats mt-4 p-3 bg-light rounded">
                                                    <h6 class="mb-3">{{ __('Rating Breakdown') }}</h6>
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        @php
                                                            $ratingCount = $listing
                                                                ->approvedReviews()
                                                                ->where('rating', $i)
                                                                ->count();
                                                            $percentage =
                                                                $listing->total_reviews > 0
                                                                    ? ($ratingCount / $listing->total_reviews) * 100
                                                                    : 0;
                                                        @endphp
                                                        <div class="rating-breakdown d-flex align-items-center mb-2">
                                                            <span class="rating-label me-2">{{ $i }} ★</span>
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $percentage }}%"
                                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                            <small
                                                                class="rating-count text-muted">{{ $ratingCount }}</small>
                                                        </div>
                                                    @endfor
                                                </div>
                                            @endif

                                            <div class="review-box title_mt" id="reviewContainer">
                                                @forelse($listing->approvedReviews()->get() as $review)
                                                    <div class="review-item">
                                                        @if (auth()->check())
                                                            {{-- flag --}}
                                                            <button data-id="{{ encrypt($review->id) }}"
                                                                class="report-button common-modal-button" type="button"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                aria-label="report"
                                                                data-bs-original-title="{{ __('Flag this review') }}">
                                                                <iconify-icon icon="hugeicons:flag-03"
                                                                    class="report-icon"></iconify-icon>
                                                            </button>
                                                        @endif
                                                        <div class="left">
                                                            <div class="img-box">
                                                                <img src="{{ $review->buyer?->avatar_path ?? asset('assets/global/images/avatar.png') }}"
                                                                    alt="{{ $review->buyer?->username }}">
                                                            </div>
                                                            <div class="text">
                                                                <h5>{{ $review->buyer?->username }}</h5>
                                                                <div class="stars">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($review->rating >= $i)
                                                                            <img src="{{ themeAsset('images/icon/star.png') }}"
                                                                                alt="star" class="star-filled">
                                                                        @else
                                                                            <img src="{{ themeAsset('images/icon/empty-star.png') }}"
                                                                                alt="star" class="star-filled">
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <p class="date">
                                                                    {{ $review->created_at->format('M d, Y') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <p>{{ $review->review }}</p>
                                                            @if ($review->reply)
                                                                <div class="reply-text">
                                                                    <h5>{{ $listing->seller?->username }} @if ($listing->seller?->portfolio)
                                                                            <span>{{ $listing->seller?->portfolio?->portfolio_name }}</span>
                                                                        @endif
                                                                    </h5>
                                                                    <p class="date">
                                                                        {{ $review->reply->created_at->format('M d, Y') }}
                                                                    </p>
                                                                    <p>{{ $review->reply->review }}</p>
                                                                </div>
                                                            @elseif(auth()->check() && $review->seller_id == $user->id)
                                                                <div class="reply-box">
                                                                    <a href="javascript:void(0)"
                                                                        class="reply-button">{{ __('Reply') }}</a>
                                                                    <div class="reply-input">
                                                                        <form action="{{ route('listing.seller.reply') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input name="reply_to" type="hidden"
                                                                                name="review_id"
                                                                                value="{{ encrypt($review->id) }}">
                                                                            <div class="row g-3">
                                                                                <div class="col-12">
                                                                                    <textarea name="review" id="reply" placeholder="{{ __('Write your reply') }}"></textarea>
                                                                                </div>
                                                                                <div
                                                                                    class="col-12 d-flex justify-content-end">
                                                                                    <button
                                                                                        class="primary-button">{{ __('Send') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="no-reviews text-center py-4">
                                                        <div>
                                                            <iconify-icon icon="mdi:star-outline" class="text-muted"
                                                                style="font-size: 3rem;"></iconify-icon>
                                                        </div>
                                                        <h5 class="text-muted">{{ __('No reviews yet') }}</h5>
                                                        <p class="text-muted">
                                                            {{ __('Be the first to review this product!') }}</p>
                                                    </div>
                                                @endforelse

                                                @if ($listing->total_reviews > 5)
                                                    <div class="text-center mt-4">
                                                        <button type="button" class="border-button" id="loadMoreReviews"
                                                            data-listing-id="{{ $listing->id }}" data-offset="5">
                                                            {{ __('Load More Reviews') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right has-sticky-component">
                        <div class="game-details-right">
                            <div class="your-order-card">
                                @if (setting('flash_sale_status', 'flash_sale') == '1' &&
                                        $listing->is_flash &&
                                        now()->parse(setting('flash_sale_start_date', 'flash_sale'))->lte(now()) &&
                                        now()->parse(setting('flash_sale_end_date', 'flash_sale'))->gte(now()))
                                    <div class="timer">
                                        <div class="icon">
                                            <iconify-icon icon="hugeicons:clock-01" class="clock-icon"></iconify-icon>
                                        </div>

                                        @php
                                            $diffInSeconds = now()
                                                ->parse(setting('flash_sale_end_date', 'flash_sale'))
                                                ->diffInSeconds();
                                            $days = floor($diffInSeconds / (3600 * 24));
                                            $hours = floor(($diffInSeconds % (3600 * 24)) / 3600);
                                            $minutes = floor(($diffInSeconds % 3600) / 60);
                                            $seconds = $diffInSeconds % 60;
                                            $timerText = sprintf(
                                                '%02d d %02d : %02d : %02d',
                                                $days,
                                                $hours,
                                                $minutes,
                                                $seconds,
                                            );
                                        @endphp

                                        <p class="timer-text">{{ $timerText }}</p>
                                    </div>
                                @endif
                                <div class="price-increase-decrease">
                                    <p class="available text-center mb-3">{{ $listing->quantity }} {{ __('Available') }}
                                    </p>
                                    <form action="{{ route('buy-now') }}" method="post" id="buyNowForm">
                                        @csrf
                                        <div class="calculator-box">
                                            <div class="calculator">
                                                <input type="hidden" name="product_id" value="{{ $listing->id }}">
                                                <input type="text" id="quantity-input" name="quantity" value="1"
                                                    max="{{ $listing->quantity }}" class="form-control text-center">
                                                <button type="button" class="increase-btn calculator-btn"
                                                    id="increase-btn">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <button type="button" class="decrease-btn calculator-btn"
                                                    id="decrease-btn">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <span class="error-msg text-danger d-none"
                                                    id="invalid-error">{{ __('Please enter a valid positive number.') }}</span>
                                            </div>
                                            <p class="unit-price text-center mt-2">{{ __('Unit price') }} <span
                                                    id="unit-price">{{ amountWithCurrency($listing->final_price) }}</span>
                                            </p>
                                        </div>
                                        @if ($listing->seller?->coupons()?->exists())
                                            <div class="voucher">
                                                <p>{{ __('Do you have a coupon code?') }} <a href="javascript:void(0)"
                                                        class="apply-coupon">{{ __('Apply It') }}</a></p>
                                                <div class="coupon-input">
                                                    <input type="text" name="coupon" value="{{ old('coupon') }}"
                                                        placeholder="{{ __('Insert Voucher Code') }}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="total-price">
                                            <div class="left">
                                                <h6>{{ __('Total Price') }}:</h6>
                                            </div>
                                            <div class="right">
                                                <h6><span>{{ $currencySymbol }}</span><span
                                                        id="total-price">{{ $listing->final_price }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="buy-now">
                                            <button type="submit"
                                                class="primary-button xl-btn text-center w-100 {{ $listing->quantity == 0 ? 'primary-button-red' : '' }}"
                                                @disabled($listing->quantity == 0)>
                                                {{ $listing->quantity == 0 ? __('Out of Stock') : __('Buy Now') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="seller-details-card">
                                <div class="seller-card-box">
                                    <div class="left">
                                        <div class="img-box">
                                            <img src="{{ $listing->seller->avatar_path }}"
                                                alt="{{ $listing->seller->full_name }}">
                                        </div>
                                        <div class="text">
                                            <h3>
                                                <a
                                                    href="{{ route('seller.details', $listing->seller->username) }}">{{ $listing->seller->username }}</a>
                                                @if ($listing->seller?->portfolio)
                                                    <span>{{ $listing->seller?->portfolio?->portfolio_name }}</span>
                                                @endif
                                            </h3>
                                            <p>{{ __('Items Sold') }}: {{ $listing->seller->total_sold }}</p>
                                        </div>
                                    </div>
                                    <div class="right">
                                        @auth
                                            <a href="{{ route('follow.seller', $listing->seller->username) }}"
                                                class="border-button follow-btn">
                                                {{ $listing->seller->followers->contains(auth()->user()->id) ? __('Unfollow') : __('Follow') }}
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                                @auth
                                    @if ($listing?->seller?->accept_profile_chat)
                                        <div class="chat-seller">
                                            <a href="{{ buyerSellerRoute('chat.index', $listing->seller->username) }}"
                                                class="border-button xl-btn">
                                                <span>
                                                    <iconify-icon icon="hugeicons:chatting-01"
                                                        class="chat-icon"></iconify-icon>
                                                </span>
                                                {{ __('Chat Seller') }}
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($suggested->count())
        <div class="suggested-product-area section_space-mT section_space-py">
            <div class="container">
                <div class="section-title">
                    <div class="left">
                        <div class="title-text">
                            <img src="{{ themeAsset('images/icon/fire.svg') }}" alt="">
                            <h2 class="">{{ __('Suggested Items') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="title_mt">
                    <div class="row g-4">
                        @foreach ($suggested as $item)
                            @include('frontend::listings.include.category-block', ['listing' => $item])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="common-modal-full">
        <div class="common-modal-box">
            <div class="content">
                <div class="add-new-withdrawal">
                    <form action="{{ route('review.flag') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <input type="hidden" name="review_id" id="flag_review_id">
                            <div class="col-12">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Flag Reason') }}</label>
                                    <div class="input-field input-field-textarea2">
                                        <textarea name="flag_reason" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="modal-action-btn">
                                    <button type="submit" class="primary-button">{{ __('Send Report') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ themeAsset('js/slick.min.js') }}"></script>
    <script>
        'use strict';
        var __quantity = {{ $listing->quantity }};
        var unitPrice = {{ $listing->final_price }};
        $(document).ready(function() {
            $(document).on('click', '.price-share .share', function() {
                window.navigator.share({
                    title: 'Check out this item!',
                    url: window.location.href,
                });
            })
            $(document).on('click', '.wish-share .wish', function(event) {

                event.preventDefault()

                $.ajax({
                    url: "{{ route('addToWishlist') }}",
                    type: 'GET',
                    data: {
                        wishlist: {{ $listing->id }} ?? $(this).data('id')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.action == 'added') {
                                showNotification('success', 'Added to wishlist!');
                                $('.wishlist-text').text('{{ __('Wishlisted') }}');
                                $('.wishlist-text').addClass('text-success fw-bold');

                                $('.wish').addClass('active')
                            } else {
                                showNotification('success', 'Removed from wishlist!');
                                $('.wish').removeClass('active')
                                $('.wishlist-text').text('{{ __('Wishlist') }}').removeClass(
                                    'text-success fw-bold');
                            }
                        } else {}
                    },
                    error: (error) => {
                        showNotification('error', 'Something went wrong!');
                    }
                });
            })
            $(document).on('click', '.follow-btn', function(event) {

                event.preventDefault()

                $.ajax({
                    url: "{{ route('follow.seller', $listing->seller->username) }}",
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
                                showNotification('success',
                                    '{{ __('Now you are not following this seller') }}');
                                $('.follow-btn').text('{{ __('Follow') }}');
                            }
                        } else {
                            showNotification('error', response.message ??
                                'Something went wrong!');
                        }
                    },
                    error: (error) => {
                        showNotification('error', 'Something went wrong!');
                    }
                });
            })
            @if (setting('flash_sale_status', 'flash_sale') == '1' &&
                    $listing->is_flash &&
                    now()->parse(setting('flash_sale_start_date', 'flash_sale'))->lte(now()) &&
                    now()->parse(setting('flash_sale_end_date', 'flash_sale'))->gte(now()))

                var counterEndTime = {{ $diffInSeconds }};
                var flashSaleTimer = setInterval(function() {
                    counterEndTime--;
                    var days = Math.floor(counterEndTime / (3600 * 24));
                    var hours = Math.floor((counterEndTime % (3600 * 24)) / 3600);
                    var minutes = Math.floor((counterEndTime % 3600) / 60);
                    var seconds = counterEndTime % 60;
                    var timerText = ('0' + days).slice(-2) + ' d ' + ('0' + hours).slice(-2) + ' : ' + (
                        '0' +
                        minutes).slice(-2) + ' : ' + ('0' + seconds).slice(-2);
                    $('.timer-text').text(timerText);
                    if (counterEndTime <= 0) {
                        clearInterval(flashSaleTimer);
                        $('#flashSale').hide();
                    }
                }, 1000);
            @endif

            $(document).on('click', '.report-button', function() {
                var reviewId = $(this).data('id');
                $('#flag_review_id').val(reviewId);
            });
        });
    </script>
@endpush
