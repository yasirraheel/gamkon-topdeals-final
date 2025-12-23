@extends('backend.layouts.app')
@section('title', 'Create Coupon')
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Create Coupon') }}</h2>
                            <a href="{{ route('admin.coupon.index') }}" class="title-btn"><i
                                    data-lucide="arrow-left"></i>Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.coupon.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xxl-4">
                                        <div class="site-input-groups">
                                            <label for="code" class="box-input-label">{{ __('Coupon Code') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="code" class="box-input mb-0"
                                                value="{{ old('code') }}" required />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4">
                                        <div class="site-input-groups">
                                            <label for="discount_type" class="box-input-label">{{ __('Charges') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" class="box-input mb-0"
                                                    oninput="this.value = validateDouble(this.value)" name="discount_value"
                                                    required>
                                                <div class="prcntcurr">
                                                    <select name="discount_type" class="form-select">
                                                        <option value="percentage" @selected(old('discount_type') == 'percentage')>%</option>
                                                        <option value="fixed" @selected(old('discount_type') == 'amount')>$</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4">
                                        <div class="site-input-groups">
                                            <label for="expires_at" class="box-input-label">{{ __('Expiration Date') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="date" name="expires_at" class="box-input mb-0"
                                                value="{{ old('expires_at') }}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="check"></i> {{ __('Create Coupon') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
