@extends('frontend::layouts.user')
@section('title')
    {{ __('My Listing') }}
@endsection
@section('content')
    <div class="transactions-history-box sold-orders-box">
        <x-luminous.dashboard-breadcrumb class="table-sort-3"
            title="{{ __('My Listing (:count)', ['count' => $listingCount]) }}">

            <div class="right">
                <form action="{{ request()->fullUrl() }}" class="right" method="get" id="filterForm">

                    <div class="input-search">
                        <input type="text" placeholder="Search Product" name="q" value="{{ request('q') }}">
                    </div>
                    <div>
                        <div class="filter-btn">
                            <div class="sort-filter common-filter">
                                <select class="nice-select-active sort-listing" name="sort">
                                    <option value="" disabled>{{ __('Sort by') }}</option>
                                    <option value="lowest-price" {{ request('sort') == 'lowest-price' ? 'selected' : '' }}>
                                        {{ __('Lowest Price') }}
                                    </option>
                                    <option value="highest-price"
                                        {{ request('sort') == 'highest-price' ? 'selected' : '' }}>
                                        {{ __('Highest Price') }}
                                    </option>
                                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>
                                        {{ __('All') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="action-btn">
                        <button class="primary-button">{{ __('Search') }}</button>
                    </div>
                </form>
            </div>
        </x-luminous.dashboard-breadcrumb>
        <div class="">
            <div class="common-table">
                <div class="common-table-full">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-nowrap">{{ __('Image') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Name') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Category') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Delivery Method') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Price') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Status') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Approval Status') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($listings as $listing)
                                <tr>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="game-img-bg">
                                                <div class="Product-image">
                                                    <img src="{{ $listing->thumbnail_url }}"
                                                        alt="{{ $listing->product_name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="text-nowrap">
                                        <div class="d-flex flex-column align-items-start">
                                            {{ str($listing->product_name)->limit(40) }}
                                            @if ($listing->productCatalog)
                                                <span class="badge badge-2 info">{{ $listing->productCatalog->name }}</span>
                                            @endif
                                            @if ($listing->selected_duration)
                                                <span class="badge badge-2 warning">{{ $listing->selected_duration }}</span>
                                            @endif
                                            @if ($listing->selected_plan)
                                                <span class="badge badge-2 success">{{ $listing->selected_plan }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">{{ $listing->category?->name }} @if ($listing->subcategory)
                                            / {{ $listing->subcategory->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ ucwords($listing->delivery_method) }}
                                        @if ($listing->delivery_method == 'manual')
                                            <br>
                                            <span class="badge info mt-1 badge-2">{{ __('after') }}
                                                {{ $listing->delivery_speed }} {{ $listing->delivery_speed_unit }}</span>
                                        @endif

                                    </td>
                                    <td class="text-nowrap">

                                        @if ($listing->discount_amount > 0)
                                            <del>{{ amountWithCurrency($listing->price) }}</del>
                                            <br>
                                            {{ amountWithCurrency($listing->final_price) }}
                                        @else
                                            {{ amountWithCurrency($listing->price) }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        {!! $listing->status_badge !!}
                                    </td>
                                    <td class="text-nowrap">
                                        {!! $listing->is_approved
                                            ? '<span class="badge badge-2 success">Approved</span>'
                                            : '<span class="badge badge-2 error">Not Approved</span>' !!}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="tooltip-action-btns">
                                                <a target="_blank" href="{{ route('listing.details', $listing->slug) }}"
                                                    class="delete tooltip-btn view-btn" data-id="{{ $listing->enc_id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View Details Page">
                                                    <iconify-icon icon="lucide:eye" class="tooltip-icon"></iconify-icon>
                                                </a>
                                                <a href="{{ buyerSellerRoute('listing.edit', ['description', $listing->enc_id]) }}"
                                                    class="edit tooltip-btn edit-btn" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit">
                                                    <iconify-icon icon="lucide:edit" class="tooltip-icon"></iconify-icon>
                                                </a>
                                                <a href="{{ buyerSellerRoute('listing.delivery-items', $listing->enc_id) }}"
                                                    class="delete tooltip-btn tooltip-btn-2 delivery-btn"
                                                    data-id="{{ $listing->enc_id }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Set Delivery Items">
                                                    <iconify-icon icon="lucide:truck" class="tooltip-icon"></iconify-icon>
                                                    {{ __('Set Delivery') }}
                                                </a>
                                                <button href=""
                                                    data-href="{{ buyerSellerRoute('listing.delete', $listing->enc_id) }}"
                                                    class="delete tooltip-btn common-modal-button delete-btn"
                                                    data-id="{{ $listing->enc_id }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete">
                                                    <iconify-icon icon="lucide:trash-2" class="tooltip-icon"></iconify-icon>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <x-luminous.no-data-found type="Listing" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $listings->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!-- app page body contents end -->
    <div class="common-modal-full">
        <div class="common-modal-box common-modal-box-2">
            <div class="content">
                <div class="delete-modal">
                    <div class="icon">
                        <iconify-icon icon="ic:round-warning" class="warning-icon"></iconify-icon>
                    </div>
                    <h4>{{ __('Are you sure you want to delete?') }}</h4>
                    <p>{{ __('You will not be able to undo this action.') }}</p>
                    <div class="modal-action-btn">
                        <a href="" class="primary-button delete-form-btn">{{ __('Delete') }}</a>
                        <button class="primary-button border-btn close">{{ __('Cancel') }}</button>
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
        $(document).on('click', '.delete-btn', function() {
            var url = $(this).data('href');
            $('.delete-form-btn').attr('href', url);
        })
    </script>
@endpush
