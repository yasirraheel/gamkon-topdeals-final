@extends('frontend::layouts.user')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    @php
        $getReferral = app('\App\Services\ReferralService')->getOrCreateFirstReferralLink(auth()->user());
        $referralTransactions = App\Models\Transaction::where('type', App\Enums\TxnType::Referral)
            ->where('user_id', $user->id)
            ->get();
    @endphp
    <div class="overview-box">
        <div class="seller-overview">
            <div class="title">
                <h4>{{ __(':type Overview', ['type' => $user->is_seller ? 'Seller' : 'Buyer']) }}</h4>
            </div>
            @if (!$user->is_seller)
                <div class="row g-4">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="seller-overview-card active">
                            <div class="icon">
                                <iconify-icon icon="ic:baseline-payments" class="seller-card-icon"></iconify-icon>
                            </div>
                            <div class="text">
                                <p>{{ __('Balance') }}</p>
                                <h3>{{ amountWithCurrency(auth()->user()->balance) }}</h3>
                            </div>
                            <div class="bg-element">
                                <img src="{{ themeAsset('/images/dashboard/dashbaord-main-page/bg-element.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="seller-overview-card">
                            <div class="icon">
                                <iconify-icon icon="ic:baseline-people-alt" class="seller-card-icon"></iconify-icon>
                            </div>
                            <div class="text">
                                <p>{{ __('Total Referrals') }}</p>
                                <h3>{{ $getReferral?->relationships()?->count() }}</h3>
                            </div>
                            <div class="bg-element">
                                <img src="{{ themeAsset('/images/dashboard/dashbaord-main-page/bg-element.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="seller-overview-card">
                            <div class="icon">
                                <iconify-icon icon="ic:round-shopping-cart" class="seller-card-icon"></iconify-icon>
                            </div>
                            <div class="text">
                                <p>{{ __('Orders') }}</p>
                                <h3>{{ $dataCount['total_orders'] }}</h3>
                            </div>
                            <div class="bg-element">
                                <img src="{{ themeAsset('/images/dashboard/dashbaord-main-page/bg-element.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="seller-overview-card">
                            <div class="icon">
                                <iconify-icon icon="ic:baseline-sell" class="seller-card-icon"></iconify-icon>
                            </div>
                            <div class="text">
                                <p>{{ __('Total Purchased') }}</p>
                                <h3>{{ amountWithCurrency($dataCount['total_revenue']) }}</h3>
                            </div>
                            <div class="bg-element">
                                <img src="{{ themeAsset('/images/dashboard/dashbaord-main-page/bg-element.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    <div class="col-xxl-8">
                        <div class="row g-4">
                            <div class="col-sm-6 col-xxl-4">
                                <div class="seller-overview-card seller-overview-card-2">
                                    <div class="seller-inner">
                                        <div class="icon">
                                            <iconify-icon icon="majesticons:money" class="seller-card-icon"></iconify-icon>
                                        </div>
                                        <div class="text">
                                            <h3>{{ amountWithCurrency($sellerData['balance']) }}</h3>
                                            <p>{{ __('Total Balance') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-element">
                                        <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-1.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-4">
                                <div class="seller-overview-card seller-overview-card-2">
                                    <div class="seller-inner">
                                        <div class="icon">
                                            <iconify-icon icon="majesticons:eye" class="seller-card-icon"></iconify-icon>
                                        </div>
                                        <div class="text">
                                            <h3>{{ $sellerData['total_listings'] }}</h3>
                                            <p>{{ __('Total Listings') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-element">
                                        <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-2.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xxl-4">
                                <div class="seller-overview-card seller-overview-card-2">
                                    <div class="seller-inner">
                                        <div class="icon">
                                            <iconify-icon icon="majesticons:users" class="seller-card-icon"></iconify-icon>
                                        </div>
                                        <div class="text">
                                            <h3>{{ $dataCount['total_referral'] }}</h3>
                                            <p>{{ __('Total Referrals') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-element">
                                        <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-3.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-4">
                                <div class="seller-overview-card seller-overview-card-2">
                                    <div class="seller-inner">
                                        <div class="icon">
                                            <iconify-icon icon="majesticons:eye" class="seller-card-icon"></iconify-icon>
                                        </div>
                                        <div class="text">
                                            <h3>{{ $dataCount['total_views'] }}</h3>
                                            <p>{{ __('Total Views') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-element">
                                        <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-4.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-4">
                                <div class="seller-overview-card seller-overview-card-2">
                                    <div class="seller-inner">
                                        <div class="icon">
                                            <iconify-icon icon="majesticons:analytics"
                                                class="seller-card-icon"></iconify-icon>
                                        </div>
                                        <div class="text">
                                            <h3>{{ amountWithCurrency($dataCount['total_revenue']) }}</h3>
                                            <p>{{ __('Total Revenue') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-element">
                                        <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-5.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            @foreach ($sellerData['orderData'] as $key => $order)
                                <div class="col-sm-6 col-xxl-4">
                                    <div class="seller-overview-card seller-overview-card-2">
                                        <div class="seller-inner">
                                            <div class="icon">
                                                <iconify-icon
                                                    icon="{{ $sellerOverviewIcon[str($key)->headline()->toString()] }}"
                                                    class="seller-card-icon"></iconify-icon>
                                            </div>
                                            <div class="text">
                                                <h3>{{ $order }}</h3>
                                                <p>{{ __(':status Orders', ['status' => $key]) }}</p>
                                            </div>
                                        </div>
                                        <div class="bg-element">
                                            <img src="{{ themeAsset('images/dashboard/dashbaord-main-page/seller-bg-' . ($loop->index + 6) . '.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="package-overview">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="package-overview-card">
                                        <div id="planDaysRemaining"></div>
                                        <div class="content-box">
                                            <div class="title-box">
                                                <h5>{{ $sellerData['planData']['name'] }}</h5>
                                                <button class="info-btn" type="button" data-bs-toggle="tooltip"
                                                    aria-label="{{ __('Plan Expires At') }}: {{ $sellerData['planData']['expiry'] }}"
                                                    data-bs-original-title="{{ __('Plan Expires At') }}: {{ $sellerData['planData']['expiry'] }}">
                                                    <svg width="16" height="17" viewBox="0 0 16 17"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M7.99992 15.1667C4.31792 15.1667 1.33325 12.182 1.33325 8.50001C1.33325 4.81801 4.31792 1.83334 7.99992 1.83334C11.6819 1.83334 14.6666 4.81801 14.6666 8.50001C14.6666 12.182 11.6819 15.1667 7.99992 15.1667ZM7.33325 7.83334V11.8333H8.66658V7.83334H7.33325ZM7.33325 5.16668V6.50001H8.66658V5.16668H7.33325Z"
                                                            fill="#303030" fill-opacity="0.6"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <p>{{ __(':count days remaining', ['count' => $sellerData['planData']['remaining']]) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="package-overview-card">
                                        <div id="flashSellBar"></div>
                                        <div class="content-box">
                                            <div class="title-box">
                                                <h5>{{ __('Flash Sale Remaining') }}</h5>
                                            </div>
                                            <p>{{ __(':used/:limit remaining', ['used' => $sellerData['planData']['flash_sale_remaining'], 'limit' => $sellerData['planData']['total_flash_sale']]) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="package-overview-card">
                                        <div id="listingBar"></div>
                                        <div class="content-box">
                                            <div class="title-box">
                                                <h5>{{ __('Listing Remaining') }}</h5>
                                            </div>
                                            <p>{{ __(':used / :limit listings remaining', ['used' => $sellerData['planData']['listing_remaining'], 'limit' => $sellerData['planData']['listing_limit']]) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="package-overview-card">
                                        <div id="commissionBar"></div>
                                        <div class="content-box">
                                            <div class="title-box">
                                                <h5>{{ __('Commission Rate') }}</h5>
                                            </div>
                                            <p>{{ $sellerData['planData']['commission_text'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="activity-and-referral-link">
            <div class="row g-4">
                <div class="col-xxl-7">
                    <div class="activity">
                        <div class="activity-header">
                            <h4>{{ __('Activity') }}</h4>
                            <div class="activity-chart">
                                <div id="chart-container">
                                    <div class="button-and-date-container">
                                        <div id="button-container">
                                            <button id="" class="chart-btn activity-chart-btn active"
                                                data-target="All">
                                                <span class="circle-toggle" id="all">
                                                    <span class="inner-circle"></span>
                                                </span>
                                                {{ __('All') }}
                                            </button>

                                            @if ($user->is_seller)
                                                <button id="" class="chart-btn activity-chart-btn"
                                                    data-target="Sell">
                                                    <span class="circle-toggle" id="circleToggle">
                                                        <span class="inner-circle"></span>
                                                    </span>
                                                    {{ __('Sell') }}
                                                </button>
                                                <button id="" class="chart-btn activity-chart-btn"
                                                    data-target="Deposit">
                                                    <span class="circle-toggle" id="circleToggle">
                                                        <span class="inner-circle"></span>
                                                    </span>
                                                    {{ __('Deposit') }}
                                                </button>
                                            @endif
                                            <button id="" class="chart-btn activity-chart-btn"
                                                data-target="Withdraw">
                                                <span class="circle-toggle" id="circleToggle">
                                                    <span class="inner-circle"></span>
                                                </span>
                                                {{ __('Withdraw') }}
                                            </button>
                                            @if (!$user->is_seller)
                                                <button id="" class="chart-btn activity-chart-btn"
                                                    data-target="Orders">
                                                    <span class="circle-toggle" id="circleToggle">
                                                        <span class="inner-circle"></span>
                                                    </span>
                                                    {{ __('Orders') }}
                                                </button>
                                            @endif
                                        </div>
                                        <div class="date-content seller-activity">
                                            <div class="date date-year">
                                                <h6>{{ __('Month') }}</h6>
                                                <div class="month-year-select">
                                                    <select name="month">
                                                        <option @selected(date('m') == '01') value="01">
                                                            {{ __('January') }}
                                                        </option>
                                                        <option @selected(date('m') == '02') value="02">
                                                            {{ __('February') }}
                                                        </option>
                                                        <option @selected(date('m') == '03') value="03">
                                                            {{ __('March') }}
                                                        </option>
                                                        <option @selected(date('m') == '04') value="04">
                                                            {{ __('April') }}
                                                        </option>
                                                        <option @selected(date('m') == '05') value="05">
                                                            {{ __('May') }}
                                                        </option>
                                                        <option @selected(date('m') == '06') value="06">
                                                            {{ __('June') }}
                                                        </option>
                                                        <option @selected(date('m') == '07') value="07">
                                                            {{ __('July') }}
                                                        </option>
                                                        <option @selected(date('m') == '08') value="08">
                                                            {{ __('August') }}
                                                        </option>
                                                        <option @selected(date('m') == '09') value="09">
                                                            {{ __('September') }}
                                                        </option>
                                                        <option @selected(date('m') == '10') value="10">
                                                            {{ __('October') }}
                                                        </option>
                                                        <option @selected(date('m') == '11') value="11">
                                                            {{ __('November') }}
                                                        </option>
                                                        <option @selected(date('m') == '12') value="12">
                                                            {{ __('December') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="year date-year">
                                                <h6>{{ __('Year') }}</h6>
                                                <div class="month-year-select">
                                                    <select name="year">
                                                        @foreach (range(now()->parse($user->created_at)->format('Y'), date('Y')) as $year)
                                                            <option value="{{ $year }}">{{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="activityLineChart" style="">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5">
                    @if ($user->is_seller)
                        <div class="report-box">
                            <div class="title">
                                <h4>{{ __('Order Status Report') }}</h4>
                            </div>
                            <div class="report-box-chart-content status-report">
                                <div class="filter-date">
                                    <div class="date-content">
                                        <div class="date date-year">
                                            <h6>{{ __('Month') }}</h6>
                                            <div class="month-year-select">
                                                <select name="month">
                                                    <option @selected(date('m') == '01') value="01">
                                                        {{ __('January') }}
                                                    </option>
                                                    <option @selected(date('m') == '02') value="02">
                                                        {{ __('February') }}
                                                    </option>
                                                    <option @selected(date('m') == '03') value="03">
                                                        {{ __('March') }}
                                                    </option>
                                                    <option @selected(date('m') == '04') value="04">
                                                        {{ __('April') }}
                                                    </option>
                                                    <option @selected(date('m') == '05') value="05">
                                                        {{ __('May') }}
                                                    </option>
                                                    <option @selected(date('m') == '06') value="06">
                                                        {{ __('June') }}
                                                    </option>
                                                    <option @selected(date('m') == '07') value="07">
                                                        {{ __('July') }}
                                                    </option>
                                                    <option @selected(date('m') == '08') value="08">
                                                        {{ __('August') }}
                                                    </option>
                                                    <option @selected(date('m') == '09') value="09">
                                                        {{ __('September') }}
                                                    </option>
                                                    <option @selected(date('m') == '10') value="10">
                                                        {{ __('October') }}
                                                    </option>
                                                    <option @selected(date('m') == '11') value="11">
                                                        {{ __('November') }}
                                                    </option>
                                                    <option @selected(date('m') == '12') value="12">
                                                        {{ __('December') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="year date-year">
                                            <h6>{{ __('Year') }}</h6>
                                            <div class="month-year-select">
                                                <select name="year">
                                                    @foreach (range(now()->parse($user->created_at)->format('Y'), date('Y')) as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-chart">
                                    <div id="myReportChart"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="referral-link">
                            <div class="referral-header">
                                <h4>{{ __('Referral Link') }}</h4>
                            </div>
                            <div class="referral-content">
                                <div class="referral-link-content">
                                    <div class="referral-link-input">
                                        <input type="text"
                                            value="{{ $getReferral?->link ?? 'https://example.com/register?invite=default' }}"
                                            readonly="">
                                        <button class="copy-btn">{{ __('Copy') }}</button>
                                    </div>
                                    <p>{{ __(':people_count people joined using this link', ['people_count' => $getReferral?->relationships()?->count() ?? 0]) }}
                                    </p>
                                </div>
                                <div class="total-referrals">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="total-referrals-card">
                                                <h4>{{ $dataCount['total_referral'] }}</h4>
                                                <p>{{ __('Total Referrals') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="total-referrals-card">
                                                <h4>{{ amountWithCurrency($referralTransactions->sum('amount') ?? 0) }}
                                                </h4>
                                                <p>{{ __('Total Referrals Bonus') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="share-link">
                                    <h5>{{ __('Share Url') }}:</h5>
                                    <div class="share-btn">
                                        <button class="share-btn-item">
                                            <iconify-icon icon="lucide:share-2" class="share-icon"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        @if ($user->is_seller)
            <div class="purchase-order common-table-card">
                <h4>{{ __('Sold Orders') }}</h4>
                <div class="common-table">
                    <div class="common-table-full">
                        <div class="common-full-table table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-nowrap">{{ __('Order Date') }}</th>
                                        <th scope="col" class="text-nowrap">{{ __('Product') }}</th>
                                        <th scope="col" class="text-nowrap">{{ __('Category') }}</th>
                                        <th scope="col" class="text-nowrap">{{ __('Price') }}</th>
                                        <th scope="col" class="text-nowrap">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentSell as $sell)
                                        <tr>
                                            <th scope="row" class="text-nowrap">
                                                {{ orderDateFormat($sell->created_at) }}
                                            </th>
                                            <td class="text-nowrap">
                                                @if ($sell->is_topup)
                                                    {{ __('Topup') . ' #' . $sell->order_number }}
                                                @else
                                                    {{ $sell->listing?->product_name }}
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $sell->listing?->category?->name ?? 'N/A' }}</td>
                                            <td class="text-nowrap">
                                                {{ $currencySymbol . $sell->total_price }}</td>
                                            <td class="text-nowrap">
                                                {!! $sell->status_badge !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <x-luminous.no-data-found type="{{ __('Sold Orders') }}" />
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="purchase-order common-table-card">
                <h4>{{ __('Purchased Item') }}</h4>
                <div class="common-table">
                    <div class="common-table-full">
                        <div class="common-full-table table-responsive">
                            <div class="common-full-table table-responsive-lg">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-nowrap">{{ __('Order No.') }}</th>
                                            <th scope="col" class="text-nowrap">{{ __('Order Date') }}</th>
                                            <th scope="col" class="text-nowrap">{{ __('Product') }}</th>
                                            <th scope="col" class="text-nowrap">{{ __('Category') }}</th>
                                            <th scope="col" class="text-nowrap">{{ __('Price') }}</th>
                                            <th scope="col" class="text-nowrap">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentPurchase as $purchase)
                                            <tr>
                                                <th>#{{ $purchase->order_number }}</th>
                                                <th scope="row" class="text-nowrap">
                                                    {{ orderDateFormat($purchase->created_at) }}
                                                </th>
                                                <td class="text-nowrap">
                                                    @if ($purchase->is_topup)
                                                        {{ __('Topup') . ' #' . $purchase->order_number }}
                                                    @else
                                                        {{ $purchase->listing?->product_name }}
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    {{ $purchase->listing?->category?->name ?? 'N/A' }}
                                                </td>
                                                <td class="text-nowrap">
                                                    {{ $currencySymbol . $purchase->total_price }}
                                                </td>
                                                <td class="text-nowrap">
                                                    {!! $purchase->status_badge !!}
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <x-luminous.no-data-found type="{{ __('Purchased Item') }}" />
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('js')
    <script src="{{ themeAsset('js/apexcharts.min.js') }}"></script>

    <script>
        "use strict";
        $(document).on('click', '.share-btn-item', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'Referral Link',
                    text: 'Join using my referral link!',
                    url: '{{ $getReferral?->link }}',
                }).catch(console.error);
            } else {
                alert('Your browser does not support the Web Share API.');
            }
        })
        @if ($user->is_seller)
            var pie_options = {
                series: @json($pieData['series']),
                chart: {
                    type: 'donut',
                    width: 470
                },
                labels: @json($pieData['labels']),
                colors: @json($pieData['colors']),
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    itemMargin: {
                        horizontal: 10,
                        vertical: 5
                    },
                    labels: {
                        colors: '#333'
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 280
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };


            var pie_chart = new ApexCharts(document.querySelector("#myReportChart"), pie_options);
            pie_chart.render();

            $('.status-report select[name="month"], .status-report select[name="year"]').on('change', function() {
                const month = $('.status-report select[name="month"]').val();
                const year = $('.status-report select[name="year"]').val();

                $.ajax({
                    url: '{{ buyerSellerRoute('dashboard') }}?type=pie',
                    method: 'GET',
                    data: {
                        month,
                        year
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        pie_chart.updateSeries(response.series);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });

            var options = {
                series: [
                    {{ number_format(findPercentage($sellerData['planData']['total'], $sellerData['planData']['remaining']), 2) }}
                ],
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                            background: 'transparent'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                color: '#000',
                                fontSize: '22px',
                                show: true,
                                offsetY: 10,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        },
                        track: {
                            background: '#f2f2f2'
                        },
                        stroke: {
                            lineCap: 'round',
                            width: 3
                        }
                    },
                },
                colors: ['#FF6229'],
                labels: [''],
            };

            var chart = new ApexCharts(document.querySelector("#planDaysRemaining"), options);
            chart.render();

            var options = {
                series: [
                    {{ number_format(100 - findPercentage($sellerData['planData']['total_flash_sale'], $sellerData['planData']['flash_sale_remaining']), 2) }}
                ],
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                            background: 'transparent'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                color: '#000',
                                fontSize: '22px',
                                show: true,
                                offsetY: 10,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        },
                        track: {
                            background: '#f2f2f2'
                        },
                        stroke: {
                            lineCap: 'round',
                            width: 3
                        }
                    },
                },
                colors: ['#184E94'],
                labels: [''],
            };

            var chart = new ApexCharts(document.querySelector("#flashSellBar"), options);
            chart.render();

            var options = {
                series: [
                    {{ number_format(100 - findPercentage($sellerData['planData']['listing_limit'], $sellerData['planData']['listing_remaining']), 2) }}
                ],
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                            background: 'transparent'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                color: '#000',
                                fontSize: '22px',
                                show: true,
                                offsetY: 10,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        },
                        track: {
                            background: '#f2f2f2'
                        },
                        stroke: {
                            lineCap: 'round',
                            width: 3
                        }
                    },
                },
                colors: ['#31B269'],
                labels: [''],
            };

            var chart = new ApexCharts(document.querySelector("#listingBar"), options);
            chart.render();

            var options = {
                series: [
                    {{ $sellerData['planData']['commission_circle_inner_text_type'] == '%' ? 100 - $sellerData['planData']['commission_circle_value'] : $sellerData['planData']['commission_circle_value'] }}
                ],
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                            background: 'transparent'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                color: '#000',
                                fontSize: '22px',
                                show: true,
                                offsetY: 10,
                                formatter: function(val) {
                                    return val +
                                        "{{ $sellerData['planData']['commission_circle_inner_text_type'] == '%' ? '%' : $currency }}";
                                }
                            }
                        },
                        track: {
                            background: '#f2f2f2'
                        },
                        stroke: {
                            lineCap: 'round',
                            width: 3
                        }
                    },
                },
                colors: ['#8D2EFA'],
                labels: [''],
            };

            var chart = new ApexCharts(document.querySelector("#commissionBar"), options);
            chart.render();
        @endif

        const __activityChartData = @json($chartData);

        $(document).ready(function() {

            const __activitySeriesColors = ['#4CAF50', '#FF8D29', '#2674FB'];
            let activeTab = 'All';
            let chart;


            const chartOptions = {
                chart: {
                    height: 380,
                    type: 'line',
                    foreColor: '#fff',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                grid: {
                    show: true,
                    borderColor: 'rgba(48, 48, 48, 0.16)',
                    strokeDashArray: 0,
                    position: 'back',
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true,
                            strokeDashArray: 0
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: [2, 2, 2],
                    dashArray: [0, 0, 0]
                },
                fill: {
                    type: 'solid',
                    opacity: 0.04,
                    colors: __activitySeriesColors
                },
                xaxis: {
                    categories: __activityChartData.labels,
                    labels: {
                        style: {
                            colors: '#303030',
                            fontSize: '14px',
                            fontWeight: 500
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    tickAmount: 6,
                    labels: {
                        style: {
                            colors: '#303030',
                            fontSize: '14px',
                            fontWeight: 500
                        },
                        formatter: val => (val >= 1000 ? (val / 1000) + 'k' : val) + ' {{ $currency }}',
                        offsetX: -10
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                markers: {
                    size: 6,
                    strokeWidth: 2,
                    hover: {
                        size: 8
                    }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                    style: {
                        fontSize: '12px'
                    },
                    x: {
                        show: true
                    },
                    y: {
                        formatter: function(value, {
                            series,
                            seriesIndex,
                            dataPointIndex,
                            w
                        }) {
                            return value + ' {{ $currency }}';
                        }
                    },
                    marker: {
                        show: true
                    }
                }
            };


            function updateChartSeries(dataSource = __activityChartData) {
                let series = [{
                        data: [],
                        type: 'area',
                        color: __activitySeriesColors[0]
                    },
                    {
                        data: [],
                        type: 'area',
                        color: __activitySeriesColors[1]
                    },
                    {
                        data: [],
                        type: 'area',
                        color: __activitySeriesColors[2]
                    }
                ];


                chart.updateSeries(dataSource.series);
                if (activeTab == 'All') {
                    chart.resetSeries();
                } else {
                    if ("{{ $user->is_seller }}" == true) {
                        allType = ['Sell', 'Deposit', 'Withdraw'];
                    } else {
                        allType = ['Orders', 'Withdraw'];
                    }
                    allType.forEach(function(type) {
                        if (type != activeTab) {
                            chart.hideSeries(type);
                        } else {
                            chart.showSeries(type);
                        }
                    })
                }

            }


            chart = new ApexCharts($('#activityLineChart')[0], {
                ...chartOptions,
                series: __activityChartData.series.map((series, index) => ({
                    ...series,
                    type: 'area',
                    color: __activitySeriesColors[index],
                    fill: {
                        type: 'solid',
                        opacity: 0.04,
                        colors: __activitySeriesColors
                    }
                }))
            });
            chart.render();
            // updateChartSeries();


            $('.chart-btn').on('click', function() {
                $('.chart-btn').removeClass('active');
                $(this).addClass('active');
                activeTab = $(this).data('target');
                updateChartSeries();
            });


            $('.seller-activity select[name="month"], .seller-activity select[name="year"]').on('change',
                function() {
                    const month = $('.seller-activity select[name="month"]').val();
                    const year = $('.seller-activity select[name="year"]').val();

                    $.ajax({
                        url: '{{ buyerSellerRoute('dashboard') }}?type=chart',
                        method: 'GET',
                        data: {
                            month,
                            year
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            __activityChartData.labels = response.labels;
                            __activityChartData.series = response.series;

                            chart.updateOptions({
                                xaxis: {
                                    ...chartOptions.xaxis,
                                    categories: response.labels
                                }
                            });
                            updateChartSeries(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                });
        });
    </script>
@endpush
