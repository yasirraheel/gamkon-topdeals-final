@extends('frontend::pages.index', ['mainClass' => 'home-2'])
@section('title')
    {{ $data->title }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')
    @push('style')
        <style>
            .action-btn .primary-button.active {
                background: var(--td-secondary);
                color: var(--td-white);
            }
            .action-btn .primary-button.disabled {
                pointer-events: none;
                cursor: not-allowed;
                opacity: 0.8;
            }
        </style>
    @endpush
    @php
        $plans = \App\Models\SubscriptionPlan::all();
    @endphp

    <section class="packages-area section_space-my">
        <div class="container">
            <div class="packages-area-content">
                <div class="packages-box w-100">
                    <div class="package-cards {{ $plans->isEmpty() ? 'border-0' : '' }}">
                        @foreach ($plans as $plan)
                            <div class="package-card @if ($plan->is_featured) has-recommanded @endif">
                                @if ($plan->is_featured)
                                    <div class="has-recommnded-box">
                                        <p>{{ $plan->badge }}</p>
                                    </div>
                                @endif
                                <div class="package-icon">
                                    <img src="{{ asset($plan->image) }}" alt="{{ $plan->name }} Icon">
                                </div>
                                <h6>{{ $plan->name }}</h6>
                                <div class="price">
                                    <h2><sup>{{ $currencySymbol }}</sup>{{ $plan->price }}</h2>
                                    <p>/{{ __(':count days', ['count' => $plan->validity]) }}</p>
                                </div>
                                <ul>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Listing Limit:') }} <span
                                                class="pricing-bold">{{ $plan->listing_limit }}
                                                {{ __('items') }}</span></span>
                                    </li>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Price:') }} <span
                                                class="pricing-bold">{{ $currencySymbol . $plan->price }}</span></span>
                                    </li>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Validity:') }} <span
                                                class="pricing-bold">{{ $plan->validity }}
                                                {{ __('Days') }}</span></span>
                                    </li>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Flash Sale Limit:') }} <span
                                                class="pricing-bold">{{ $plan->flash_sale_limit }}
                                                {{ __('items') }}</span></span>
                                    </li>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Referral Level:') }} <span
                                                class="pricing-bold">{{ $plan->referral_level ? $plan->referral_level . ' ' . __('Level') : __('No Referral Commission') }}</span></span>
                                    </li>
                                    <li>
                                        <span class="pricing-icon">
                                            <iconify-icon icon="mingcute:check-2-fill"
                                                class="double-check-mark"></iconify-icon>
                                        </span>
                                        <span class="pricing-text">{{ __('Commission Fee:') }} <span
                                                class="pricing-bold">{{ ($plan->charge_type == 'amount' ? $currencySymbol : '') . $plan->charge_value . ($plan->charge_type == 'percentage' ? '%' : '') }}</span></span>
                                    </li>
                                    @foreach (json_decode($plan->features ?? '[]') ?? [] as $feature)
                                        <li>
                                            <span class="pricing-icon">
                                                <iconify-icon icon="mingcute:check-2-fill"
                                                    class="double-check-mark"></iconify-icon>
                                            </span>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="action-btn w-100">
                                    @php
                                        $isSubscribed = $user?->is_seller && $user?->hasValidSubscription && $user->hasValidSubscription?->plan_id == $plan->id;
                                    @endphp
                                    <a @class([
                                        'primary-button xl-btn w-100',
                                        'border-btn-secondary' => !($isSubscribed || $plan->is_featured),
                                        'active' => $isSubscribed,
                                        'disabled' => $isSubscribed
                                    ])
                                        href="{{ $isSubscribed ? 'javascript:void(0)' : route('checkout', ['type' => 'plan', 'data' => $plan->id]) }}">
                                        {{ __($isSubscribed ? 'Subscribed' : 'Subscribe') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($plans->isEmpty())
                        <x-luminous.no-data-found has-bg type="{{ __('Subscription') }}" class="" />
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
