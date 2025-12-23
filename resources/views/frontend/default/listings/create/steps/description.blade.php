@push('style')
    <link href="{{ themeAsset('css/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ themeAsset('css/select2.min.css') }}">
    <style>
        .select2-results__option:hover {
            background: #1a1e30;
            cursor: pointer;
        }

        .select2-container--default .select2-results>.select2-results__options {
            border-radius: 0 0 3px 3px;
        }

        .switcher-card h5 {
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.4285714286;
            margin-bottom: 8px;
        }

        [name="discount_type"] option {
            background: var(--td-bg);
        }

        .nice-select-active.open .list {
            width: 100%;
        }

        .discount-value::-webkit-inner-spin-button {
            margin-left: 20px;
        }
    </style>
@endpush
@use('App\Enums\ListingStatus')

<div class="choose-common">
    <h4>{{ __('Product Details') }}</h4>
    <div class="all-common">
        <div class="selected-category">
            <div class="title">
                <h6>{{ __('Selected Category') }}:</h6>
            </div>
            <ul>
                <li>{{ $categoryData['category']['name'] }}</li>
                @if ($categoryData['subcategory'])
                    <li>{{ $categoryData['subcategory']['name'] }}</li>
                @endif
            </ul>
        </div>
        <form class="product-details-form" method="post" action="{{ buyerSellerRoute('listing.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row gy-3">
                @if ($listing?->category_id)
                    <div class="col-12">
                        <div class="td-form-group">
                            <label class="input-label" for="selectCategory">{{ __('Category') }}</label>
                            <div class="auth-nice-select auth-nice-select-2">
                                <select id="selectCategory" class="nice-select-active" name="category_id">
                                    @foreach ($data['categories'] as $category)
                                        <option data-image="{{ asset($category->image) }}" value="{{ $category->id }}"
                                            @selected($category->id == request('category_id', $listing?->category_id))>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="listing_id" value="{{ $listing->enc_id }}">
                @else
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    <input type="hidden" name="subcategory_id" value="{{ request('subcategory_id') }}">
                @endif
                <div class="col-12">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Product Name') }} <span>*</span></label>
                        <div class="input-field">
                            <input type="text" name="product_name"
                                value="{{ old('product_name', $listing?->product_name ?? '') }}" class="form-control"
                                required>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group custom-quill-editor">
                        <label class="input-label">{{ __('Description') }} <span>*</span></label>
                        <textarea type="hidden" id="editor" name="description">{{ old('description', $listing?->description ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Price') }} <span>*</span></label>
                        <div class="input-field input-group">
                            <input name="price" value="{{ old('price', $listing?->price ?? '') }}" type="number"
                                class="form-control" required>
                            <div class="right-dropdown me-3">
                                {{ $currencySymbol }}
                            </div>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Quantity') }} <span>*</span></label>
                        <div class="input-field">
                            <input value="{{ old('quantity', $listing?->quantity ?? '') }}" name="quantity"
                                type="number" class="form-control" required>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Discount') }}</label>
                        <div class="input-field input-group">
                            <input value="{{ old('discount_value', $listing?->discount_value ?? '0') }}"
                                name="discount_value" step="0.05" type="number" class="form-control discount-value">
                            <div class="right-dropdown">
                                <div class="form-right-dropdown-nice-select">
                                    <select name="discount_type" class="nice-select-active">
                                        <option value="percentage"
                                            {{ old('discount_type', $listing?->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                            %</option>
                                        <option value="amount"
                                            {{ old('discount_type', $listing?->discount_type ?? '') == 'amount' ? 'selected' : '' }}>
                                            {{ setting('currency_symbol', 'global') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-title">
                        <h5>{{ __('Upload Image') }}</h5>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group">
                        <label class="input-label">{{ __('Thumbnail') }} <span>*</span></label>
                        <div class="custom-file-input">
                            <button type="button" class="upload-btn {{ !$listing?->thumbnail ? '' : 'hidden' }} "
                                id="uploadBtn">{{ __('Upload Photo') }}</button>
                            <input type="file" name="thumbnail" class="hidden" accept="image/*">
                            <div class="preview-area preview-area-2 {{ $listing?->thumbnail ? '' : 'hidden' }}">
                                <img class="previewImg"
                                    src="{{ $listing?->thumbnail ? asset($listing?->thumbnail ?? '') : '' }}"
                                    alt="Preview">
                                <p class="fileName"></p>
                                <span class="remove-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M15 9L9 15L15 9ZM9 9L15 15L9 9ZM22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                            fill="#FF5353" fill-opacity="0.3" />
                                        <path
                                            d="M15 9L9 15M9 9L15 15M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                            stroke="#FF5353" stroke-width="0.8" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group">
                        <label class="input-label">{{ __('Gallery Photo') }} <small class="ms-1">
                                ({{ __('Multiple select, Max 5') }})</small> <span>*</span></label>
                        <div class="custom-file-input">
                            <button type="button" class="upload-btn">{{ __('Upload Photos') }}</button>
                            <input type="file" name="gallery[]" class="hidden" accept="image/*" multiple>
                            <div class="preview-area {{ $listing?->images ? '' : 'hidden' }}">
                                @if ($listing?->images)
                                    @foreach ($listing?->images as $image)
                                        <div class="image-container">
                                            <img src="{{ asset($image->image_path) }}"
                                                alt="{{ $listing?->product_name }}">
                                            <span data-id="{{ encrypt($image->id) }}"
                                                class="remove-btn listing-gallery-remove">×</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if ($listing)
                    <div class="switchers">
                        <div class="custom-switch-btn">
                            <div class="title">
                                <p>{{ __('Status') }}</p>
                            </div>
                            <div class="bootstrap-custom-switcher">
                                <div class="form-check form-switch">
                                    <input name="status" class="form-check-input" type="checkbox" id="statusSwitch"
                                        value="{{ ListingStatus::Active }}" @checked($listing->status == 'active')>
                                </div>
                            </div>
                        </div>

                        <div class="custom-switch-btn">
                            <div class="title">
                                <p>{{ __('Add to Flash Sale') }}</p>
                            </div>
                            <div class="bootstrap-custom-switcher">
                                <div class="form-check form-switch">
                                    <input name="is_flash" class="form-check-input" type="checkbox"
                                        id="flashSaleSwitch" value="1" @checked($listing->is_flash)>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="set-infomation-btn">
                        <button type="submit"
                            class="primary-button primary-button-full xl-btn primary-button-blue w-100">
                            @if ($listing)
                                {{ __('Update Information') }}
                            @else
                                {{ __('Set Information') }}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script src="{{ themeAsset('/js/summernote.min.js') }}"></script>
    <script>
        "use strict";

        $(document).ready(function() {
            $('#editor').summernote({
                height: 200,
                height: 220,
                codeviewFilter: true,
                codeviewIframeFilter: true,
                callbacks: {
                    onChangeCodeview: function(contents, editable) {
                        $(this).val(contents);
                    },
                },
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "italic", "underline", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["insert", ["link", "picture"]],
                    ["view", ["codeview"]],
                ],
                styleTags: ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
                placeholder: "Write...",
                tabsize: 2,

            });
        });


        $(document).on('click', '.listing-gallery-remove', function() {
            var id = $(this).data('id');
            var url = '{{ buyerSellerRoute('listing.gallery.delete', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $(this).closest('.image-container').remove();
                    }
                }
            });
        });
    </script>
@endpush
