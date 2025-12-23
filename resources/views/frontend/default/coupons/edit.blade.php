@extends('frontend::layouts.user', ['mainClass' => '-2'])
@section('title', 'Edit Coupon')
@push('css')
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
@endpush
@section('content')
    <div class="transactions-history-box">

        <x-luminous.dashboard-breadcrumb title="{{ __('Edit Coupon') }}" />
        <div class="">
            <form class="product-details-form" method="POST"
                action="{{ buyerSellerRoute('coupon.update', $coupon->enc_id) }}">
                @csrf
                <div class="row gy-3">

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon">
                            <label class="input-label">{{ __('Coupon Code') }} <span>*</span></label>
                            <div class="input-field">
                                <input type="text" name="code" class="form-control"
                                    value="{{ old('code', $coupon->code) }}" required>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon">
                            <label class="input-label">{{ __('Amount') }} <span>*</span></label>
                            <div class="input-field input-group">
                                <input value="{{ old('discount_value', $coupon->discount_value) }}" name="discount_value"
                                    type="number" class="form-control discount-value" required>
                                <div class="right-dropdown">
                                    <div class="form-right-dropdown-nice-select">
                                        <select name="discount_type" class="nice-select-active">
                                            <option value="percentage"
                                                {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>
                                                %</option>
                                            <option value="amount"
                                                {{ old('discount_type', $coupon->discount_type) == 'amount' ? 'selected' : '' }}>
                                                {{ setting('currency_symbol', 'global') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon">
                            <label class="input-label">{{ __('Expiration Date') }} <span>*</span></label>
                            <div class="input-field">
                                <input type="text" name="expires_at" class="form-control" id="flatpickr-date"
                                    value="{{ old('expires_at', $coupon->expires_at->format('Y-m-d')) }}" required>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon">
                            <label class="input-label">{{ __('Max Use Limit') }} <span>*</span></label>
                            <div class="input-field">
                                <input type="number" name="max_use_limit" class="form-control"
                                    value="{{ old('max_use_limit', $coupon->max_use_limit) }}" required>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon">
                            <label class="input-label">{{ __('Total Used') }} <span>*</span></label>
                            <div class="input-field">
                                <input type="number" name="total_used" class="form-control"
                                    value="{{ old('total_used', $coupon->total_used) }}" required>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-form-group has-right-icon common-select2-dropdown">
                            <label class="input-label">{{ __('Status') }} <span>*</span></label>
                            <div class="input-field">
                                <select name="status" class="nice-select-active w-100" required>
                                    <option value="1" @selected(old('status', $coupon->status) == '1')>{{ __('Active') }}
                                    </option>
                                    <option value="0" @selected(old('status', $coupon->status) == '0')>{{ __('Inactive') }}
                                    </option>
                                </select>
                            </div>
                            <p class="feedback-invalid">{{ __('This field is required') }}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="set-infomation-btn">
                            <button type="submit" class="primary-button primary-button-full primary-button-blue w-100">
                                {{ __('Update Coupon') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ themeAsset('js/flatpickr.js') }}"></script>
    <script src="{{ themeAsset('js/flatpicker-activation.js') }}"></script>

    <script>
        'use strict';

        function validateDouble(value) {
            return value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        }
    </script>
@endpush
