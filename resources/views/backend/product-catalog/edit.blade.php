@extends('backend.layouts.app')
@section('title')
    {{ __('Edit Product Catalog') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit Product Catalog') }}</h2>
                            <a href="{{ route('admin.product-catalog.index') }}" class="title-btn"><i
                                    data-lucide="arrow-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.product-catalog.update', $catalog->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Product Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="box-input mb-0" value="{{ old('name', $catalog->name) }}"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Order') }}</label>
                                            <input type="number" name="order" class="box-input mb-0" value="{{ old('order', $catalog->order) }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Status') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-active" name="status" value="1"
                                                    @checked(old('status', $catalog->status) == 1) required />
                                                <label for="radio-active">{{ __('Active') }}</label>
                                                <input type="radio" id="radio-inactive" name="status" value="0"
                                                    @checked(old('status', $catalog->status) == 0) required />
                                                <label for="radio-inactive">{{ __('Inactive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Icon') }}</label>
                                            <div class="wrap-custom-file">
                                                <input type="file" name="icon" id="icon" accept=".gif, .jpg, .png, .svg">
                                                <label for="icon" @if($catalog->icon) class="file-ok" style="background-image: url({{ asset($catalog->icon) }})" @endif>
                                                    <img class="upload-icon d-block" src="{{ asset('global/materials/upload.svg') }}" alt="">
                                                    <span>{{ __('Upload Icon') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Thumbnail') }}</label>
                                            <div class="wrap-custom-file">
                                                <input type="file" name="thumbnail" id="thumbnail" accept=".gif, .jpg, .png">
                                                <label for="thumbnail" @if($catalog->thumbnail) class="file-ok" style="background-image: url({{ asset($catalog->thumbnail) }})" @endif>
                                                    <img class="upload-icon d-block" src="{{ asset('global/materials/upload.svg') }}" alt="">
                                                    <span>{{ __('Upload Thumbnail') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Description') }}</label>
                                            <textarea name="description" class="box-input mb-0" rows="4">{{ old('description', $catalog->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Durations') }}</label>
                                            <div id="durations-container">
                                                @if(old('durations', $catalog->durations))
                                                    @foreach(old('durations', $catalog->durations ?? []) as $index => $duration)
                                                        <div class="duration-item mb-2 d-flex gap-2">
                                                            <input type="text" name="durations[]" class="box-input mb-0"
                                                                placeholder="e.g., 30 Days, 1 Month, etc." value="{{ $duration }}" />
                                                            <button type="button" class="btn btn-sm btn-danger remove-duration" style="{{ count(old('durations', $catalog->durations ?? [])) > 1 ? '' : 'display: none;' }}">
                                                                <i data-lucide="x"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="duration-item mb-2 d-flex gap-2">
                                                        <input type="text" name="durations[]" class="box-input mb-0"
                                                            placeholder="e.g., 30 Days, 1 Month, etc." />
                                                        <button type="button" class="btn btn-sm btn-danger remove-duration" style="display: none;">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-duration">
                                                <i data-lucide="plus"></i> {{ __('Add Duration') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Sharing Methods') }}</label>
                                            <div id="sharing-methods-container">
                                                @if(old('sharing_methods', $catalog->sharing_methods))
                                                    @foreach(old('sharing_methods', $catalog->sharing_methods ?? []) as $index => $method)
                                                        <div class="sharing-method-item mb-2 d-flex gap-2">
                                                            <input type="text" name="sharing_methods[]" class="box-input mb-0"
                                                                placeholder="e.g., Email, Phone, Link, etc." value="{{ $method }}" />
                                                            <button type="button" class="btn btn-sm btn-danger remove-sharing-method" style="{{ count(old('sharing_methods', $catalog->sharing_methods ?? [])) > 1 ? '' : 'display: none;' }}">
                                                                <i data-lucide="x"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="sharing-method-item mb-2 d-flex gap-2">
                                                        <input type="text" name="sharing_methods[]" class="box-input mb-0"
                                                            placeholder="e.g., Email, Phone, Link, etc." />
                                                        <button type="button" class="btn btn-sm btn-danger remove-sharing-method" style="display: none;">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-sharing-method">
                                                <i data-lucide="plus"></i> {{ __('Add Sharing Method') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Plans') }}</label>
                                            <div id="plans-container">
                                                @if(old('plans', $catalog->plans))
                                                    @foreach(old('plans', $catalog->plans ?? []) as $index => $plan)
                                                        <div class="plan-item mb-2 d-flex gap-2">
                                                            <input type="text" name="plans[]" class="box-input mb-0"
                                                                placeholder="e.g., Pro, Ultra, Premium" value="{{ $plan }}" />
                                                            <button type="button" class="btn btn-sm btn-danger remove-plan" style="{{ count(old('plans', $catalog->plans ?? [])) > 1 ? '' : 'display: none;' }}">
                                                                <i data-lucide="x"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="plan-item mb-2 d-flex gap-2">
                                                        <input type="text" name="plans[]" class="box-input mb-0"
                                                            placeholder="e.g., Pro, Ultra, Premium" />
                                                        <button type="button" class="btn btn-sm btn-danger remove-plan" style="display: none;">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-plan">
                                                <i data-lucide="plus"></i> {{ __('Add Plan') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="check"></i>
                                        {{ __('Update Product Catalog') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function() {
        function updateRemoveButtons(type) {
            const items = document.querySelectorAll(`.${type}-item`);
            items.forEach((item, index) => {
                const removeBtn = item.querySelector(`.remove-${type}`);
                if (removeBtn) {
                    if (items.length > 1) {
                        removeBtn.style.display = 'block';
                    } else {
                        removeBtn.style.display = 'none';
                    }
                }
            });
        }

        // Add Duration
        const addDurationBtn = document.getElementById('add-duration');
        if (addDurationBtn) {
            addDurationBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('durations-container');
                const newItem = document.createElement('div');
                newItem.className = 'duration-item mb-2 d-flex gap-2';
                newItem.innerHTML = `
                    <input type="text" name="durations[]" class="box-input mb-0" placeholder="e.g., 30 Days, 1 Month, etc." />
                    <button type="button" class="btn btn-sm btn-danger remove-duration">
                        <i data-lucide="x"></i>
                    </button>
                `;
                container.appendChild(newItem);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                updateRemoveButtons('duration');
            });
        }

        // Add Sharing Method
        const addSharingBtn = document.getElementById('add-sharing-method');
        if (addSharingBtn) {
            addSharingBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('sharing-methods-container');
                const newItem = document.createElement('div');
                newItem.className = 'sharing-method-item mb-2 d-flex gap-2';
                newItem.innerHTML = `
                    <input type="text" name="sharing_methods[]" class="box-input mb-0" placeholder="e.g., Email, Phone, Link, etc." />
                    <button type="button" class="btn btn-sm btn-danger remove-sharing-method">
                        <i data-lucide="x"></i>
                    </button>
                `;
                container.appendChild(newItem);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                updateRemoveButtons('sharing-method');
            });
        }

        // Add Plan
        const addPlanBtn = document.getElementById('add-plan');
        if (addPlanBtn) {
            addPlanBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('plans-container');
                const newItem = document.createElement('div');
                newItem.className = 'plan-item mb-2 d-flex gap-2';
                newItem.innerHTML = `
                    <input type="text" name="plans[]" class="box-input mb-0" placeholder="e.g., Pro, Ultra, Premium" />
                    <button type="button" class="btn btn-sm btn-danger remove-plan">
                        <i data-lucide="x"></i>
                    </button>
                `;
                container.appendChild(newItem);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                updateRemoveButtons('plan');
            });
        }

        // Remove handlers
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-duration')) {
                e.preventDefault();
                e.target.closest('.duration-item').remove();
                updateRemoveButtons('duration');
            }
            if (e.target.closest('.remove-sharing-method')) {
                e.preventDefault();
                e.target.closest('.sharing-method-item').remove();
                updateRemoveButtons('sharing-method');
            }
            if (e.target.closest('.remove-plan')) {
                e.preventDefault();
                e.target.closest('.plan-item').remove();
                updateRemoveButtons('plan');
            }
        });

        // Initialize remove buttons on load
        updateRemoveButtons('duration');
        updateRemoveButtons('sharing-method');
        updateRemoveButtons('plan');
    })();
</script>
@endsection
