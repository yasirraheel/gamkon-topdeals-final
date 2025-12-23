@extends('backend.layouts.app')
@section('title')
    {{ __('Add New Customer') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add New User') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @php
                            // Dynamically decide page setting prefix (seller_ for sellers, none for buyers)
                            $prefix = ($userType ?? null) === 'seller' ? 'seller_' : '';
                        @endphp
                        <div class="site-card">
                            <div class="site-card-header">
                                <h4 class="title">{{ __('Basic Info') }}</h4>
                            </div>
                            <div class="site-card-body">
                                <div class="row">

                                    @if (getPageSetting($prefix . 'first_name_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('First Name:') }}
                                                    @if (getPageSetting($prefix . 'first_name_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" name="fname" class="box-input mb-0"
                                                    value="{{ old('fname') }}" @required(getPageSetting($prefix . 'first_name_validation')) />
                                            </div>
                                        </div>
                                    @endif

                                    @if (getPageSetting($prefix . 'last_name_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('Last Name:') }}
                                                    @if (getPageSetting($prefix . 'last_name_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" name="lname" class="box-input mb-0"
                                                    value="{{ old('lname') }}" @required(getPageSetting($prefix . 'last_name_validation')) />
                                            </div>
                                        </div>
                                    @endif

                                    @if (getPageSetting($prefix . 'country_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('Country:') }}
                                                    @if (getPageSetting($prefix . 'country_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <select name="country" id="country" class="form-control form-select"
                                                    @required(getPageSetting($prefix . 'country_validation'))>
                                                    <option value="">{{ __('Select Country') }}</option>
                                                    @foreach (getCountries() as $country)
                                                        <option value="{{ $country['name'] }}"
                                                            @selected(old('country') == $country['name'])>{{ $country['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if (getPageSetting($prefix . 'gender_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('Gender:') }}
                                                    @if (getPageSetting($prefix . 'gender_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <select name="gender" class="form-control form-select" @required(getPageSetting($prefix . 'gender_validation'))>
                                                    <option value="">{{ __('Select Gender') }}</option>
                                                    <option value="male" @selected(old('gender') == 'male')>{{ __('Male') }}
                                                    </option>
                                                    <option value="female" @selected(old('gender') == 'female')>{{ __('Female') }}
                                                    </option>
                                                    <option value="other" @selected(old('gender') == 'other')>{{ __('Other') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Email Address:') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" class="box-input mb-0"
                                                value="{{ old('email') }}" required />
                                        </div>
                                    </div>

                                    @if (getPageSetting($prefix . 'phone_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('Phone:') }}
                                                    @if (getPageSetting($prefix . 'phone_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" name="phone" class="box-input mb-0"
                                                    value="{{ old('phone') }}" @required(getPageSetting($prefix . 'phone_validation')) />
                                            </div>
                                        </div>
                                    @endif

                                    @if (getPageSetting($prefix . 'referral_code_show'))
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label">
                                                    {{ __('Referral Code:') }}
                                                    @if (getPageSetting($prefix . 'referral_code_validation'))
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" name="invite" class="box-input mb-0"
                                                    value="{{ old('invite') }}" @required(getPageSetting($prefix . 'referral_code_validation')) />
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Date of Birth:') }}</label>
                                            <input type="date" class="box-input" name="date_of_birth"
                                                value="{{ old('date_of_birth') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('City:') }}</label>
                                            <input type="text" name="city" class="box-input"
                                                value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Zip Code:') }}</label>
                                            <input type="text" class="box-input" name="zip_code"
                                                value="{{ old('zip_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Address:') }}</label>
                                            <input type="text" class="box-input" name="address"
                                                value="{{ old('address') }}">
                                        </div>
                                    </div>

                                    <input type="hidden" name="user_type" value="{{ $userType ?? 'buyer' }}">

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">
                                                {{ __('Password:') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" name="password" class="box-input mb-0" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (setting('kyc_verification', 'permission'))
                            <div class="site-card">
                                <div class="site-card-header">
                                    <h4 class="title">{{ __('KYC Submission') }}</h4>
                                </div>
                                <div class="site-card-body">
                                    @foreach ($kycs as $kyc)
                                        <input type="hidden" name="kyc_ids[]" value="{{ $kyc->id }}">
                                        <div class="site-card" id="kyc_{{ $kyc->id }}">
                                            <div class="site-card-header">
                                                <h4 class="title">{{ $kyc->name }} - @if ($kyc->user_type == 'seller')
                                                        <span class="site-badge success">{{ __('Seller KYC') }}</span>
                                                    @elseif ($kyc->user_type == 'buyer')
                                                        <span class="site-badge pending">{{ __('Buyer KYC') }}</span>
                                                    @else
                                                        <span class="site-badge primary">{{ __('Both') }}</span>
                                                    @endif
                                                </h4>
                                                <button class="remove round-icon-btn red-btn"
                                                    onclick="removeKyc({{ $kyc->id }})">
                                                    X
                                                </button>
                                            </div>
                                            <div class="site-card-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-xl-4 col-lg-4">
                                                        @foreach (json_decode($kyc->fields, true) as $key => $field)
                                                            @if ($field['type'] == 'file')
                                                                <div class="site-input-groups mb-2">
                                                                    <label class="box-input-label"
                                                                        for="">{{ $field['name'] }} @if ($field['validation'] == 'required')
                                                                            <span class="text text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <div class="wrap-custom-file">
                                                                        <input type="file"
                                                                            name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]"
                                                                            id="{{ $field['name'] }}"
                                                                            accept=".gif, .jpg, .png, .svg"
                                                                            @required($field['validation'] == 'required') />
                                                                        <label for="{{ $field['name'] }}">
                                                                            <img class="upload-icon"
                                                                                src="{{ asset('global/materials/upload.svg') }}"
                                                                                alt="" />
                                                                            <span>{{ __('Upload Icon') }}</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @elseif($field['type'] == 'textarea')
                                                                <div class="site-input-groups">
                                                                    <label for=""
                                                                        class="box-input-label">{{ $field['name'] }}
                                                                        @if ($field['validation'] == 'required')
                                                                            <span class="text text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <textarea name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]" class="form-textarea mb-0"
                                                                        @required($field['validation'] == 'required')></textarea>
                                                                </div>
                                                            @elseif($field['type'] == 'date')
                                                                <div class="site-input-groups">
                                                                    <label for=""
                                                                        class="box-input-label">{{ $field['name'] }}
                                                                        @if ($field['validation'] == 'required')
                                                                            <span class="text text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input type="date"
                                                                        name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]"
                                                                        class="box-input mb-0"
                                                                        @if ($field['validation'] == 'required') required @endif />
                                                                </div>
                                                            @else
                                                                <div class="site-input-groups">
                                                                    <label for=""
                                                                        class="box-input-label">{{ $field['name'] }}
                                                                        @if ($field['validation'] == 'required')
                                                                            <span class="text text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input type="text"
                                                                        name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]"
                                                                        class="box-input mb-0"
                                                                        @if ($field['validation'] == 'required') required @endif />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="user-plus"></i>
                                {{ __('Add New') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        "use strict"

        $('#country').select2();

        function removeKyc(id) {
            $('#kyc_' + id).remove();
        }
    </script>
@endsection
