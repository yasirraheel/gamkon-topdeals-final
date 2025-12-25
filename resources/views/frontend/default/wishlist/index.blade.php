@extends('frontend::layouts.user')
@section('title')
    {{ __('Wishlist') }}
@endsection

@section('content')
    <div class="transactions-history-box">
        <x-luminous.dashboard-breadcrumb title="{{ __('Wishlist') }}" />
    </div>
    <div class="common-table">
        <div class="common-table-full">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">{{ __('Image') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Category') }}</th>
                        <th scope="col">{{ __('Author') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlist as $listing)
                        <tr>
                            <th>
                                <div class="Product-image">
                                    <img src="{{ asset($listing->thumbnail) }}" alt="">
                                </div>
                            </th>
                            <td>
                                {{ $listing->product_name }}
                            </td>
                            <td>{{ $listing->category->name }}

                                @if ($listing->subcategory_id)
                                    <span class="category-label"> > {{ $listing->subcategory->name }}</span>
                                @endif

                            </td>
                            <td>
                                {{ $listing->seller->username }}
                                @if($listing->seller->kyc == \App\Enums\KYCStatus::Verified->value)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#3b82f6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-left: 2px;" title="{{ __('Verified Seller') }}" data-bs-toggle="tooltip">
                                        <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.78 4.78 4 4 0 0 1-6.74 0 4 4 0 0 1-4.78-4.78 4 4 0 0 1 0-6.74z"></path>
                                        <polyline points="9 11 12 14 22 4"></polyline>
                                    </svg>
                                @endif
                            </td>
                            <td class="main-price-and-discount">
                                <p class="discount-price fw-bolder">{{ $currency . $listing->final_price }}</p>
                                @if ($listing->discount_amount > 0)
                                    <p class="main-price text-decoration-line-through">{{ $currency . $listing->price }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                <div class="tooltip-action-btns">

                                    <a href="{{ route('listing.details', $listing->slug) }}" type="button"
                                        class="tooltip-btn common-modal-button delete-btn" data-bs-toggle="tooltip"
                                        data-bs-title="Delete">
                                        <iconify-icon icon="lucide:trash-2" class="tooltip-icon"></iconify-icon>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <x-luminous.no-data-found type="Wishlist" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="wishlist-card">
        <div class="table-pagination">
            <div class="pagination">
                {{ $wishlist->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
