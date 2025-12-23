@extends('frontend::layouts.user')
@section('title')
    {{ __('Settings') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/flat-picker-color-select.css') }}">
    <style>
        .flatpickr-wrapper {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="account-overview">
            <h3>{{ __('Profile Settings') }}</h3>
            <div class="account-overview-box">
                <div class="overview-full">
                    <form action="{{ buyerSellerRoute('setting.profile-update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="rock-upload-input td-form-group position-relative">
                                    <label class="input-label">{{ __('Avatar') }} <span>*</span></label>
                                    <div class="upload-custom-file without-image">
                                        <input type="file" name="avatar" id="imageInput" accept=".gif, .jpg, .png"
                                            onchange="showCloseButton(event)">
                                        <label for="imageInput" class="file-ok"
                                            style="background-image: url('{{ $user->avatar_path }}')">
                                            <span class="upload-icon">
                                                <iconify-icon icon="material-symbols:next-plan-rounded"
                                                    class="referral-icon dashbaord-icon"></iconify-icon>
                                            </span>
                                            <span>{{ __('Update Avatar') }}</span>
                                        </label>
                                    </div>
                                    <button type="button" class="upload-thumb-close" onclick="removeUploadedFile(this)">
                                        <iconify-icon icon="stash:times-duotone"
                                            class="referral-icon dashbaord-icon"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 gy-sm-4">



                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('First Name') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="first_name"
                                            value="{{ $user->first_name }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Last Name') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="last_name"
                                            value="{{ $user->last_name }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Username') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="username"
                                            value="{{ $user->username }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Gender') }} <span>*</span></label>
                                    <div class="auth-nice-select auth-nice-select-2">
                                        <select class="nice-select-active" name="gender" required>
                                            @foreach (['Male', 'Female', 'Other'] as $gender)
                                                <option value="{{ $gender }}" @selected($user->gender == $gender)>
                                                    {{ __($gender) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group birth-date-picker common-flatpicker-design">
                                    <label class="input-label">{{ __('Date of Birth') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="date_of_birth"
                                            value="{{ $user->date_of_birth }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Email') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $user->email }}" required disabled>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Phone') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $user->phone }}" required>
                                        {{-- <div class="country-code"><p>+880</p></div> --}}
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Country') }} <span>*</span></label>
                                    <div class="auth-nice-select auth-nice-select-2">
                                        <select class="nice-select-active" name="country" required>
                                            @foreach (getCountries() as $country)
                                                <option value="{{ $country['name'] }}"
                                                    data-dialCode="{{ $country['dial_code'] }}"
                                                    @selected($user->country == $country['name'])>
                                                    {{ __($country['name']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('City') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="city"
                                            value="{{ $user->city }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('Address') }} <span>*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $user->address }}" required>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="td-form-group">
                                    <label class="input-label">{{ __('About') }} <span>*</span></label>
                                    <div class="input-field">
                                        <textarea name="about" required>{{ $user->about }}</textarea>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="account-form-submit-button">
                                    <button type="submit"
                                        class="primary-button xl-btn">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        document.addEventListener("DOMContentLoaded", function() {
            // Load the image if previously uploaded
            const savedImage = localStorage.getItem("uploadedImage");
            if (savedImage) {
                const label = document.querySelector("label[for='image1']");
                label.classList.add("file-ok");
                label.innerHTML = `<img src="${savedImage}" alt="Uploaded Image">`;
                const closeButton = document.querySelector(".upload-thumb-close");
                closeButton.style.display = "block";
            }
        });

        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    const label = event.target.nextElementSibling;
                    label.classList.add("file-ok");
                    label.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
                    localStorage.setItem("uploadedImage", e.target.result);
                    showCloseButton(event);
                };
                fileReader.readAsDataURL(file);
            }
        }

        function showCloseButton(event) {
            const button = event.target.parentElement.nextElementSibling;
            button.style.display = 'block';
        }

        function removeUploadedFile(button) {
            const label = button.previousElementSibling.querySelector('label.file-ok');
            const input = button.previousElementSibling.querySelector('input[type="file"]');
            label.classList.remove('file-ok');
            label.removeAttribute('style');
            label.innerHTML = `
            <span class="upload-icon">
              <i class="flaticon-quit"></i>
            </span>
            <span>Update Avater</span>
          `;
            input.value = '';
            localStorage.removeItem("uploadedImage");
            button.style.display = 'none';
        }

        // Image Preview
        $(document).on('change', 'input[type="file"]', function(event) {
            var $file = $(this),
                $label = $file.next('label'),
                $labelText = $label.find('span'),
                labelDefault = $labelText.text();

            var fileName = $file.val().split('\\').pop(),
                tmppath = URL.createObjectURL(event.target.files[0]);

            // Check successfully selection
            if (fileName) {
                $label.addClass('file-ok').css('background-image', 'url(' + tmppath + ')');
                $labelText.text(fileName);
            } else {
                $label.removeClass('file-ok');
                $labelText.text(labelDefault);
            }
        });
    </script>

    <script>
        "use strict";

        $(document).ready(function() {
            $(".birth-date-picker .form-control").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: false,
                defaultDate: null,
                position: "below",
                static: true
            });
        });


        // modal open and close functionality
        $(document).ready(function() {
            $('.logout-modal').on('click', function() {
                $('.common-modal-logout').addClass('open');
            });

            $('.common-modal-logout .cross').on('click', function() {
                $('.common-modal-logout').removeClass('open');
            });

        });
        $(document).on('change', '#select2Country', function() {
            var dialcode = $(this).find('option:selected').data('dialcode');
            $('.country-code').text(dialcode)
        })
    </script>
@endpush
