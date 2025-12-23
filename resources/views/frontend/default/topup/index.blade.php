@extends('frontend::layouts.user')
@section('title')
    {{ __(topupDepositText($user)) }}
@endsection
@push('css')
    <style>
        .all-payment-checkbox {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="transactions-history-box sold-orders-box">
        <div class="">
            <x-luminous.dashboard-breadcrumb title="{{ __(topupDepositText($user)) }}" />
            <div class="">
                <div class="checkout-area-content">
                    <div class="checkout-box ">
                        <form action="{{ buyerSellerRoute($user->is_seller ? 'deposit.purchase' : 'topup.purchase') }}"
                            method="post">
                            @csrf
                            <div class="row g-4 checkout-card-box">
                                <div class="col-lg-6">
                                    <div class="left">
                                        <div class="payment-method-box">
                                            <div class="header-box">
                                                <h4>{{ __('Payment Method') }}</h4>
                                            </div>
                                            @include('frontend::common.gateway', ['fromTopup' => true])
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="right">
                                        <div class="checkout-card-box">
                                            <div class="title">
                                                <h4>{{ __(topupDepositText($user)) }} {{ __('Details') }}</h4>
                                            </div>
                                            <div class="full-box">
                                                <div class="checkout-payment checkout-payment-2">
                                                    <div class="row gy-4">
                                                        <div class="td-form-group">
                                                            <label class="input-label">{{ __(topupDepositText($user)) }}
                                                                {{ __('Amount') }} <span>*</span></label>
                                                            <div class="input-field">
                                                                <input type="number" name="amount"
                                                                    value="{{ old('amount') }}" class="form-control"
                                                                    required min="1">
                                                                @error('amount')
                                                                    <p class="feedback-invalid">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <hr class="payment-line">

                                                        <div class="total payment-point payment-point-bold">
                                                            <div class="left">
                                                                <p>{{ __('Charge Amount') }}</p>
                                                            </div>
                                                            <div class="right">
                                                                <p><span class="charge-amount">0.00
                                                                        {{ $currency }}</span></p>
                                                            </div>
                                                        </div>

                                                        <div class="total payment-point payment-point-bold">
                                                            <div class="left">
                                                                <p>{{ __('Total Amount') }}</p>
                                                            </div>
                                                            <div class="right">
                                                                <p><span class="total-amount">0.00
                                                                        {{ $currency }}</span></p>
                                                            </div>
                                                        </div>

                                                        <div class="total payment-point payment-point-bold">
                                                            <div class="left">
                                                                <p>{{ __('Payable Amount') }}</p>
                                                            </div>
                                                            <div class="right">
                                                                <span class="payable-amount">0.00
                                                                    {{ $currency }}</span></p>
                                                            </div>
                                                        </div>


                                                        <div class="td-form-group has-right-icon manual-row">
                                                        </div>

                                                        <div class="pay-now-btn">
                                                            <button type="submit"
                                                                class="primary-button xl-btn w-100">{{ __('Topup') }}</button>
                                                        </div>
                                                    </div>
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
    </div>
@endsection

@push('js')
    <script>
        'use strict';
        $(document).on('change', '.sort-listing', function() {
            let newURL = decodeURIComponent("{!! url()->current() . '?' . http_build_query(array_merge(request()->query(), ['sort' => '___'])) !!}".replace('___', $(this).val()));
            window.location.href = newURL;
        })
    </script>

    <script src="{{ asset('/global/js/custom.js') }}?v={{ env('APP_VERSION') ?? app()->version() }}"></script>
    <script>
        'use strict';
        $(document).on('change', '[name="paymentMethod"]', function() {
            payGateway = $(this).next('label').data('label');
            methodChanged(payGateway);
        })

        $(document).ready(function() {
            methodChanged(payGateway);
        });

        $(document).on('input', 'input[name="amount"]', function() {
            methodChanged(payGateway);
        });

        function methodChanged(method) {
            var route = "{{ buyerSellerRoute('deposit.gateway', ['code' => '___code___', 'amount' => '__amount__']) }}"
                .replace('___code___', method).replace('__amount__', $('[name="amount"]').val() ?? 0);
            $.ajax({
                url: route,
                success: function(data) {
                    $('.manual-row').html(data.credentials ?? '');
                    $('.charge-amount').text(`${data.gatewayPayAmount.charge} {{ $currency }}`);
                    $('.total-amount').text(`${data.gatewayPayAmount.finalAmount} {{ $currency }}`);
                    $('.payable-amount').text(`${data.gatewayPayAmount.payAmount} ${data.currency}`);
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
