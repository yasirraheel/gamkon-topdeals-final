@extends('frontend::layouts.user')
@section('title')
    {{ __('Payment Successful') }}
@endsection

@section('content')
    <div class="transaction-success-area section_space-py section_space-my">
        <div class="container">
            <div class="transaction-success-area-box">
                <div class="content">
                    <div class="success-icon">
                        <img src="{{ asset($data['image']) }}" alt="">
                    </div>
                    <h5>{{ $data['title'] }}</h5>
                    <p>{{ $data['bottom_text'] }}</p>
                    <div class="cta-btn">
                        <a href="{{ buyerSellerRoute('purchase.invoice', $order->order_number) }}"
                            class="primary-button primary-button-blue">{{ __('View Invoice') }}</a>
                        <a href="{{ buyerSellerRoute('purchase.index') }}"
                            class="primary-button primary-button-white ms-2">{{ __('Your Orders') }}</a>
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
            $('#filterForm').submit();
        })
    </script>
@endpush
