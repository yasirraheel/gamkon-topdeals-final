<div class="choose-common">
    <h4>{{ __('Review Product') }}</h4>
    <div class="all-common all-common-2">
        <div class="selected-category-review">
            <h5>{{ __('Product Information') }}</h5>
            <div class="your-selected-category">
                <div class="selected-cat-sub-cat">
                    <p><span>{{ __('Category') }}:</span> {{ $listing->category->name }}</p>
                    @if ($listing->subcategory)
                        <p><span>{{ __('Sub Category') }}:</span> {{ $listing->subcategory->name }}</p>
                    @endif
                    @if ($listing->productCatalog)
                        <p><span>{{ __('Product') }}:</span> {{ $listing->productCatalog->name }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="all-common all-common-2">
        <div class="your-product-details">
            <h5 class="title">{{ __('Product Details') }}</h5>
            <div class="product-name">
                <h5 class="name-title">{{ __('Name') }} :</h5>
                <p class="name-product">{{ $listing->product_name }}</p>
            </div>
            @if ($listing->selected_duration)
                <div class="product-name">
                    <h5 class="name-title">{{ __('Duration') }} :</h5>
                    <p class="name-product">{{ $listing->selected_duration }}</p>
                </div>
            @endif
            @if ($listing->selected_plan)
                <div class="product-name">
                    <h5 class="name-title">{{ __('Sharing Method') }} :</h5>
                    <p class="name-product">{{ $listing->selected_plan }}</p>
                </div>
            @endif
            <div class="product-name">
                <h5 class="name-title">{{ __('Price') }} :</h5>
                <p class="name-product">{{ setting('currency_symbol', 'global') }}{{ $listing->price }}</p>
            </div>
            @if ($listing->discount_value)
                <div class="product-name">
                    <h5 class="name-title">{{ __('Discount') }} :</h5>
                    <p class="name-product">
                        {{ $listing->discount_type == 'percentage' ? $listing->discount_value . '%' : setting('currency_symbol', 'global') . $listing->discount_value }}
                    </p>
                </div>
                <div class="product-name">
                    <h5 class="name-title">{{ __('Final Price') }} :</h5>
                    <p class="name-product">{{ setting('currency_symbol', 'global') }}{{ $listing->final_price }}</p>
                </div>
            @endif
            <div class="product-name">
                <h5 class="name-title">{{ __('Quantity') }} :</h5>
                <p class="name-product">{{ $listing->quantity }}</p>
            </div>
        </div>
    </div>
    <div class="all-common all-common-2">
        <div class="delivary-method-box">
            <h5>{{ __('Delivery') }}</h5>
            <div class="delivary-method">
                <p><span class="name-title">{{ __('Method') }}:</span> {{ ucwords($listing->delivery_method) }}</p>
            </div>
        </div>
    </div>
    <form method="post" action="{{ buyerSellerRoute('listing.create', ['confirm', $listing->enc_id]) }}">
        @csrf
        <div class="confirm-listing-button">
            <button class="primary-button primary-button-blue xl-btn w-100">{{ __('Confirm Listing') }}</button>
        </div>
    </form>
</div>
