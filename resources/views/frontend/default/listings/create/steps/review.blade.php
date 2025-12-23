<div class="choose-common">
    <h4>{{ __('Review Product') }}</h4>
    <div class="all-common all-common-2">
        <div class="selected-category-review">
            <h5>{{ __('Category You Want to Sell') }}</h5>
            <div class="your-selected-category">

                <div class="selected-cat-sub-cat">
                    <p><span>{{ __('Category') }}:</span> {{ $listing->category->name }}</p>
                    @if ($listing->subcategory)
                        <p><span>{{ __('Sub Category') }}:</span> {{ $listing->subcategory->name }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="all-common all-common-2">
        <div class="your-product-details">
            <h5 class="title">{{ __('Your Product Details') }}</h5>
            <div class="product-name">
                <h5 class="name-title">{{ __('Name') }} :</h5>
                <p class="name-product">{{ $listing->product_name }}</p>
            </div>
            <div class="product-name">
                <h5 class="name-title">{{ __('Price') }} :</h5>
                <p class="name-product">${{ $listing->price }}</p>
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
                    <p class="name-product">{{ setting('currency_symbol', 'global') . $listing->final_price }}</p>
                </div>
            @endif
            <div class="product-name">
                <h5 class="name-title">{{ __('Quantity') }} :</h5>
                <p class="name-product">{{ $listing->quantity }}</p>
            </div>
            <div class="product-name d-block">
                <h5 class="name-title">{{ __('Description') }} : </h5>
                <br>
                <p>{!! $listing->description !!}</p>
            </div>
        </div>
    </div>
    <div class="all-common all-common-2">
        <div class="uploaded-image">
            <h5>{{ __('Product Images') }}</h5>
            <div class="thumbnail-box">
                <h6>{{ __('Thumbnail Image') }}</h6>
                <div class="thumbnail-image">
                    <div class="thumbnail-image-box">
                        <div class="img">
                            <img src="{{ asset($listing->thumbnail) }}" alt="{{ $listing->product_name }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="gallery-box">
                <h6>{{ __('Gallery Image') }}</h6>
                <div class="all-img">
                    @foreach ($listing->images as $image)
                        <div class="gallery-img">
                            <img src="{{ asset($image->image_path) }}" alt="{{ $listing->product_name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="all-common all-common-2">
        <div class="delivary-method-box">
            <h5>{{ __('Delivery Method') }}</h5>
            <div class="delivary-method">
                <div class="td-form-group has-right-icon">
                    <div class="input-field">
                        <input type="text" class="form-control"
                            placeholder="{{ ucwords($listing->delivery_method) }}" disabled>
                    </div>
                    <span
                        class="form-info">{{ __($listing->delivery_method == 'auto' ? 'Product automatically send the product upon purchase.' : 'Product will be send manually after purchase.') }}</span>
                </div>
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
