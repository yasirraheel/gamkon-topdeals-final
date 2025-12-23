@extends('frontend::layouts.user')
@section('title')
    {{ __('Delivery Items') }}
@endsection

@section('content')
    <div class="app-page-full-body">
        <div class="transactions-history-box sold-orders-box">
            <x-luminous.dashboard-breadcrumb title="{{ __('Purchased Orders') }}">
                <div class="left">
                    <p>{{ __('Sort by') }}</p>
                </div>
                <form action="{{ request()->fullUrl() }}" class="right" method="get" id="filterForm">
                    <div class="sort-filter common-filter">
                        <select class="nice-select-active sort-listing" name="sort">
                            <option @selected(request('sort') == 'asc') value="asc">{{ __('Lowest Price') }}</option>
                            <option @selected(request('sort') == 'desc') value="desc">{{ __('Highest Price') }}</option>
                            <option @selected(request('sort') == '') value="">{{ __('All') }}</option>
                        </select>
                    </div>
                </form>
            </x-luminous.dashboard-breadcrumb>
            <div>
                <div class="common-table">
                    <div class="common-table-full">
                        <table class="table align-middle listing-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="">{{ __('Product') }}</th>
                                    <th scope="col" class="">{{ __('Delivered Items') }}</th>
                                    <th scope="col" class="">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deliveryItems as $item)
                                    <tr>
                                        @if ($loop->first)
                                            <td class="align-middle" rowspan="{{ count($deliveryItems) }}">
                                                {{ $order->listing->product_name }}</td>
                                        @endif
                                        <td class="align-middle">{{ $item->data }}</td>
                                        <td>
                                            <div class="tooltip-action-btns">
                                                @if ($order->status == \App\Enums\OrderStatus::Completed->value)
                                                    <button class="copy-btn tooltip-btn" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Copy">
                                                        <iconify-icon icon="lucide:copy"
                                                            class="tooltip-icon"></iconify-icon>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <x-luminous.no-data-found type="Delivery Items" />
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
@endsection

@push('js')
    <script>
        // copy button
        'use strict';
        $(document).on('click', '.copy-btn', function() {
            var copyText = $(this).closest('td').prev().text().trim();

            navigator.clipboard.writeText(copyText);
            showNotification('success', '{{ __('Copied!') }}');
        })
    </script>
@endpush
