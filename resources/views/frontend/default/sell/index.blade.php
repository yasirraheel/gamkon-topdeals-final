@extends('frontend::layouts.user')
@section('title')
    {{ __('Sold Items') }}
@endsection

@section('content')
    <div class="app-page-full-body">
        <div class="referral-program referral-program-2">
            <div class="referral-program-box">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="account-balance active">
                            <div class="card-box"
                                data-background="{{ themeAsset('images/referral/account-balance-bg.png') }}">
                                <p>{{ __('Total Sell Amount') }}</p>
                                <h2>{{ $currencySymbol }}{{ number_format($totalSold ?? 0, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="successful-referrals">
                            <div class="card-box"
                                data-background="{{ themeAsset('images/referral/total-referrals-bg.png') }}">
                                <p>{{ __('Total Orders') }}</p>
                                <h2>{{ number_format($totalOrders ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="successful-referrals">
                            <div class="card-box"
                                data-background="{{ themeAsset('images/referral/total-referrals-bg.png') }}">
                                <p>{{ __('Success Rate') }}</p>
                                <h2>{{ number_format($successRate ?? 0, 1) }}%</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="successful-referrals">
                            <div class="card-box"
                                data-background="{{ themeAsset('images/referral/total-referrals-bg.png') }}">
                                <p>{{ __('Net Revenue') }}</p>
                                <h2>{{ $currencySymbol }}{{ number_format($totalRevenue ?? 0, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sold-orders-box title_mt">
            <x-luminous.dashboard-breadcrumb title="{{ __('Sold Items') }}" class="sort-title-3">
                <div class="left">
                    <p>{{ __('Sort by') }}</p>
                </div>
                <form action="{{ request()->fullUrl() }}" class="right" method="get" id="filterForm">
                    <div class="sort-filter common-filter">
                        <select class="nice-select-active sort-listing" name="sort">
                            <option @selected(request('sort') == '') value="">{{ __('All') }}</option>
                            <option @selected(request('sort') == 'price-asc') value="price-asc">{{ __('Lowest Price') }}</option>
                            <option @selected(request('sort') == 'price-desc') value="price-desc">{{ __('Highest Price') }}</option>
                            <option @selected(request('sort') == 'latest') value="latest">{{ __('Latest') }}</option>
                            <option @selected(request('sort') == 'oldest') value="oldest">{{ __('Oldest') }}</option>
                        </select>
                    </div>
                </form>
            </x-luminous.dashboard-breadcrumb>
            <div>
                <div class="common-table">
                    <div class="common-table-full">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-nowrap">{{ __('Order Number') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Order Date') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Product') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Category') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Order Status') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Price') }}</th>
                                    <th scope="col" class="text-nowrap">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <th scope="row" class="text-nowrap">{{ $order->order_number }}</th>
                                        <th scope="row" class="text-nowrap">{{ orderDateFormat($order->created_at) }}
                                        </th>
                                        <td class="text-nowrap">
                                            @if ($order->is_topup)
                                                {{ __('Topup') . ' #' . $order->order_number }}
                                            @else
                                                <a class="link"
                                                    href="{{ route('listing.details', $order->listing?->slug ?? 404) }}">{{ $order->listing?->product_name }}</a>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $order->listing?->category?->name ?? 'N/A' }}</td>
                                        <td class="text-nowrap">
                                            {!! $order->status_badge !!}
                                        </td>
                                        <td class="text-nowrap">{{ $currencySymbol . $order->total_price }}</td>
                                        <td>
                                            <div class="tooltip-action-btns">
                                                @if ($order->status == \App\Enums\OrderStatus::WaitingForDelivery->value)
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delivery Now') }}"
                                                        href="{{ buyerSellerRoute('listing.delivery-items', [
                                                            'id' => $order->listing?->enc_id ?? 400,
                                                            'order_id' => $order->id,
                                                        ]) }}"
                                                        class="tooltip-btn delivery-btn">
                                                        <iconify-icon icon="lucide:truck"
                                                            class="tooltip-icon"></iconify-icon>
                                                    </a>
                                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Refund') }}"
                                                        data-href="{{ buyerSellerRoute('sell.refund', $order->order_number) }}"
                                                        class="tooltip-btn delete-btn refund-btn common-modal-button">
                                                        <iconify-icon icon="lucide:arrow-up"
                                                            class="tooltip-icon"></iconify-icon>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <x-luminous.no-data-found type="Sold Orders" />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-pagination">
                        <div class="pagination">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Refund Confirmation Modal --}}
    <div class="common-modal-full refund-modal">
        <div class="common-modal-box common-modal-box-2">
            <div class="content">
                <div class="delete-modal">
                    <div class="icon">
                        <iconify-icon icon="ic:round-warning" class="warning-icon"></iconify-icon>
                    </div>
                    <h4>{{ __('Are you sure you want to request a refund?') }}</h4>
                    <p>{{ __('This action will initiate a refund process for this order.') }}</p>
                    <div class="modal-action-btn">
                        <a href="" class="primary-button refund-form-btn">{{ __('Confirm Refund') }}</a>
                        <button type="button" class="primary-button border-btn close">{{ __('Cancel') }}</button>
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
        // Set refund URL in modal
        $(document).on('click', '.refund-btn', function() {
            const url = $(this).data('href');
            $('.refund-form-btn').attr('href', url);
        });
    </script>
@endpush
