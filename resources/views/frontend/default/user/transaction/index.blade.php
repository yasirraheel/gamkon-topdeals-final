@extends('frontend::layouts.user', ['mainClass' => '-2'])
@section('title')
    {{ __('Transactions') }}
@endsection
@push('style')
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/flat-picker-color-select.css') }}">
@endpush
@section('content')
    <div class="transactions-history-box">
        <form method="GET" id="filterForm" action="{{ url()->current() }}">

            <x-luminous.dashboard-breadcrumb
                title="{{ isset($type) ? str($type)->remove('_all')->headline() : __('Transactions') }}">
                <div class="table-sort">
                    <div class="input-search">
                        <input type="text" name="trx" class="box-input" value="{{ request('trx') }}"
                            placeholder="{{ __('Transaction ID') }}">
                    </div>
                    <div class="calender">
                        <div class="custom-range-calender">
                            <input type="text" name="daterange" id="flatpickr-range" value="{{ request('daterange') }}"
                                placeholder="{{ __('Date Range') }}" class="form-control flatpickr-input"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="sort-dropdown">
                        <div class="sort-filter common-filter">
                            <select name="type" class="nice-select nice-select-active">
                                <option value="">{{ __('All Type') }}</option>
                                <option value="deposit_all" @selected(request('type') == 'deposit_all')>{{ __('Deposits') }}</option>
                                <option value="withdraw_all" @selected(request('type') == 'withdraw_all')>{{ __('Withdrawals') }}</option>
                                <option value="order_all" @selected(request('type') == 'order_all')>{{ __('Orders') }}</option>
                                <option value="refund_all" @selected(request('type') == 'refund_all')>{{ __('Refunds') }}</option>
                                <option value="referral_all" @selected(request('type') == 'referral_all')>{{ __('Bonuses') }}</option>
                                <option value="plan_all" @selected(request('type') == 'plan_all')>{{ __('Plans') }}</option>
                                <option value="seller_all" @selected(request('type') == 'seller_all')>{{ __('Seller Transactions') }}
                                </option>
                                <option value="deduction_all" @selected(request('type') == 'deduction_all')>{{ __('Deductions') }}</option>
                                <option value="topup" @selected(request('type') == 'topup')>{{ __('Topup') }}</option>
                            </select>
                        </div>
                        <div class="sort-filter common-filter">
                            <div class="" tabindex="0"><span class="current">
                                    <select name="limit" class="nice-select nice-select-active"
                                        onchange="$('#filterForm').submit()">
                                        <option value="15" @selected(request('limit', 15) == '15')>{{ __('15') }}</option>
                                        <option value="30" @selected(request('limit') == '30')>{{ __('30') }}</option>
                                        <option value="50" @selected(request('limit') == '50')>{{ __('50') }}</option>
                                        <option value="100" @selected(request('limit') == '100')>{{ __('100') }}</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="action-btn">
                        <button class="primary-button">{{ __('Search') }}</button>
                    </div>
                </div>
            </x-luminous.dashboard-breadcrumb>
    </div>
    <div class="common-table">
        <div class="common-table-full">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="">{{ __('Description') }}</th>
                        <th scope="col" class="">{{ __('Transactions ID') }}</th>
                        <th scope="col" class="">{{ __('Type') }}</th>
                        <th scope="col" class="">{{ __('Amount') }}</th>
                        <th scope="col" class="">{{ __('Charge') }}</th>
                        <th scope="col" class="">{{ __('Status') }}</th>
                        <th scope="col" class="">{{ __('Method') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <th class="">
                                <div class="payment-name-and-date">
                                    <div class="name d-flex align-items-center">
                                        <span class="me-1">{{ $transaction->description }} @if (!in_array($transaction->approval_cause, ['none', '']))
                                        </span>
                                        <svg data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $transaction->approval_cause }}" data-bs-trigger="hover"
                                            data-bs-original-title="" xmlns="http://www.w3.org/2000/svg" width="12"
                                            height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-badge-info-icon lucide-badge-info">
                                            <path
                                                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                                            <line x1="12" x2="12" y1="16" y2="12" />
                                            <line x1="12" x2="12.01" y1="8" y2="8" />
                                        </svg>
                    @endif
        </div>
        <div class="date">{{ $transaction->created_at }}</div>
    </div>
    </th>
    <td class="">{{ $transaction->tnx }}</td>
    <td class="">
        {{ ucfirst(str_replace('_', ' ', $transaction->type->value)) }}</td>
    <td class=" {{ isPlusTransaction($transaction->type) ? 'green-color' : 'red-color' }}">
        {{ isPlusTransaction($transaction->type) ? '+' : '-' }}{{ number_format(in_array($transaction->type, [\App\Enums\TxnType::Topup, \App\Enums\TxnType::Deposit]) ? $transaction->order?->unit_price ?? 0 : $transaction->amount, 2) . ' ' . $currency }}
    </td>
    <td class=" red-color">-{{ $transaction->charge . ' ' . $currency }}</td>
    <td class="">
        @if ($transaction->status->value == 'failed')
            <div class="type badge bg-danger">{{ __(ucwords($transaction->status->value)) }}</div>
        @elseif($transaction->status->value == 'success')
            <div class="type badge bg-success">{{ __(ucwords($transaction->status->value)) }}</div>
        @elseif($transaction->status->value == 'pending')
            <div class="type badge bg-warning text-black">{{ __(ucwords($transaction->status->value)) }}</div>
        @else
            <div class="type badge bg-secondary">{{ __(ucwords($transaction->status->value)) }}</div>
        @endif
    </td>
    <td class="">
        {{ $transaction->method !== '' ? ucfirst(str_replace('-', ' ', $transaction->method)) : __('System') }}
    </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">
            <x-luminous.no-data-found type="Transactions" />
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>
    </div>
    <div class="table-responsive">
        <div class="pagination">
            {{ $transactions->withQueryString()->onEachSide(2)->links() }}
        </div>
    </div>
    </div>
    </div>
@endsection
@push('js')
    <script src="{{ themeAsset('js/moment.min.js') }}"></script>
    <script src="{{ themeAsset('js/flatpickr.js') }}"></script>
    <script src="{{ themeAsset('js/flatpicker-activation.js') }}"></script>
    <script>
        "use strict";

        $('.select2').select2({
            minimumResultsForSearch: Infinity,
        });
        @if (request('daterange') == null)
            // Set default is empty for date range
            $('input[name=daterange]').val('');
        @endif
    </script>
@endpush
