@php
    // Determine User's Country
    $userCountry = null;
    if (auth()->check() && auth()->user()->country) {
        // Parse "CountryName:DialCode" format if needed, or just use raw if simple string
        $parts = explode(':', auth()->user()->country);
        $userCountry = $parts[0];
    } else {
        $location = getLocation(); // Uses IP-API
        $userCountry = $location->name;
    }

    // Determine Availability
    $isAvailable = true;
    $regionType = $listing->region_type ?? 'global';
    $regions = $listing->region ? explode(',', $listing->region) : [];

    if ($regionType === 'include') {
        $isAvailable = in_array($userCountry, $regions);
    } elseif ($regionType === 'exclude') {
        $isAvailable = !in_array($userCountry, $regions);
    }
    // 'global' is always true
@endphp
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
    <style>
        .product-details-area .pd-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            border: 1px solid #f3f4f6;
        }
        
        .product-details-area .pd-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
            line-height: 1.3;
        }

        .product-details-area .pd-thumb {
            width: 140px;
            height: 140px;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
            flex-shrink: 0;
        }
        
        .product-details-area .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pd-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .pd-info-item {
            display: flex;
            gap: 12px;
        }
        
        .pd-info-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .pd-info-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
            display: block;
        }
        
        .pd-info-value {
            font-size: 15px;
            color: #111827;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }

        .pd-notice {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .sidebar-sticky {
            position: sticky;
            top: 20px;
        }

        .delivery-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 15px;
        }
        
        .delivery-stat .label {
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .delivery-stat .value {
            color: #111827;
            font-weight: 600;
        }

        .buy-now-btn {
            width: 100%;
            background: var(--td-primary) !important;
            color: white !important;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        .buy-now-btn:hover {
            opacity: 0.9;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #4b5563;
            cursor: pointer;
        }

        .seller-card {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .seller-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .review-item {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .review-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        @media (max-width: 991px) {
            .pd-info-grid {
                grid-template-columns: 1fr; /* Full width items on mobile */
                gap: 16px;
                width: 100%;
                margin-top: 16px;
            }
            .sidebar-sticky {
                position: static;
            }
            /* Improved Mobile Layout */
            .product-details-area .pd-thumb {
                width: 80px; /* Compact thumbnail */
                height: 80px;
                flex-shrink: 0;
                margin: 0 !important;
            }
            .mobile-header-row {
                width: 100%;
                border-bottom: 1px solid #f3f4f6;
                padding-bottom: 16px;
                margin-bottom: 16px !important;
            }
            .pd-title {
                font-size: 18px !important;
                line-height: 1.4;
                margin: 0 !important;
            }
            .pd-info-item {
                display: flex; /* Ensure flex is active */
                background: #f9fafb;
                padding: 12px;
                border-radius: 8px;
                width: 100%;
                justify-content: flex-start;
                text-align: left;
                gap: 12px; /* Ensure gap exists */
            }
            .pd-info-label {
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .pd-info-value {
                font-size: 14px;
            }
        }
        
        @media (max-width: 480px) {
            .pd-info-grid {
                grid-template-columns: 1fr; /* 1 column only on very small screens */
            }
            .product-details-area .pd-thumb {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endpush
@section('content')
    <div class="product-details-area section_space-my">
        <div class="container">
            {{-- Breadcrumb --}}
            <div class="mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-muted text-decoration-none" style="font-size: 14px;">
                    <iconify-icon icon="iconamoon:arrow-left-2"></iconify-icon> {{ __('Back to all offers') }}
                </a>
            </div>

            <div class="row g-4">
                {{-- Left Column: Product Info --}}
                <div class="col-lg-8">
                    {{-- Product Header Card --}}
                    <div class="pd-card">
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-start">
                            <div class="pd-thumb d-none d-md-block">
                                <img src="{{ asset($listing->thumbnail) }}" alt="{{ $listing->product_name }}">
                            </div>
                            <div class="flex-grow-1 w-100">
                                <div class="d-flex flex-row align-items-start gap-3 mb-3 mobile-header-row">
                                    <div class="pd-thumb d-md-none">
                                        <img src="{{ asset($listing->thumbnail) }}" alt="{{ $listing->product_name }}">
                                    </div>
                                    <h1 class="pd-title mb-0">{{ $listing->product_name }}</h1>
                                </div>
                                
                                <div class="pd-info-grid">
                                    {{-- Region --}}
                                    <div class="pd-info-item">
                                        <div class="pd-info-icon text-muted">
                                            <iconify-icon icon="solar:earth-bold" width="24"></iconify-icon>
                                        </div>
                                        <div>
                                            <span class="pd-info-label">{{ __('Region Availability') }}</span>
                                            
                                            <div class="d-flex align-items-center gap-1">
                                                @if($regionType === 'global')
                                                    <iconify-icon icon="solar:verified-check-bold" class="text-primary" width="16"></iconify-icon>
                                                    <p class="pd-info-value mb-0">{{ __('Global (All Countries)') }}</p>
                                                @elseif($regionType === 'include')
                                                    <iconify-icon icon="solar:verified-check-bold" class="text-primary" width="16"></iconify-icon>
                                                    <p class="pd-info-value mb-0">{{ __('Selected Countries Only') }}</p>
                                                @else
                                                    <iconify-icon icon="solar:verified-check-bold" class="text-primary" width="16"></iconify-icon>
                                                    <p class="pd-info-value mb-0">{{ __('Global (Except Excluded)') }}</p>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($isAvailable)
                                                    <div class="d-inline-flex align-items-center gap-2 text-success" style="font-size: 14px; font-weight: 500;">
                                                        <iconify-icon icon="solar:check-circle-bold" width="18" height="18" class="flex-shrink-0"></iconify-icon>
                                                        <span>{{ __('Active in :country', ['country' => $userCountry]) }}</span>
                                                    </div>
                                                @else
                                                    <div class="d-inline-flex align-items-center gap-2 text-danger" style="font-size: 14px; font-weight: 500;">
                                                        <iconify-icon icon="solar:close-circle-bold" width="18" height="18" class="flex-shrink-0"></iconify-icon>
                                                        <span>{{ __('Not Available in :country', ['country' => $userCountry]) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#regionModal" class="text-primary text-decoration-none d-block mt-1" style="font-size: 13px;">
                                                {{ __('Check region restrictions') }}
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Sharing Method --}}
                                    <div class="pd-info-item">
                                        <div class="pd-info-icon text-muted">
                                            <iconify-icon icon="solar:user-bold" width="24"></iconify-icon>
                                        </div>
                                        <div>
                                            <span class="pd-info-label">{{ __('Sharing Method') }}</span>
                                            <p class="pd-info-value">{{ $listing->selected_plan ?? $listing->productCatalog->sharing_methods[0] ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    {{-- Supported Devices --}}
                                    <div class="pd-info-item">
                                        <div class="pd-info-icon text-muted">
                                            <iconify-icon icon="solar:monitor-smartphone-bold" width="24"></iconify-icon>
                                        </div>
                                        <div>
                                            <span class="pd-info-label">{{ __('Supported devices') }}</span>
                                            <p class="pd-info-value">{{ $listing->devices ?? 'PC, Mobile' }}</p>
                                        </div>
                                    </div>

                                    {{-- Duration --}}
                                    <div class="pd-info-item">
                                        <div class="pd-info-icon text-muted">
                                            <iconify-icon icon="solar:hourglass-line-bold" width="24"></iconify-icon>
                                        </div>
                                        <div>
                                            <span class="pd-info-label">{{ __('Duration') }}</span>
                                            <p class="pd-info-value">{{ $listing->selected_duration }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Important Notice --}}
                        <div class="pd-notice mt-4">
                            <div class="d-flex gap-3">
                                <iconify-icon icon="solar:info-circle-bold" class="text-primary flex-shrink-0" width="24" style="margin-top: 2px;"></iconify-icon>
                                <div>
                                    <h6 class="text-primary fw-bold mb-2" style="font-size: 15px;">{{ __('Important Notice') }}</h6>
                                    <p class="text-primary mb-2" style="font-size: 14px; opacity: 0.9; line-height: 1.6;">
                                        {{ __('This item/service is offered by independent sellers on') }} {{ setting('site_title', 'global') }}. {{ __('If you have any questions or issues, please contact the seller directly.') }}
                                    </p>
                                    <p class="text-primary mb-0" style="font-size: 14px; opacity: 0.9; line-height: 1.6;">
                                        {{ __('Friendly reminder: Official') }} {{ setting('site_title', 'global') }} {{ __('coupons can be used on standard orders, but not on Marketplace purchases.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="pd-card">
                        <h4 class="fw-bold mb-3" style="font-size: 18px;">{{ __('Offer description') }}</h4>
                        <div class="text-muted" style="font-size: 14px; line-height: 1.7;">
                            {!! $listing->description !!}
                        </div>
                    </div>

                    {{-- Explore More (Desktop) --}}
                    @if ($suggested->count())
                        <div class="pd-card d-none d-lg-block">
                            <h4 class="fw-bold mb-3" style="font-size: 18px;">{{ __('Explore More') }}</h4>
                            <div class="row g-3">
                                @foreach ($suggested->take(4) as $item)
                                    <div class="col-md-6">
                                        <a href="{{ route('listing.details', $item->slug) }}" class="text-decoration-none">
                                            <div class="d-flex gap-3 p-3 border rounded-3 bg-white h-100 align-items-center hover-shadow transition">
                                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->product_name }}" width="60" height="60" class="rounded-3 object-fit-cover">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h6 class="text-dark fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $item->product_name }}</h6>
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <iconify-icon icon="solar:star-bold" class="text-warning" width="12"></iconify-icon>
                                                        <span class="text-muted small fw-bold">{{ number_format($item->average_rating, 1) }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-baseline gap-2">
                                                        <span class="text-danger fw-bold">{{ amountWithCurrency($item->final_price) }}</span>
                                                        @if ($item->discount_value > 0)
                                                            <span class="text-muted small text-decoration-line-through">{{ amountWithCurrency($item->price) }}</span>
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

                {{-- Right Column: Sidebar --}}
                <div class="col-lg-4">
                    <div class="sidebar-sticky">
                        {{-- Purchase Card --}}
                        <div class="pd-card">
                            <div class="delivery-stat">
                                <span class="label"><iconify-icon icon="solar:clock-circle-bold" width="20"></iconify-icon> {{ __('Guaranteed delivery time') }}</span>
                                <span class="value">{{ $listing->delivery_method == 'auto' ? '5 minutes' : ($listing->delivery_speed . ' ' . $listing->delivery_speed_unit) }}</span>
                            </div>
                            <div class="delivery-stat">
                                <span class="label"><iconify-icon icon="solar:bolt-circle-bold" width="20"></iconify-icon> {{ __('Average delivery time') }}</span>
                                @php
                                    $deliveryService = new \App\Services\AverageDeliveryTimeService();
                                    $deliveryData = $deliveryService->getDeliveryTimeDisplay($listing->seller, $listing->delivery_method == 'auto' ? 'Instant' : '~1 hour');
                                @endphp
                                <span class="value" @if($deliveryData['is_estimated']) data-bs-toggle="tooltip" title="{{ __('Estimated based on guaranteed time') }}" @endif>
                                    {{ $deliveryData['text'] }}
                                    @if(!$deliveryData['is_estimated'])
                                        <iconify-icon icon="solar:history-bold" class="text-success ms-1" width="14" data-bs-toggle="tooltip" title="{{ __('Calculated from actual order history') }}"></iconify-icon>
                                    @endif
                                </span>
                            </div>
                            @if ($listing->guarantee_period)
                                <div class="delivery-stat">
                                    <span class="label"><iconify-icon icon="solar:shield-check-bold" width="20"></iconify-icon> {{ __('Warranty Period') }}</span>
                                    <span class="value">{{ $listing->guarantee_period }}</span>
                                </div>
                            @endif

                            <hr class="my-4 text-muted opacity-25">

                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <span class="text-muted fw-bold">{{ __('Total') }}:</span>
                                <div class="text-end">
                                    <h3 class="text-danger fw-bold mb-0" style="font-size: 28px;">{{ amountWithCurrency($listing->final_price) }}</h3>
                                    @if ($listing->discount_value > 0)
                                        <small class="text-muted text-decoration-line-through">{{ amountWithCurrency($listing->price) }}</small>
                                    @endif
                                </div>
                            </div>

                            <button onclick="document.getElementById('buyNowForm').submit();" class="buy-now-btn mb-3">
                                {{ __('Buy Now') }}
                            </button>

                            <div class="d-flex gap-4">
                                <div class="trust-badge refund-guarantee-btn">
                                    <iconify-icon icon="solar:shield-check-bold" class="text-success" width="20"></iconify-icon>
                                    {{ __('Refund Guarantee') }}
                                </div>
                                <div class="trust-badge express-checkout-btn">
                                    <iconify-icon icon="solar:delivery-bold" class="text-success" width="20"></iconify-icon>
                                    {{ __('Express Checkout') }}
                                </div>
                            </div>
                        </div>

                        {{-- Seller Profile --}}
                        <div class="pd-card">
                            <div class="seller-card">
                                <img src="{{ $listing->seller->avatar_path ?? themeAsset('images/user/user-default.png') }}" alt="{{ $listing->seller->username }}" class="seller-avatar">
                                <div>
                                    <a href="{{ route('seller.details', $listing->seller->username) }}" class="text-dark fw-bold text-decoration-none d-block mb-1">
                                        {{ $listing->seller->username }}
                                        @if($listing->seller->kyc == \App\Enums\KYCStatus::Verified->value)
                                            <iconify-icon icon="solar:verified-check-bold" class="text-primary ms-1" width="16" style="vertical-align: middle;" data-bs-toggle="tooltip" title="{{ __('KYC Verified') }}"></iconify-icon>
                                        @endif
                                    </a>
                                    <div class="d-flex align-items-center gap-1">
                                        <iconify-icon icon="solar:like-bold" class="text-primary" width="14"></iconify-icon>
                                        <span class="text-primary small fw-bold">{{ number_format($listing->seller->order_success_rate ?? 98.5, 2) }}%</span>
                                        <span class="text-muted small">({{ $listing->seller->total_reviews ?? 0 }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Recent Feedback --}}
                        <div class="pd-card">
                            <h5 class="fw-bold mb-3" style="font-size: 16px;">{{ __('Recent feedback') }}</h5>
                            
                            @forelse($listing->approvedReviews()->latest()->take(3)->get() as $review)
                                <div class="review-item">
                                    <div class="d-flex gap-2 mb-1">
                                        <iconify-icon icon="solar:like-bold" class="text-primary" width="14" style="margin-top: 2px;"></iconify-icon>
                                        <div>
                                            <span class="d-block text-dark fw-bold small mb-0">{{ $review->buyer->username ?? 'User' }}</span>
                                            <small class="text-muted d-block mb-1" style="font-size: 11px;">{{ __('Bought') }} {{ $listing->product_name }}</small>
                                            <p class="text-muted small mb-1">{{ $review->review }}</p>
                                            <small class="text-muted" style="font-size: 10px;">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3">
                                    <small>{{ __('No reviews yet') }}</small>
                                </div>
                            @endforelse
                            
                            @if($listing->approvedReviews()->count() > 3)
                                <a href="#" class="text-primary small fw-bold text-decoration-none mt-2 d-block">{{ __('See all feedback') }}</a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mobile Explore More --}}
                @if ($suggested->count())
                    <div class="col-12 d-lg-none">
                        <div class="pd-card">
                            <h4 class="fw-bold mb-3" style="font-size: 18px;">{{ __('Explore More') }}</h4>
                            <div class="row g-3">
                                @foreach ($suggested->take(4) as $item)
                                    <div class="col-md-6">
                                        <a href="{{ route('listing.details', $item->slug) }}" class="text-decoration-none">
                                            <div class="d-flex gap-3 p-3 border rounded-3 bg-white h-100 align-items-center">
                                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->product_name }}" width="60" height="60" class="rounded-3 object-fit-cover">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h6 class="text-dark fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $item->product_name }}</h6>
                                                    <div class="d-flex align-items-baseline gap-2">
                                                        <span class="text-danger fw-bold">{{ amountWithCurrency($item->final_price) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Hidden Buy Now Form --}}
            <form action="{{ route('buy-now') }}" method="post" id="buyNowForm" style="display: none;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $listing->id }}">
                <input type="hidden" name="quantity" value="1">
            </form>
        </div>
    </div>

    {{-- Refund Guarantee Modal --}}
    <div class="common-modal-full refund-guarantee-modal">
        <div class="common-modal-box" style="max-width: 600px; background: white; border-radius: 16px; padding: 24px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">{{ __('Refund Guarantee') }}</h5>
                <button type="button" class="close bg-transparent border-0 fs-4" style="line-height: 1;">&times;</button>
            </div>
            <div class="text-muted" style="line-height: 1.6;">
                <p>{{ __("Topdealsplus's DealShield is designed to provide users with a secure and reliable trading environment, effectively preventing various types of fraud. If an Order is not delivered or the actual content does not match the description, you may request a full refund. Before you confirm successful delivery, the platform will temporarily hold the payment to ensure a fair and transparent transaction process, giving you greater peace of mind.") }}</p>
            </div>
        </div>
    </div>

    {{-- Express Checkout Modal --}}
    <div class="common-modal-full express-checkout-modal">
        <div class="common-modal-box" style="max-width: 600px; background: white; border-radius: 16px; padding: 24px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">{{ __('Express Checkout') }}</h5>
                <button type="button" class="close bg-transparent border-0 fs-4" style="line-height: 1;">&times;</button>
            </div>
            <div class="text-muted" style="line-height: 1.6;">
                <p>{{ __("Topdealsplus ensures that verified listings with Express Checkout are delivered instantly or within the guaranteed timeframe. Our system automatically processes these orders to ensure you receive your digital goods without delay.") }}</p>
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

    {{-- Region Modal --}}
    <div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="regionModalLabel">{{ __('Region Availability') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert {{ $isAvailable ? 'alert-success' : 'alert-danger' }} d-flex align-items-center mb-4" role="alert">
                        <iconify-icon icon="{{ $isAvailable ? 'solar:check-circle-bold' : 'solar:forbidden-circle-bold' }}" class="fs-4 me-2"></iconify-icon>
                        <div>
                            <strong>{{ $isAvailable ? __('Great news!') : __('We are sorry.') }}</strong> 
                            {{ $isAvailable 
                                ? __('This product is available for activation in :country.', ['country' => $userCountry]) 
                                : __('This product CANNOT be activated in :country.', ['country' => $userCountry]) 
                            }}
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">{{ __('Detailed Country List:') }}</h6>
                    
                    @if($regionType === 'global')
                        <p class="text-success"><iconify-icon icon="solar:global-circle-bold" class="me-1"></iconify-icon> {{ __('This product is available globally in all countries.') }}</p>
                    @else
                        <div class="row g-2" style="max-height: 400px; overflow-y: auto;">
                            @php
                                $allCountries = getCountries();
                                // If 'include', show all as disabled except allowed ones
                                // If 'exclude', show all as enabled except excluded ones
                            @endphp
                            
                            @foreach($allCountries as $country)
                                @php
                                    $countryName = $country['name'];
                                    $isAllowed = false;
                                    
                                    if ($regionType === 'include') {
                                        $isAllowed = in_array($countryName, $regions);
                                    } elseif ($regionType === 'exclude') {
                                        $isAllowed = !in_array($countryName, $regions);
                                    }
                                    
                                    $isUserCountry = ($countryName === $userCountry);
                                @endphp
                                <div class="col-md-4 col-sm-6">
                                    <div class="d-flex align-items-center p-2 rounded {{ $isAllowed ? 'bg-light' : 'bg-danger bg-opacity-10' }} {{ $isUserCountry ? 'border border-primary' : '' }}">
                                        <div class="flex-shrink-0 me-2" style="font-size: 18px;">
                                            @if($isAllowed)
                                                <iconify-icon icon="solar:check-circle-bold" class="text-success"></iconify-icon>
                                            @else
                                                <iconify-icon icon="solar:close-circle-bold" class="text-danger"></iconify-icon>
                                            @endif
                                        </div>
                                        <div class="text-truncate {{ $isAllowed ? '' : 'text-danger' }}">
                                            {{ $countryName }}
                                            @if($isUserCountry)
                                                <span class="badge bg-primary ms-1">{{ __('You') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ themeAsset('js/slick.min.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script>
        'use strict';
        var __quantity = {{ $listing->quantity }};
        var unitPrice = {{ $listing->final_price }};
        $(document).ready(function() {
            // Refund Guarantee Modal
            $('.refund-guarantee-btn').click(function(e) {
                e.stopPropagation();
                $('.refund-guarantee-modal').addClass('open');
            });
            $('.refund-guarantee-modal .close').click(function() {
                $('.refund-guarantee-modal').removeClass('open');
            });

            // Express Checkout Modal
            $('.express-checkout-btn').click(function(e) {
                e.stopPropagation();
                $('.express-checkout-modal').addClass('open');
            });
            $('.express-checkout-modal .close').click(function() {
                $('.express-checkout-modal').removeClass('open');
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