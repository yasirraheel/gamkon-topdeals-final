@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])

@section('title')
    {{ __('Checkout') }}
@endsection

@push('css')
<style>
    /* Prevent ads in checkout card */
    .checkout-card-box ins,
    .checkout-card-box .adsbygoogle,
    .checkout-card-box [id*="google_ads"],
    .checkout-card-box [class*="google-ad"],
    .checkout-card-box [class*="ad-unit"],
    .checkout-payment ins,
    .checkout-payment .adsbygoogle,
    .checkout-payment [id*="google_ads"],
    .checkout-payment [class*="google-ad"],
    .checkout-payment [class*="ad-unit"] {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
    }
</style>
@endpush

@section('content')
    <div class="checkout-area section_space-py">
        <div class="container">
            <div class="checkout-area-content">
                <div class="checkout-box">
                    <form action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="left">
                                    <div class="payment-method-box">
                                        <div class="header-box">
                                            <h4>{{ __('Select Your Payment Gateway') }}</h4>
                                        </div>
                                        <!-- Include dynamic payment gateways -->
                                        @include('frontend::common.gateway', [
                                            'product_order' => !isset($checkout['plan_data']),
                                            'is_plan' => isset($checkout['plan_data']),
                                        ])
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right">
                                    <div class="checkout-card-box">
                                        <div class="title">
                                            <h4>{{ __('Your Order') }}</h4>
                                        </div>
                                        <div class="full-box">
                                            <div class="checkout-card">
                                                <div class="img-box">
                                                    @if (isset($listing))
                                                        <div class="img">
                                                            <img src="{{ $listing->thumbnail_url }}" alt="GAME ICON">
                                                        </div>
                                                    @else
                                                        <div class="img">
                                                            <img src="{{ asset($checkout['plan_data']->image) }}"
                                                                alt="GAME ICON">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text">
                                                    @if (isset($listing))
                                                        <h6>{{ $listing->product_name }}</h6>
                                                        <span>{{ __('Games') }}</span>
                                                        <p>{{ setting('currency_symbol', 'global') }}{{ $listing->price }}
                                                        </p>
                                                    @else
                                                        <h6>{{ $checkout['plan_data']->name }}</h6>
                                                        <span>{{ __('Plan') }}</span>
                                                        <p>{{ setting('currency_symbol', 'global') }}{{ $checkout['total'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="manual-row mt-2 row gy-4"></div>
                                            <div class="checkout-payment">
                                                <div class="subtotal payment-point">
                                                    <div class="left">
                                                        <p>{{ __('Subtotal') }}</p>
                                                    </div>
                                                    <div class="right">
                                                        <p style="white-space: nowrap;">{{ setting('currency_symbol', 'global') }}{{ $checkout['subtotal'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if (isset($listing) && $listing->price != $listing->final_price)
                                                    <div class="voucher payment-point">
                                                        <div class="left">
                                                            <p>{{ __('Discount') }}
                                                                ({{ $listing->discount_type == 'percentage' ? $listing->discount_value . '%' : setting('currency_symbol', 'global') . $listing->discount_value }})
                                                            </p>
                                                        </div>
                                                        <div class="right">
                                                            <p style="white-space: nowrap;">- {{ setting('currency_symbol', 'global') }}{{ $listing->discount_amount }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(setting('tiered_pricing_enabled', 'tiered_pricing') && isset($checkout['country_tier']) && $checkout['country_tier'] > 1)
                                                    <div class="voucher payment-point">
                                                        <div class="left">
                                                            <p style="padding: 6px 8px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: #fff; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-block; margin: 0;">{{ __('Tier') }} {{ $checkout['country_tier'] }} {{ __('Discount') }} ({{ $checkout['country_name'] }})</p>
                                                        </div>
                                                        <div class="right">
                                                            <p style="white-space: nowrap;">- {{ setting('currency_symbol', 'global') }}{{ ($listing->final_price - $checkout['tier_unit_price']) * $checkout['quantity'] }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (isset($checkout['coupon']))
                                                    <div class="voucher payment-point">
                                                        <div class="left">
                                                            <p>{{ __('Coupon Discount') }}</p>
                                                        </div>
                                                        <div class="right">
                                                            <p style="white-space: nowrap;">- {{ setting('currency_symbol', 'global') }}{{ $checkout['coupon_discount_amount'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif


                                                <hr class="payment-line" />
                                                <div class="total payment-point payment-point-bold">
                                                    <div class="left">
                                                        <p>{{ __('Charge') }}</p>
                                                    </div>
                                                    <div class="right">
                                                        <p style="white-space: nowrap;">{{ setting('currency_symbol', 'global') }}<span
                                                                class="charge-amount">0</span></p>
                                                    </div>
                                                </div>
                                                <div class="total payment-point payment-point-bold">
                                                    <div class="left">
                                                        <p>{{ __('TOTAL') }}</p>
                                                    </div>
                                                    <div class="right">
                                                        <p style="white-space: nowrap;">{{ setting('currency_symbol', 'global') }}<span
                                                                class="total-amount">{{ $checkout['total'] }}</span></p>
                                                    </div>
                                                </div>
                                                <div class="total payment-point payment-point-bold">
                                                    <div class="left">
                                                        <p>{{ __('Payable Amount') }}</p>
                                                    </div>
                                                    <div class="right">
                                                        <p style="white-space: nowrap;"><span
                                                                class="payable-symbol">{{ setting('currency_symbol', 'global') }}</span><span
                                                                class="payable-amount">{{ $checkout['total'] }}</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pay-now-btn">
                                                <button type="submit"
                                                    class="primary-button xl-btn w-100">{{ __('Pay Now') }}</button>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="{{ asset('/global/js/custom.js') }}?v={{ env('APP_VERSION') ?? app()->version() }}"></script>
    <script>
        'use strict';
        $(document).on('change', 'label.img, input[name="paymentMethod"]', function() {
            methodChanged();
        })
        $(document).ready(function() {
            methodChanged();
        });

        function methodChanged(method = null) {
            if (method == null) {
                method = $('[name="paymentMethod"]:checked').val()
            }
            var route = "{{ buyerSellerRoute('deposit.gateway', ['code' => '___code___', 'amount' => '__amount__']) }}"
                .replace('___code___', method).replace('__amount__', {{ $checkout['total'] }});
            $.ajax({
                url: route,
                success: function(data) {
                    $('.manual-row').html(data.credentials ?? '');
                    $('.charge-amount').text(data.gatewayPayAmount.charge);
                    $('.total-amount').text(data.gatewayPayAmount.finalAmount);
                    $('.payable-amount').text(data.gatewayPayAmount.payAmount);
                    $('.payable-symbol').text(data.currency_symbol ?? data.currency);
                },
                complete: function() {
                    imagePreview();
                }
            });
        }

        function showCloseButton(event) {
            var button = event.target.parentElement.nextElementSibling; // Get the close button
            button.style.display = 'block'; // Show the close button
        }
    </script>
@endpush
