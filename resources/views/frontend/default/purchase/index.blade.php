@extends('frontend::layouts.user')
@section('title')
    {{ __('Purchased Items') }}
@endsection

@section('content')
    <div class="app-page-full-body">
        <div class="transactions-history-box sold-orders-box">
            <x-luminous.dashboard-breadcrumb title="{{ __('Purchased Items (:count)', ['count' => $count]) }}">
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
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="">{{ __('Order Number') }}</th>
                                    <th scope="col" class="">{{ __('Order Date') }}</th>
                                    <th scope="col" class="">{{ __('Product') }}</th>
                                    <th scope="col" class="">{{ __('Category') }}</th>
                                    <th scope="col" class="">{{ __('Order Status') }}</th>
                                    <th scope="col" class="">{{ __('Price') }}</th>
                                    <th scope="col" class="">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <th scope="row" class="">#{{ $order->order_number }}</th>
                                        <th scope="row" class="">{{ orderDateFormat($order->created_at) }}</th>
                                        <td class="">
                                            @if ($order->is_topup)
                                                {{ __('Topup') . ' #' . $order->order_number }}
                                            @else
                                                <a class="link"
                                                    href="{{ route('listing.details', $order->listing?->slug ?? 404) }}">{{ $order->listing?->product_name }}</a>
                                            @endif
                                        </td>
                                        <td class="">{{ $order->listing?->category?->name ?? 'N/A' }}</td>
                                        <td class="">
                                            {!! $order->status_badge !!}
                                        </td>
                                        <td class="">{{ $currencySymbol . $order->total_price }}</td>
                                        <td class="">
                                            <div class="tooltip-action-btns">
                                                <a data-bs-toggle="tooltip" class="tooltip-btn view-btn"
                                                    data-bs-placement="top" title="{{ __('Invoice') }}"
                                                    href="{{ buyerSellerRoute('purchase.invoice', $order->order_number) }}"
                                                    class="edit common-action-button"><iconify-icon icon="lucide:eye"
                                                        class="tooltip-icon"></iconify-icon></a>
                                                @if ($order->status == \App\Enums\OrderStatus::Completed->value)
                                                    <a data-bs-toggle="tooltip" class="tooltip-btn edit-btn"
                                                        data-bs-placement="top" title="{{ __('Delivered Items') }}"
                                                        href="{{ buyerSellerRoute('purchase.deliveryItems', $order->order_number) }}"
                                                        class="edit common-action-button ms-2">
                                                        <iconify-icon icon="lucide:truck"
                                                            class="tooltip-icon"></iconify-icon>
                                                    </a>
                                                    @if ($order->review && $order->review->status->value == 'rejected')
                                                        <span data-bs-toggle="tooltip"
                                                            data-bs-title="{{ $order->review->admin_notes }}"
                                                            class="text-danger">{{ __('Review Rejected') }}</span>
                                                    @else
                                                        <a href="javascript:void(0)" type="button"
                                                            class="tooltip-btn common-modal-button add-review-btn delivery-btn"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-rate="{{ $order->review?->rating }}"
                                                            data-review="{{ $order->review?->review }}"
                                                            data-bs-title="Add Review" data-order-id="{{ $order->id }}">
                                                            <iconify-icon icon="lucide:star"
                                                                class="tooltip-icon"></iconify-icon>
                                                        </a>
                                                    @endif
                                                @endif
                                                <a data-bs-toggle="tooltip" class="tooltip-btn view-btn"
                                                    data-bs-placement="top" title="{{ __('Chat with seller') }}"
                                                    href="{{ buyerSellerRoute('chat.index', $order->listing?->seller?->username ?? 404) }}"
                                                    class="edit common-action-button"><iconify-icon
                                                        icon="lucide:message-square"
                                                        class="tooltip-icon"></iconify-icon></a>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <x-luminous.no-data-found type="Purchased Item" />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="table-pagination">
                            <div class="pagination">
                                {{ $orders->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="common-modal-full" id="reviewModal">
        <div class="common-modal-box">
            <div class="content">
                <div class="add-review-box">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>{{ __('Share Your Experience') }}</h4>
                    </div>

                    <div class="give-review">
                        <div class="review-box">
                            <form class="rating-container" id="reviewForm"
                                action="{{ buyerSellerRoute('purchase.review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" id="orderId">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <label class="input-label">{{ __('Rating') }} <span>*</span></label>
                                        <div class="rating">
                                            <input type="radio" name="rating" value="5" id="5" required>
                                            <label for="5">☆</label>
                                            <input type="radio" name="rating" value="4" id="4" required>
                                            <label for="4">☆</label>
                                            <input type="radio" name="rating" value="3" id="3" required>
                                            <label for="3">☆</label>
                                            <input type="radio" name="rating" value="2" id="2" required>
                                            <label for="2">☆</label>
                                            <input type="radio" name="rating" value="1" id="1" required>
                                            <label for="1">☆</label>
                                        </div>
                                        <p class="feedback-invalid rating-error" style="display: none;">
                                            {{ __('Please select a rating') }}</p>
                                    </div>

                                    <div class="col-12">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Review Message') }} <span>*</span></label>
                                            <div class="input-field">
                                                <textarea name="review" id="reviewMessage" placeholder="{{ __('Share your experience with this product...') }}"
                                                    required minlength="10" maxlength="1000"></textarea>
                                            </div>
                                            <p class="feedback-invalid review-error" style="display: none;">
                                                {{ __('Review message is required (minimum 10 characters)') }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="auth-action">
                                            <button type="submit" class="primary-button xl-btn w-100" id="submitReview">
                                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                                    aria-hidden="true" style="display: none;"></span>
                                                {{ __('Submit Review') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            'use strict';

            // Sort functionality
            $(document).on('change', '.sort-listing', function() {
                $('#filterForm').submit();
            });

            // Review modal functionality
            $('.add-review-btn').on('click', function() {
                const orderId = $(this).data('order-id');
                const rating = $(this).data('rate');
                const review = $(this).data('review');
                $('#reviewMessage').val(review);
                $('input[name="rating"][value="' + rating + '"]').prop('checked', true);
                $('#orderId').val(orderId);
            });
        });
    </script>
@endpush
