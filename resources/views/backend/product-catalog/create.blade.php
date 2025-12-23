@extends('backend.layouts.app')
@section('title')
    {{ __('Add Product Catalog') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add Product Catalog') }}</h2>
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
                            <form action="{{ route('admin.product-catalog.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Product Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="box-input mb-0" value="{{ old('name') }}"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Order') }}</label>
                                            <input type="number" name="order" class="box-input mb-0" value="{{ old('order') }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Status') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-active" name="status" value="1"
                                                    @checked(old('status', 1) == 1) required />
                                                <label for="radio-active">{{ __('Active') }}</label>
                                                <input type="radio" id="radio-inactive" name="status" value="0"
                                                    @checked(old('status') == 0) required />
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
                                                <label for="icon">
                                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="">
                                                    <span>{{ __('Select Icon') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Thumbnail') }}</label>
                                            <div class="wrap-custom-file">
                                                <input type="file" name="thumbnail" id="thumbnail" accept=".gif, .jpg, .png">
                                                <label for="thumbnail">
                                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="">
                                                    <span>{{ __('Select Thumbnail') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Description') }}</label>
                                            <textarea name="description" class="box-input mb-0" rows="4">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Durations') }}</label>
                                            <div id="durations-container">
                                                <div class="duration-item mb-2 d-flex gap-2">
                                                    <input type="text" name="durations[]" class="box-input mb-0"
                                                        placeholder="e.g., 30 Days, 1 Month, etc." value="{{ old('durations.0') }}" />
                                                    <button type="button" class="btn btn-sm btn-danger remove-duration" style="display: none;">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </div>
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
                                                <div class="sharing-method-item mb-2 d-flex gap-2">
                                                    <input type="text" name="sharing_methods[]" class="box-input mb-0"
                                                        placeholder="e.g., Email, Phone, Link, etc." value="{{ old('sharing_methods.0') }}" />
                                                    <button type="button" class="btn btn-sm btn-danger remove-sharing-method" style="display: none;">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </div>
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
                                            <label for="" class="box-input-label">{{ __('Select Plans') }}</label>
                                            <select name="plans[]" class="form-select" multiple style="height: 200px;">
                                                @foreach($plans as $plan)
                                                    <option value="{{ $plan->id }}" @selected(in_array($plan->id, old('plans', [])))>
                                                        {{ $plan->name }} - {{ $currencySymbol }}{{ $plan->price }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">{{ __('Hold Ctrl (Cmd on Mac) to select multiple plans') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="check"></i>
                                        {{ __('Add Product Catalog') }}
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
    // Add Duration
    document.getElementById('add-duration').addEventListener('click', function() {
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
        lucide.createIcons();
        updateRemoveButtons('duration');
    });

    // Add Sharing Method
    document.getElementById('add-sharing-method').addEventListener('click', function() {
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
        lucide.createIcons();
        updateRemoveButtons('sharing-method');
    });

    // Remove Duration
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-duration')) {
            e.target.closest('.duration-item').remove();
            updateRemoveButtons('duration');
        }
    });

    // Remove Sharing Method
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-sharing-method')) {
            e.target.closest('.sharing-method-item').remove();
            updateRemoveButtons('sharing-method');
        }
    });

    function updateRemoveButtons(type) {
        const items = document.querySelectorAll(`.${type}-item`);
        items.forEach((item, index) => {
            const removeBtn = item.querySelector(`.remove-${type}`);
            if (items.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
</script>
@endsection
