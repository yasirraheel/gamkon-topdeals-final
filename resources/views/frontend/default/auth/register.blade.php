@extends('frontend::layouts.auth')

@section('title')
    {{ __('Register') }}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ themeAsset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/flat-picker-color-select.css') }}">
@endpush

@section('content')
    <!-- Sign up area start -->
    <div class="auth-content">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('home') }}"><x-luminous.logo /></a>
            </div>
        </div>
        <div class="auth-content-inside">
            <div class="auth-header">
                <h3>{{ $data['title'] }}</h3>
            </div>
            <div class="auth-tab">
                <div class="auth-tab-area" id="pills-tab" role="tablist">
                    <button class="auth-tab-btn active" id="nav-buyer-tab" data-bs-toggle="tab" data-bs-target="#nav-buyer"
                        type="button" role="tab" aria-controls="nav-buyer" aria-selected="false">
                        {{ __('Buyer') }}
                    </button>
                    <button class="auth-tab-btn" id="nav-seller-tab" data-bs-toggle="tab" data-bs-target="#nav-seller"
                        type="button" role="tab" aria-controls="nav-seller" aria-selected="true">
                        {{ __('Seller') }}
                    </button>
                </div>
            </div>
            <div class="auth-tab-content tab-content" id="nav-tabContent">
                <div class="tab-pane fade vendor" id="nav-seller" role="tabpanel" aria-labelledby="nav-seller-tab">
                    <div class="auth-forms">
                        <form action="{{ route('register.now') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="content-separation">
                                    <p>{{ __('Basic Information') }}</p>
                                </div>

                                @if (getPageSetting('seller_first_name_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('First Name') }}
                                                <span>{{ getPageSetting('seller_first_name_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ old('first_name') }}" @required(getPageSetting('seller_first_name_validation'))>
                                            </div>
                                            @error('first_name')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <input type="hidden" name="user_type" value="seller">
                                @if (getPageSetting('seller_last_name_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Last Name') }}
                                                <span>{{ getPageSetting('seller_last_name_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ old('last_name') }}" @required(getPageSetting('seller_last_name_validation'))>
                                            </div>
                                            @error('last_name')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Email') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Username') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="text" class="form-control" name="username"
                                                value="{{ old('username') }}" required>
                                        </div>
                                        @error('username')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if (getPageSetting('seller_country_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Country') }}
                                                <span>{{ getPageSetting('seller_country_validation') ? '*' : '' }}</span></label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select id="select2Country" name="country" class="nice-select-active"
                                                    @required(getPageSetting('seller_country_validation'))>
                                                    @foreach (getCountries() as $country)
                                                        <option @selected($location->country_code == $country['code'])
                                                            value="{{ $country['name'] . ':' . $country['dial_code'] }}">
                                                            {{ $country['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('country')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('seller_phone_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Phone') }}
                                                <span>{{ getPageSetting('seller_phone_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field input-field-phone">
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ old('phone') }}" @required(getPageSetting('seller_phone_validation'))>
                                                <div class="country-code">
                                                    <p>{{ $location->dial_code }}</p>
                                                </div>
                                            </div>
                                            @error('phone')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('seller_gender_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Gender') }}
                                                <span>{{ getPageSetting('seller_gender_validation') ? '*' : '' }}</span></label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select id="select2Gender" name="gender" class="nice-select-active"
                                                    @required(getPageSetting('seller_gender_validation'))>
                                                    <option value="male" @selected(old('gender') == 'male')>
                                                        {{ __('Male') }}
                                                    </option>
                                                    <option value="female" @selected(old('gender') == 'female')>
                                                        {{ __('Female') }}
                                                    </option>
                                                    <option value="other" @selected(old('gender') == 'other')>
                                                        {{ __('Others') }}
                                                    </option>
                                                </select>
                                            </div>
                                            @error('gender')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('seller_referral_code_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Referral Code') }}
                                                <span>{{ getPageSetting('seller_referral_code_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="invite"
                                                    value="{{ old('invite', $referralCode) ?? $referralCode }}"
                                                    @required(getPageSetting('seller_referral_code_validation'))>
                                            </div>
                                            @error('invite')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="td-form-group has-right-icon">
                                        <label class="input-label">{{ __('Password') }} <span>*</span></label>
                                        <div class="input-field input-field-icon">
                                            <input type="password" class="form-control" name="password" required>
                                            <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                        </div>
                                        @error('password')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="td-form-group has-right-icon">
                                        <label class="input-label">{{ __('Confirm Password') }} <span>*</span></label>
                                        <div class="input-field input-field-icon">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                required>
                                            <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                        </div>
                                        @error('password_confirmation')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="content-separation">
                                        <p>{{ __('Verification information') }}</p>
                                    </div>
                                </div>

                                @includeWhen($sellerKyc, 'frontend::auth.seller-kyc', ['kyc' => $sellerKyc])

                                <div class="col-md-6">
                                    <div class="auth-checkbox">
                                        <div class="animate-custom">
                                            <input class="inp-cbx" id="auth_remind_seller" type="checkbox"
                                                name="terms" required>
                                            <label class="cbx" for="auth_remind_seller">
                                                <span>
                                                    <svg width="12px" height="9px" viewBox="0 0 12 9">
                                                        <polyline points="1 5 4 8 11 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>{{ __('I agree with') }} <a
                                                        href="{{ url('terms-and-conditions') }}"
                                                        class="terms-link">{{ __('Terms & Conditions') }}</a></span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('terms')
                                        <p class="feedback-invalid active">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="auth-action">
                                        <button type="submit"
                                            class="primary-button xl-btn w-100">{{ __('Register') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- buyer part --}}
                <div class="tab-pane fade show active buyer" id="nav-buyer" role="tabpanel"
                    aria-labelledby="nav-buyer-tab">
                    <div class="auth-forms">
                        <form action="{{ route('register.now') }}" method="POST">
                            @csrf
                            <div class="row gy-3">
                                @if (getPageSetting('first_name_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('First Name') }}
                                                <span>{{ getPageSetting('first_name_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ old('first_name') }}" @required(getPageSetting('first_name_validation'))>
                                            </div>
                                            @error('first_name')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <input type="hidden" name="user_type" value="buyer">
                                @if (getPageSetting('last_name_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Last Name') }}
                                                <span>{{ getPageSetting('last_name_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ old('last_name') }}" @required(getPageSetting('last_name_validation'))>
                                            </div>
                                            @error('last_name')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Email') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Username') }}
                                            <span>{{ getPageSetting('username_validation') ? '*' : '' }}</span></label>
                                        <div class="input-field">
                                            <input type="text" class="form-control" name="username"
                                                value="{{ old('username') }}" @required(getPageSetting('username_validation'))>
                                        </div>
                                        @error('username')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if (getPageSetting('country_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Country') }}
                                                <span>{{ getPageSetting('country_validation') ? '*' : '' }}</span></label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select id="select2Country" name="country" class="nice-select-active"
                                                    @required(getPageSetting('country_validation'))>
                                                    @foreach (getCountries() as $country)
                                                        <option @selected($location->country_code == $country['code'])
                                                            value="{{ $country['name'] . ':' . $country['dial_code'] }}">
                                                            {{ $country['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('country')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('phone_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Phone') }}
                                                <span>{{ getPageSetting('phone_validation') ? '*' : '' }}</span></label>
                                            <div class="input-field input-field-phone">
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ old('phone') }}" @required(getPageSetting('phone_validation'))>
                                                <div class="country-code">
                                                    <p>{{ $location->dial_code }}</p>
                                                </div>
                                            </div>
                                            @error('phone')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('gender_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Gender') }}
                                                <span>{{ getPageSetting('gender_validation') ? '*' : '' }}</span></label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select id="select2Gender" name="gender" class="nice-select-active"
                                                    @required(getPageSetting('gender_validation'))>
                                                    <option value="male" @selected(old('gender') == 'male')>
                                                        {{ __('Male') }}
                                                    </option>
                                                    <option value="female" @selected(old('gender') == 'female')>
                                                        {{ __('Female') }}
                                                    </option>
                                                    <option value="other" @selected(old('gender') == 'other')>
                                                        {{ __('Others') }}
                                                    </option>
                                                </select>
                                            </div>
                                            @error('gender')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (getPageSetting('referral_code_show'))
                                    <div class="col-md-6">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Referral Code') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="form-control" name="invite"
                                                    value="{{ old('invite', $referralCode) ?? $referralCode }}">
                                            </div>
                                            @error('invite')
                                                <p class="feedback-invalid active">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="td-form-group has-right-icon">
                                        <label class="input-label">{{ __('Password') }} <span>*</span></label>
                                        <div class="input-field input-field-icon">
                                            <input type="password" class="form-control" name="password" required>
                                            <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                        </div>
                                        @error('password')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="td-form-group has-right-icon">
                                        <label class="input-label">{{ __('Confirm Password') }} <span>*</span></label>
                                        <div class="input-field input-field-icon">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                required>
                                            <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                        </div>
                                        @error('password_confirmation')
                                            <p class="feedback-invalid active">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="auth-checkbox">
                                        <div class="animate-custom">
                                            <input class="inp-cbx" id="auth_remind_buyer" type="checkbox" name="terms"
                                                required>
                                            <label class="cbx" for="auth_remind_buyer">
                                                <span>
                                                    <svg width="12px" height="9px" viewBox="0 0 12 9">
                                                        <polyline points="1 5 4 8 11 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>{{ __('I agree with') }} <a
                                                        href="{{ url('terms-and-conditions') }}"
                                                        class="terms-link">{{ __('Terms & Conditions') }}</a></span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('terms')
                                        <p class="feedback-invalid active">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="auth-action">
                                        <button type="submit"
                                            class="primary-button w-100 xl-btn">{{ __('Register') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (setting('facebook_social_login', 'permission') || setting('google_social_login', 'permission'))
                        <div class="social-logins">
                            <div class="or-divider">
                                <span class="text">{{ __('or') }}</span>
                            </div>
                            <div class="buttons">
                                <div class="row g-2 justify-content-center">
                                    @if (setting('facebook_social_login', 'permission'))
                                        <div class="col-sm-6">
                                            <a href="{{ route('social.login', ['provider' => 'facebook', 'user_type' => 'buyer']) }}"
                                                class="social-btn">
                                                <span class="icon">
                                                    <iconify-icon icon="ri:facebook-fill"
                                                        class="social-icon facebook"></iconify-icon>
                                                </span>
                                                <span class="text">{{ __('Facebook') }}</span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (setting('google_social_login', 'permission'))
                                        <div class="col-sm-6">
                                            <a href="{{ route('social.login', ['provider' => 'google', 'user_type' => 'buyer']) }}"
                                                class="social-btn">
                                                <span class="icon">
                                                    <iconify-icon icon="flat-color-icons:google"
                                                        class="social-icon google"></iconify-icon>
                                                </span>
                                                <span class="text">{{ __('Google') }}</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="switch-page">
                    <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign up area end -->

@endsection
@push('js')
    <script>
        'use strict';
        (function($) {
            // Country Select
            $(document).on('change', '#select2Country', function(e) {
                "use strict";
                e.preventDefault();
                var country = $(this).val();
                $(this).parents('form').find('.country-code').html(country.split(":")[1])
            })
        })(jQuery);


        $(document).ready(function() {
            // Initialize all upload thumbs
            $('.upload-thumb').each(function() {
                initUploadThumb($(this));
            });

            function initUploadThumb($thumb) {
                const $input = $thumb.find('.file-upload-input');
                const $thumbImg = $thumb.find('.upload-thumb-img');
                const $thumbContent = $thumb.find('.upload-thumb-content');
                const $attachFile = $thumb.find('.attach-file');

                // Click handler for attach file link
                $attachFile.on('click', function(e) {
                    e.preventDefault();
                    $input.click();
                });

                // Click handler for the whole thumb area
                $thumb.on('click', function(e) {
                    // Don't trigger if click originated from delete button or its children
                    if ($(e.target).closest('.delete-btn').length) {
                        return;
                    }

                    if ($(e.target).is('.upload-thumb') ||
                        $(e.target).is('.upload-thumb-content') ||
                        $(e.target).is('.upload-thumb-content *:not(.attach-file)')) {
                        $input.click();
                    }
                });

                // File input change handler
                $input.on('change', function(e) {
                    const files = e.target.files;
                    if (files.length > 0) {
                        processFiles(files, $thumbImg, $thumbContent, $input);
                    }
                });

                // Drag and drop handlers
                $thumb.on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'var(--td-secondary)');
                });

                $thumb.on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');
                });

                $thumb.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');

                    const files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        $input[0].files = files;
                        $input.trigger('change');
                    }
                });
            }

            // Process uploaded files
            function processFiles(files, $uploadThumbImg, $uploadThumbContent, $input) {
                // Clear previous files if you want to replace them
                $uploadThumbImg.empty();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const imageBox = $('<div class="image-box"></div>');

                    // Create delete button
                    const deleteBtn = $('<span class="delete-btn">×</span>')
                        .css({
                            'position': 'absolute',
                            'top': '5px',
                            'right': '5px',
                            'width': '20px',
                            'height': '20px',
                            'background': 'rgba(0,0,0,0.5)',
                            'color': 'white',
                            'border-radius': '50%',
                            'display': 'flex',
                            'align-items': 'center',
                            'justify-content': 'center',
                            'cursor': 'pointer',
                            'font-size': '14px',
                            'z-index': '10'
                        })
                        .on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            $(this).parent().remove();
                            checkEmptyState($uploadThumbImg, $uploadThumbContent, $input);
                        });

                    imageBox.append(deleteBtn);

                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>').attr('src', e.target.result);
                            imageBox.append(img);
                            $uploadThumbImg.append(imageBox);
                            updateUploadState($uploadThumbImg, $uploadThumbContent);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const fileInfo = $('<div></div>')
                            .text(file.name)
                            .css({
                                'width': '100%',
                                'height': '100%',
                                'display': 'flex',
                                'align-items': 'center',
                                'justify-content': 'center',
                                'padding': '10px',
                                'word-break': 'break-all'
                            });
                        imageBox.append(fileInfo);
                        $uploadThumbImg.append(imageBox);
                        updateUploadState($uploadThumbImg, $uploadThumbContent);
                    }
                }
            }

            function updateUploadState($uploadThumbImg, $uploadThumbContent) {
                $uploadThumbImg.addClass('has-img');
                $uploadThumbContent.addClass('has-img');
            }

            function checkEmptyState($uploadThumbImg, $uploadThumbContent, $input) {
                if ($uploadThumbImg.children().length === 0) {
                    $uploadThumbImg.removeClass('has-img');
                    $uploadThumbContent.removeClass('has-img');
                    $input.val('');
                }
            }
        });
    </script>

    <script src="{{ themeAsset('js/flatpickr.js') }}"></script>
    <script src="{{ themeAsset('js/flatpicker-activation.js') }}"></script>
@endpush
