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
            {{-- Breadcrumb --}}
            <div class="mb-3">
                <a href="{{ route('home') }}" style="color: #6b7280; font-size: 14px;">
                    <iconify-icon icon="iconamoon:arrow-left-2" style="vertical-align: middle;"></iconify-icon> {{ __('Back to all offers') }}
                </a>
            </div>

            <div class="row g-4">
                {{-- Left Side: Image + Info --}}
                <div class="col-lg-7">
                    <div style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h2 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 24px;">
                            {{ $listing->product_name }}
                        </h2>

                        <div style="display: flex; gap: 24px; margin-bottom: 30px;">
                            {{-- Product Thumbnail --}}
                            <div style="flex-shrink: 0;">
                                <div style="width: 160px; height: 160px; border-radius: 12px; overflow: hidden; background: #000;">
                                    <img src="{{ asset($listing->thumbnail) }}" alt="{{ $listing->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>

                            {{-- Product Details List --}}
                            <div style="flex: 1;">
                                @php
                                    $sharingMethod = null;
                                    if ($listing->productCatalog && !empty($listing->productCatalog->sharing_methods)) {
                                        $methods = $listing->productCatalog->sharing_methods;
                                        $sharingMethod = is_array($methods) ? ($methods[0] ?? null) : $methods;
                                    }
                                @endphp

                                {{-- Row 1: Can be activated in + Sharing Method --}}
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                                    {{-- Can be activated in --}}
                                    <div style="display: flex; gap: 8px;">
                                        <div style="flex-shrink: 0;">
                                            <iconify-icon icon="lucide:check-circle" style="font-size: 18px; color: #10b981;"></iconify-icon>
                                        </div>
                                        <div>
                                            <p style="font-size: 12px; color: #9ca3af; margin: 0; margin-bottom: 2px;">{{ __('Can be activated in') }}</p>
                                            <p style="font-size: 13px; color: #111827; margin: 0; font-weight: 600;">Pakistan</p>
                                            <a href="#" style="font-size: 11px; color: #3b82f6; text-decoration: none;">{{ __('Check region restrictions') }}</a>
                                        </div>
                                    </div>

                                    {{-- Sharing Method --}}
                                    @if ($sharingMethod || $listing->selected_plan)
                                        <div style="display: flex; gap: 8px;">
                                            <div style="flex-shrink: 0;">
                                                <iconify-icon icon="lucide:user-check" style="font-size: 18px; color: #6b7280;"></iconify-icon>
                                            </div>
                                            <div>
                                                <p style="font-size: 12px; color: #9ca3af; margin: 0; margin-bottom: 2px;">{{ __('Sharing Method') }}</p>
                                                <p style="font-size: 13px; color: #111827; margin: 0; font-weight: 600;">{{ $sharingMethod ?? $listing->selected_plan }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Row 2: Supported devices + Duration --}}
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                    {{-- Supported devices --}}
                                    <div style="display: flex; gap: 8px;">
                                        <div style="flex-shrink: 0;">
                                            <iconify-icon icon="lucide:monitor" style="font-size: 18px; color: #6b7280;"></iconify-icon>
                                        </div>
                                        <div>
                                            <p style="font-size: 12px; color: #9ca3af; margin: 0; margin-bottom: 2px;">{{ __('Supported devices') }}</p>
                                            <p style="font-size: 13px; color: #111827; margin: 0; font-weight: 600;">PC, Mac</p>
                                        </div>
                                    </div>

                                    {{-- Duration --}}
                                    @if ($listing->selected_duration)
                                        <div style="display: flex; gap: 8px;">
                                            <div style="flex-shrink: 0;">
                                                <iconify-icon icon="lucide:clock" style="font-size: 18px; color: #6b7280;"></iconify-icon>
                                            </div>
                                            <div>
                                                <p style="font-size: 12px; color: #9ca3af; margin: 0; margin-bottom: 2px;">{{ __('Duration') }}</p>
                                                <p style="font-size: 13px; color: #111827; margin: 0; font-weight: 600;">{{ $listing->selected_duration }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Important Notice --}}
                        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 8px; padding: 16px;">
                            <div style="display: flex; gap: 12px; align-items: start;">
                                <iconify-icon icon="lucide:info" style="font-size: 20px; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></iconify-icon>
                                <div>
                                    <h6 style="color: #1e40af; font-size: 14px; font-weight: 700; margin: 0 0 8px 0;">{{ __('Important Notice') }}</h6>
                                    <p style="color: #1e3a8a; font-size: 13px; line-height: 1.6; margin: 0;">
                                        {{ __('This item/service is offered by independent sellers on') }} {{ setting('site_title', 'global') }}. {{ __('If you have any questions or issues, please contact the seller directly.') }}
                                    </p>
                                    <p style="color: #1e3a8a; font-size: 13px; line-height: 1.6; margin: 8px 0 0 0;">
                                        {{ __('Friendly reminder: Official') }} {{ setting('site_title', 'global') }} {{ __('coupons can be used on standard orders, but not on Marketplace purchases.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Offer Description --}}
                    <div style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 20px;">
                        <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">{{ __('Offer description') }}</h4>
                        <div style="color: #4b5563; font-size: 14px; line-height: 1.8;">
                            {!! $listing->description !!}
                        </div>
                    </div>

                    {{-- Explore More Section --}}
                    @if ($suggested->count())
                        <div style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 20px;">
                            <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">{{ __('Explore More') }}</h4>
                            <div class="row g-3">
                                @foreach ($suggested->take(4) as $item)
                                    <div class="col-md-6">
                                        <a href="{{ route('listing.details', $item->slug) }}" style="text-decoration: none;">
                                            <div style="display: flex; gap: 12px; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all 0.3s; background: #fff;">
                                                <div style="flex-shrink: 0;">
                                                    <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->product_name }}" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">
                                                </div>
                                                <div style="flex: 1; min-width: 0;">
                                                    <h6 style="font-size: 14px; font-weight: 600; color: #111827; margin: 0 0 6px 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->product_name }}</h6>
                                                    <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 6px;">
                                                        <iconify-icon icon="lucide:star" style="font-size: 12px; color: #fbbf24;"></iconify-icon>
                                                        <span style="font-size: 12px; color: #6b7280; font-weight: 600;">{{ number_format($item->average_rating, 1) }}</span>
                                                        <span style="font-size: 12px; color: #9ca3af;">({{ $item->total_reviews }})</span>
                                                    </div>
                                                    <div style="display: flex; align-items: baseline; gap: 6px;">
                                                        <span style="font-size: 16px; color: #ef4444; font-weight: 700;">{{ setting('currency_symbol', 'global') }}{{ number_format($item->final_price, 2) }}</span>
                                                        @if ($item->discount_value > 0)
                                                            <span style="font-size: 12px; color: #9ca3af; text-decoration: line-through;">{{ setting('currency_symbol', 'global') }}{{ number_format($item->price, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Side: Pricing + Actions --}}
                <div class="col-lg-5">
                    <div style="position: sticky; top: 20px;">
                        <div style="background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            {{-- Delivery Times --}}
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <iconify-icon icon="lucide:clock" style="font-size: 16px; color: #6b7280;"></iconify-icon>
                                        <span style="font-size: 14px; color: #6b7280;">{{ __('Guaranteed Delivery time') }}</span>
                                    </div>
                                    <span style="font-size: 14px; color: #111827; font-weight: 600;">{{ $listing->delivery_method == 'auto' ? '5 minutes' : ($listing->delivery_speed . ' ' . $listing->delivery_speed_unit) }}</span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <iconify-icon icon="lucide:zap" style="font-size: 16px; color: #6b7280;"></iconify-icon>
                                        <span style="font-size: 14px; color: #6b7280;">{{ __('Instant delivery time') }}</span>
                                    </div>
                                    <span style="font-size: 14px; color: #111827; font-weight: 600;">{{ $listing->delivery_method == 'auto' ? 'Instant' : '30s' }}</span>
                                </div>

                                @if ($listing->guarantee_period)
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <iconify-icon icon="lucide:shield-check" style="font-size: 16px; color: #6b7280;"></iconify-icon>
                                            <span style="font-size: 14px; color: #6b7280;">{{ __('Warranty Period') }}</span>
                                        </div>
                                        <span style="font-size: 14px; color: #111827; font-weight: 600;">{{ $listing->guarantee_period }}</span>
                                    </div>
                                @endif
                            </div>

                            <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">

                            {{-- Total Price --}}
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <span style="font-size: 16px; color: #6b7280; font-weight: 600;">{{ __('Total') }}:</span>
                                <div style="text-align: right;">
                                    <span style="font-size: 24px; color: #ef4444; font-weight: 700;">{{ setting('currency_symbol', 'global') }}{{ number_format($listing->final_price, 2) }}</span>
                                    @if ($listing->discount_value > 0)
                                        <div>
                                            <span style="font-size: 14px; color: #9ca3af; text-decoration: line-through;">{{ setting('currency_symbol', 'global') }}{{ number_format($listing->price, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Buy Now Button --}}
                            <button onclick="document.getElementById('buyNowForm').submit();" 
                                    style="width: 100%; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 8px; padding: 14px; font-size: 16px; font-weight: 700; cursor: pointer; margin-bottom: 16px; transition: all 0.3s;">
                                {{ __('Buy Now') }}
                            </button>

                            {{-- Guarantees --}}
                            <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #6b7280; cursor: pointer;" class="common-modal-button refund-guarantee-btn">
                                    <iconify-icon icon="lucide:shield-check" style="font-size: 16px; color: #10b981;"></iconify-icon>
                                    <span>{{ __('Refund Guarantee') }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #6b7280;">
                                    <iconify-icon icon="lucide:truck" style="font-size: 16px; color: #10b981;"></iconify-icon>
                                    <span>{{ __('Express Checkout') }}</span>
                                </div>
                            </div>

                            <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">

                            {{-- Seller Info --}}
                            <div>
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                                    <img src="{{ $listing->seller->avatar_path ?? themeAsset('images/user/user-default.png') }}" 
                                         alt="{{ $listing->seller->username }}" 
                                         style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                                    <div style="flex: 1;">
                                        <a href="{{ route('seller.details', $listing->seller->username) }}" style="font-size: 15px; color: #111827; font-weight: 600; text-decoration: none; display: block;">
                                            {{ $listing->seller->username }}
                                        </a>
                                        <div style="display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                            <iconify-icon icon="lucide:star" style="font-size: 14px; color: #fbbf24;"></iconify-icon>
                                            <span style="font-size: 13px; color: #6b7280; font-weight: 600;">{{ number_format($listing->average_rating, 1) }}</span>
                                            <span style="font-size: 13px; color: #9ca3af;">({{ $listing->total_reviews }})</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Reviews / Recent Feedback --}}
                                <div>
                                    @php
                                        $reviews = $listing->approvedReviews()->latest()->take(5)->get();
                                        $totalReviews = $listing->approvedReviews()->count();
                                    @endphp
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                        <h6 style="font-size: 14px; font-weight: 600; color: #111827; margin: 0;">{{ __('Product Reviews') }}</h6>
                                        @if ($totalReviews > 0)
                                            <div style="display: flex; align-items: center; gap: 4px;">
                                                <iconify-icon icon="lucide:star" style="font-size: 14px; color: #fbbf24;"></iconify-icon>
                                                <span style="font-size: 13px; font-weight: 600;">{{ number_format($listing->average_rating, 1) }}</span>
                                                <span style="font-size: 12px; color: #9ca3af;">({{ $totalReviews }})</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($reviews->count() > 0)
                                        <div id="reviewContainer">
                                            @foreach($reviews as $review)
                                                @if($review->buyer)
                                                <div style="background: #f9fafb; border-radius: 8px; padding: 12px; margin-bottom: 10px;">
                                                    <div style="display: flex; align-items: start; gap: 8px;">
                                                        <div style="flex: 1;">
                                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                                                <img src="{{ $review->buyer->avatar_path ?? themeAsset('images/user/user-default.png') }}" 
                                                                     alt="{{ $review->buyer->username }}" 
                                                                     style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                                                                <span style="font-size: 13px; color: #111827; font-weight: 600;">{{ $review->buyer->username }}</span>
                                                                <div style="display: flex; gap: 2px;">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if($review->rating >= $i)
                                                                            <iconify-icon icon="solar:star-bold" style="font-size: 12px; color: #fbbf24;"></iconify-icon>
                                                                        @else
                                                                            <iconify-icon icon="solar:star-outline" style="font-size: 12px; color: #d1d5db;"></iconify-icon>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <p style="font-size: 12px; color: #4b5563; margin: 0 0 4px 0; line-height: 1.5;">{{ $review->review }}</p>
                                                            <span style="font-size: 11px; color: #9ca3af;">{{ $review->created_at->diffForHumans() }}</span>
                                                            
                                                            @if ($review->reply)
                                                                <div style="background: #fff; border-left: 2px solid #3b82f6; border-radius: 4px; padding: 8px; margin-top: 8px;">
                                                                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                                                        <iconify-icon icon="lucide:corner-down-right" style="font-size: 12px; color: #3b82f6;"></iconify-icon>
                                                                        <span style="font-size: 12px; color: #111827; font-weight: 600;">{{ $listing->seller->username }}</span>
                                                                    </div>
                                                                    <p style="font-size: 11px; color: #4b5563; margin: 0;">{{ $review->reply->review }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if (auth()->check())
                                                            <button data-id="{{ encrypt($review->id) }}" class="report-button common-modal-button" type="button" style="background: none; border: none; padding: 4px; cursor: pointer;">
                                                                <iconify-icon icon="lucide:flag" style="font-size: 14px; color: #9ca3af;"></iconify-icon>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach

                                            @if ($totalReviews > 5)
                                                <button type="button" class="border-button w-100 mt-2" id="loadMoreReviews" data-listing-id="{{ $listing->id }}" data-offset="5" style="width: 100%; padding: 8px; font-size: 13px; border: 1px solid #e5e7eb; border-radius: 6px; background: #fff; color: #111827; cursor: pointer;">
                                                    {{ __('Load More Reviews') }}
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div style="text-align: center; padding: 20px; color: #9ca3af;">
                                            <iconify-icon icon="lucide:message-circle" style="font-size: 32px; margin-bottom: 8px;"></iconify-icon>
                                            <p style="font-size: 13px; margin: 0;">{{ __('No reviews yet') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden Buy Now Form --}}
            <form action="{{ route('buy-now') }}" method="post" id="buyNowForm" style="display: none;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $listing->id }}">
                <input type="hidden" name="quantity" value="1">
            </form>
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
    
    {{-- Refund Guarantee Modal --}}
    <div class="common-modal-full refund-guarantee-modal">
        <div class="common-modal-box" style="max-width: 600px; background: white; border-radius: 16px; padding: 0; overflow: hidden;">
            <div style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h5 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0;">{{ __('Refund Guarantee') }}</h5>
                    <button type="button" class="close" style="background: none; border: none; padding: 8px; cursor: pointer; color: #9ca3af; font-size: 24px; line-height: 1;">×</button>
                </div>
                <div style="color: #9ca3af; font-size: 14px; line-height: 1.6;">
                    <p style="margin: 0;">{{ __("GamsGo's DealShield is designed to provide users with a secure and reliable trading environment, effectively preventing various types of fraud. If an Order is not delivered or the actual content does not match the description, you may request a full refund. Before you confirm successful delivery, the platform will temporarily hold the payment to ensure a fair and transparent transaction process, giving you greater peace of mind.") }}</p>
                </div>
            </div>
        </div>
    </div>
    
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
            // Refund Guarantee Modal - specific handler
            $('.refund-guarantee-btn').click(function(e) {
                e.stopPropagation();
                $('.refund-guarantee-modal').addClass('open');
            });
            
            $('.refund-guarantee-modal .close').click(function() {
                $('.refund-guarantee-modal').removeClass('open');
            });
            
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
