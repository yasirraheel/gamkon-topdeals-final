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

        /* Fix Select2 Dark Mode */
        .select2-container--default .select2-selection--multiple {
            background-color: #111827 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 8px;
            min-height: 48px;
            padding: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: #fff !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            color: #fff !important;
            font-family: inherit;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--td-primary) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 4px;
            padding: 4px 8px;
            margin-top: 6px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 5px;
            border-right: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: rgba(0, 0, 0, 0.1) !important;
            color: #fff !important;
        }

        .select2-dropdown {
            background-color: #111827 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            z-index: 9999;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--td-primary) !important;
            color: #fff !important;
        }

        .select2-results__option {
            color: #fff !important;
            padding: 8px 12px;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        .select2-results__option:hover {
            background-color: #1a1e30 !important;
            color: #fff !important;
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
            <div class="row g-3">
                @if ($listing?->category_id)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="td-form-group">
                            <label class="input-label" for="selectCategory">{{ __('Category') }}</label>
                            <div class="auth-nice-select auth-nice-select-2">
                                <select id="selectCategory" class="nice-select-active" name="category_id">
                                    @foreach ($data['categories'] as $category)
                                        <option data-image="{{ $category->image ? asset($category->image) : '' }}" value="{{ $category->id }}"
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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectProductCatalog">{{ __('Product Catalog') }} <span>*</span></label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectProductCatalog" class="nice-select-active" name="product_catalog_id" required>
                                <option value="">{{ __('Select Product Catalog') }}</option>
                                @foreach ($data['productCatalogs'] as $catalog)
                                    <option data-image="{{ $catalog->icon ? asset($catalog->icon) : '' }}" value="{{ $catalog->id }}"
                                        @selected($catalog->id == old('product_catalog_id', $listing?->product_catalog_id))>{{ $catalog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Product Name') }} <span>*</span></label>
                        <div class="input-field">
                            <input type="text" name="product_name" id="product_name"
                                value="{{ old('product_name', $listing?->product_name ?? '') }}" class="form-control"
                                required>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectDuration">{{ __('Duration') }} <span>*</span></label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectDuration" class="nice-select-active" name="selected_duration" required>
                                <option value="">{{ __('Select Duration') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectPlan">{{ __('Sharing Method') }} <span>*</span></label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectPlan" class="nice-select-active" name="selected_plan" required>
                                <option value="">{{ __('Select Sharing Method') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectProductPlan">{{ __('Plan') }} <span>*</span></label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectProductPlan" class="nice-select-active" name="plan_id" required>
                                <option value="">{{ __('Select Plan') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectRegion">{{ __('Region') }}</label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectRegion" class="select2" name="region[]" multiple>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group">
                        <label class="input-label" for="selectDevices">{{ __('Supported Devices') }}</label>
                        <div class="auth-nice-select auth-nice-select-2">
                            <select id="selectDevices" class="select2" name="devices[]" multiple>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Guarantee Period') }}</label>
                        <div class="input-field">
                            <input type="text" name="guarantee_period" id="guarantee_period"
                                value="{{ old('guarantee_period', $listing?->guarantee_period ?? '') }}" class="form-control"
                                placeholder="{{ __('e.g., 30 Days, 1 Year, Lifetime') }}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="td-form-group custom-quill-editor">
                        <label class="input-label">{{ __('Description') }} <span>*</span></label>
                        <textarea type="hidden" id="editor" name="description">{{ old('description', $listing?->description ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="td-form-group has-right-icon">
                        <label class="input-label">{{ __('Quantity') }} <span>*</span></label>
                        <div class="input-field">
                            <input value="{{ old('quantity', $listing?->quantity ?? '') }}" name="quantity"
                                type="number" class="form-control" required>
                        </div>
                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
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
                <div class="col-12 col-lg-6">
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
                <div class="col-12 col-lg-6">
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
    {{-- Select2 script removed to prevent conflict --}}
    <script>
        "use strict";

        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            // Dynamic Product Name Generation
            function updateProductName() {
                var catalogName = $('#selectProductCatalog option:selected').text().trim();
                var plan = $('#selectProductPlan').val();
                var duration = $('#selectDuration').val();
                
                // Only auto-update if catalog is selected
                if (catalogName && catalogName !== 'Select Product Catalog') {
                    var nameParts = [catalogName];
                    
                    if (plan && plan !== 'Select Plan') {
                        nameParts.push(plan);
                    }
                    if (duration && duration !== 'Select Duration') {
                        nameParts.push(duration);
                    }
                    
                    // Join with spaces or specific format
                    $('#product_name').val(nameParts.join(' '));
                }
            }

            // Listen for changes
            $('#selectProductCatalog, #selectProductPlan, #selectDuration').on('change', function() {
                // Only update if the user hasn't manually edited (optional check, or just overwrite)
                // For now, we overwrite as requested "dynamicly set"
                updateProductName();
            });

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

        // Handle catalog gallery remove (just visual, not saved yet)
        $(document).on('click', '.catalog-gallery-remove', function() {
            $(this).closest('.image-container').remove();
            var galleryContainer = $('input[name="gallery[]"]').closest('.custom-file-input');
            if (galleryContainer.find('.preview-area .image-container').length === 0) {
                galleryContainer.find('.preview-area').addClass('hidden');
            }
        });

        // Handle product catalog selection
        $('#selectProductCatalog').on('change', function() {
            var catalogId = $(this).val();
            
            if (!catalogId) {
                // Clear all fields if no catalog selected
                $('#product_name').val('');
                $('#selectDuration').html('<option value="">{{ __('Select Duration') }}</option>');
                $('#selectPlan').html('<option value="">{{ __('Select Sharing Method') }}</option>');
                $('#selectProductPlan').html('<option value="">{{ __('Select Plan') }}</option>');
                $('#selectRegion').html('<option value="">{{ __('Select Region') }}</option>');
                $('#selectDevices').html('<option value="">{{ __('Select Devices') }}</option>');
                $('.nice-select-active').niceSelect('update');
                return;
            }

            // Fetch catalog data via AJAX
            $.ajax({
                url: '{{ buyerSellerRoute('listing.catalog.data', ':id') }}'.replace(':id', catalogId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        
                        // Set product name (only if empty or creating new listing)
                        if (!$('#product_name').val() || $('#product_name').val() === '') {
                            $('#product_name').val(data.name);
                        }
                        
                        // Get saved values for editing
                        var savedDuration = '{{ old('selected_duration', $listing?->selected_duration ?? '') }}';
                        var savedPlan = '{{ old('selected_plan', $listing?->selected_plan ?? '') }}';
                        var savedProductPlan = '{{ old('plan_id', $listing?->plan_id ?? '') }}';
                        var savedRegion = '{{ old('region', $listing?->region ?? '') }}';
                        var savedDevices = '{{ old('devices', $listing?->devices ?? '') }}';
                        
                        // Populate duration dropdown
                        var durationOptions = '<option value="">{{ __('Select Duration') }}</option>';
                        if (data.durations && data.durations.length > 0) {
                            data.durations.forEach(function(duration) {
                                if (duration && duration.trim() !== '') {
                                    var selected = (duration === savedDuration) ? ' selected' : '';
                                    durationOptions += '<option value="' + duration + '"' + selected + '>' + duration + '</option>';
                                }
                            });
                        }
                        $('#selectDuration').html(durationOptions);
                        
                        // Populate plan dropdown
                        var planOptions = '<option value="">{{ __('Select Sharing Method') }}</option>';
                        if (data.sharing_methods && data.sharing_methods.length > 0) {
                            data.sharing_methods.forEach(function(method) {
                                if (method && method.trim() !== '') {
                                    var selected = (method === savedPlan) ? ' selected' : '';
                                    planOptions += '<option value="' + method + '"' + selected + '>' + method + '</option>';
                                }
                            });
                        }
                        $('#selectPlan').html(planOptions);
                        
                        // Populate product plan dropdown
                        var productPlanOptions = '<option value="">{{ __('Select Plan') }}</option>';
                        if (data.plans && data.plans.length > 0) {
                            data.plans.forEach(function(plan) {
                                if (plan && plan.trim() !== '') {
                                    var selected = (plan === savedProductPlan) ? ' selected' : '';
                                    productPlanOptions += '<option value="' + plan + '"' + selected + '>' + plan + '</option>';
                                }
                            });
                        }
                        $('#selectProductPlan').html(productPlanOptions);

                        // Populate region dropdown
                        var regionOptions = '';
                        if (data.regions && data.regions.length > 0) {
                            data.regions.forEach(function(region) {
                                if (region && region.trim() !== '') {
                                    var isSelected = savedRegion.includes(region); // Check if in saved array/string
                                    var selected = isSelected ? ' selected' : '';
                                    regionOptions += '<option value="' + region + '"' + selected + '>' + region + '</option>';
                                }
                            });
                        }
                        $('#selectRegion').html(regionOptions);

                        // Populate devices dropdown
                        var devicesOptions = '';
                        if (data.platforms && data.platforms.length > 0) {
                            data.platforms.forEach(function(platform) {
                                if (platform && platform.trim() !== '') {
                                    var isSelected = savedDevices.includes(platform);
                                    var selected = isSelected ? ' selected' : '';
                                    devicesOptions += '<option value="' + platform + '"' + selected + '>' + platform + '</option>';
                                }
                            });
                        }
                        $('#selectDevices').html(devicesOptions);
                        
                        // Update nice-select and select2
                        $('.nice-select-active').niceSelect('update');
                        $('.select2').trigger('change');
                        
                        // Load thumbnail if available (only for new listings)
                        var isEditing = {{ $listing ? 'true' : 'false' }};
                        if (data.thumbnail && !isEditing) {
                            // Auto-populate thumbnail preview
                            var thumbnailContainer = $('input[name="thumbnail"]').closest('.custom-file-input');
                            thumbnailContainer.find('.upload-btn').addClass('hidden');
                            thumbnailContainer.find('.preview-area').removeClass('hidden');
                            thumbnailContainer.find('.previewImg').attr('src', data.thumbnail);
                            
                            // Auto-populate gallery with catalog thumbnail
                            var galleryContainer = $('input[name="gallery[]"]').closest('.custom-file-input');
                            galleryContainer.find('.preview-area').removeClass('hidden').html(
                                '<div class="image-container">' +
                                    '<img src="' + data.thumbnail + '" alt="Gallery Image">' +
                                    '<span class="remove-btn catalog-gallery-remove">×</span>' +
                                '</div>'
                            );
                        }
                    }
                },
                error: function() {
                    alert('{{ __('Failed to load catalog data') }}');
                }
            });
        });

        // Trigger change event if editing existing listing with catalog
        @if($listing?->product_catalog_id)
            $(document).ready(function() {
                $('#selectProductCatalog').trigger('change');
            });
        @endif
    </script>
@endpush
