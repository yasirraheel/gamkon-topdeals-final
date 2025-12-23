@extends('backend.setting.index')
@section('setting-title')
    {{ __('Page Settings') }}
@endsection
@section('setting-content')
    <div class="container-fluid">
        <div class="row">
            <!-- User/Buyer Settings Card -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="title">{{ __('User/Buyer Register Field Settings') }}</h3>
                    </div>
                    <div class="site-card-body">
                        <form action="{{ route('admin.page.setting.update') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="site-input-groups">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('First Name:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="first_name-show" name="first_name_show"
                                                    @checked(getPageSetting('first_name_show')) value="1" />
                                                <label for="first_name-show">{{ __('Show') }}</label>
                                                <input type="radio" id="first_name-hide" name="first_name_show"
                                                    @checked(!getPageSetting('first_name_show')) value="0" />
                                                <label for="first_name-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('First Name is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="first_name-required" name="first_name_validation"
                                                    @checked(getPageSetting('first_name_validation')) value="1" />
                                                <label for="first_name-required">{{ __('Required') }}</label>
                                                <input type="radio" id="first_name-optional" name="first_name_validation"
                                                    @checked(!getPageSetting('first_name_validation')) value="0" />
                                                <label for="first_name-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Last Name:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="last_name-show" name="last_name_show"
                                                    @checked(getPageSetting('last_name_show')) value="1" />
                                                <label for="last_name-show">{{ __('Show') }}</label>
                                                <input type="radio" id="last_name-hide" name="last_name_show"
                                                    @checked(!getPageSetting('last_name_show')) value="0" />
                                                <label for="last_name-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Last Name is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="last_name-required" name="last_name_validation"
                                                    @checked(getPageSetting('last_name_validation')) value="1" />
                                                <label for="last_name-required">{{ __('Required') }}</label>
                                                <input type="radio" id="last_name-optional" name="last_name_validation"
                                                    @checked(!getPageSetting('last_name_validation')) value="0" />
                                                <label for="last_name-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Phone Number:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="phone-show" name="phone_show"
                                                    @checked(getPageSetting('phone_show')) value="1" />
                                                <label for="phone-show">{{ __('Show') }}</label>
                                                <input type="radio" id="phone-hide" name="phone_show"
                                                    @checked(!getPageSetting('phone_show')) value="0" />
                                                <label for="phone-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Phone Number is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="phone-required" name="phone_validation"
                                                    @checked(getPageSetting('phone_validation')) value="1" />
                                                <label for="phone-required">{{ __('Required') }}</label>
                                                <input type="radio" id="phone-optional" name="phone_validation"
                                                    @checked(!getPageSetting('phone_validation')) value="0" />
                                                <label for="phone-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Country:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="country-show" name="country_show"
                                                    @checked(getPageSetting('country_show')) value="1" />
                                                <label for="country-show">{{ __('Show') }}</label>
                                                <input type="radio" id="country-hide" name="country_show"
                                                    @checked(!getPageSetting('country_show')) value="0" />
                                                <label for="country-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Country is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="country-required" name="country_validation"
                                                    @checked(getPageSetting('country_validation')) value="1" />
                                                <label for="country-required">{{ __('Required') }}</label>
                                                <input type="radio" id="country-optional" name="country_validation"
                                                    @checked(!getPageSetting('country_validation')) value="0" />
                                                <label for="country-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Referral Code:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="referral-code-show" name="referral_code_show"
                                                    @checked(getPageSetting('referral_code_show')) value="1" />
                                                <label for="referral-code-show">{{ __('Show') }}</label>
                                                <input type="radio" id="referral-code-hide" name="referral_code_show"
                                                    @checked(!getPageSetting('referral_code_show')) value="0" />
                                                <label for="referral-code-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Referral code is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="referral-code-required"
                                                    name="referral_code_validation" @checked(getPageSetting('referral_code_validation'))
                                                    value="1" />
                                                <label for="referral-code-required">{{ __('Required') }}</label>
                                                <input type="radio" id="referral-code-optional"
                                                    name="referral_code_validation" @checked(!getPageSetting('referral_code_validation'))
                                                    value="0" />
                                                <label for="referral-code-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Gender:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="gender-show" name="gender_show"
                                                    @checked(getPageSetting('gender_show')) value="1" />
                                                <label for="gender-show">{{ __('Show') }}</label>
                                                <input type="radio" id="gender-hide" name="gender_show"
                                                    @checked(!getPageSetting('gender_show')) value="0" />
                                                <label for="gender-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Gender is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="gender-required" name="gender_validation"
                                                    @checked(getPageSetting('gender_validation')) value="1" />
                                                <label for="gender-required">{{ __('Required') }}</label>
                                                <input type="radio" id="gender-optional" name="gender_validation"
                                                    @checked(!getPageSetting('gender_validation')) value="0" />
                                                <label for="gender-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Seller Settings Card -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="title">{{ __('Seller Register Field Settings') }}</h3>
                    </div>
                    <div class="site-card-body">
                        <form action="{{ route('admin.page.setting.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="site-input-groups">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('First Name:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_first_name-show"
                                                    name="seller_first_name_show" @checked(getPageSetting('seller_first_name_show'))
                                                    value="1" />
                                                <label for="seller_first_name-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_first_name-hide"
                                                    name="seller_first_name_show" @checked(!getPageSetting('seller_first_name_show'))
                                                    value="0" />
                                                <label for="seller_first_name-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('First Name is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_first_name-required"
                                                    name="seller_first_name_validation" @checked(getPageSetting('seller_first_name_validation'))
                                                    value="1" />
                                                <label for="seller_first_name-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_first_name-optional"
                                                    name="seller_first_name_validation" @checked(!getPageSetting('seller_first_name_validation'))
                                                    value="0" />
                                                <label for="seller_first_name-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Last Name:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_last_name-show"
                                                    name="seller_last_name_show" @checked(getPageSetting('seller_last_name_show'))
                                                    value="1" />
                                                <label for="seller_last_name-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_last_name-hide"
                                                    name="seller_last_name_show" @checked(!getPageSetting('seller_last_name_show'))
                                                    value="0" />
                                                <label for="seller_last_name-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Last Name is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_last_name-required"
                                                    name="seller_last_name_validation" @checked(getPageSetting('seller_last_name_validation'))
                                                    value="1" />
                                                <label for="seller_last_name-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_last_name-optional"
                                                    name="seller_last_name_validation" @checked(!getPageSetting('seller_last_name_validation'))
                                                    value="0" />
                                                <label for="seller_last_name-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Phone Number:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_phone-show" name="seller_phone_show"
                                                    @checked(getPageSetting('seller_phone_show')) value="1" />
                                                <label for="seller_phone-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_phone-hide" name="seller_phone_show"
                                                    @checked(!getPageSetting('seller_phone_show')) value="0" />
                                                <label for="seller_phone-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Phone Number is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_phone-required"
                                                    name="seller_phone_validation" @checked(getPageSetting('seller_phone_validation'))
                                                    value="1" />
                                                <label for="seller_phone-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_phone-optional"
                                                    name="seller_phone_validation" @checked(!getPageSetting('seller_phone_validation'))
                                                    value="0" />
                                                <label for="seller_phone-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Country:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_country-show" name="seller_country_show"
                                                    @checked(getPageSetting('seller_country_show')) value="1" />
                                                <label for="seller_country-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_country-hide" name="seller_country_show"
                                                    @checked(!getPageSetting('seller_country_show')) value="0" />
                                                <label for="seller_country-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Country is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_country-required"
                                                    name="seller_country_validation" @checked(getPageSetting('seller_country_validation'))
                                                    value="1" />
                                                <label for="seller_country-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_country-optional"
                                                    name="seller_country_validation" @checked(!getPageSetting('seller_country_validation'))
                                                    value="0" />
                                                <label for="seller_country-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Referral Code:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_referral-code-show"
                                                    name="seller_referral_code_show" @checked(getPageSetting('seller_referral_code_show'))
                                                    value="1" />
                                                <label for="seller_referral-code-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_referral-code-hide"
                                                    name="seller_referral_code_show" @checked(!getPageSetting('seller_referral_code_show'))
                                                    value="0" />
                                                <label for="seller_referral-code-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label"
                                                for="">{{ __('Referral code is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_referral-code-required"
                                                    name="seller_referral_code_validation" @checked(getPageSetting('seller_referral_code_validation'))
                                                    value="1" />
                                                <label for="seller_referral-code-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_referral-code-optional"
                                                    name="seller_referral_code_validation" @checked(!getPageSetting('seller_referral_code_validation'))
                                                    value="0" />
                                                <label for="seller_referral-code-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Gender:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_gender-show" name="seller_gender_show"
                                                    @checked(getPageSetting('seller_gender_show')) value="1" />
                                                <label for="seller_gender-show">{{ __('Show') }}</label>
                                                <input type="radio" id="seller_gender-hide" name="seller_gender_show"
                                                    @checked(!getPageSetting('seller_gender_show')) value="0" />
                                                <label for="seller_gender-hide">{{ __('Hide') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 col-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Gender is:') }}</label>
                                            <div class="switch-field">
                                                <input type="radio" id="seller_gender-required"
                                                    name="seller_gender_validation" @checked(getPageSetting('seller_gender_validation'))
                                                    value="1" />
                                                <label for="seller_gender-required">{{ __('Required') }}</label>
                                                <input type="radio" id="seller_gender-optional"
                                                    name="seller_gender_validation" @checked(!getPageSetting('seller_gender_validation'))
                                                    value="0" />
                                                <label for="seller_gender-optional">{{ __('Optional') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-design-nb mb-2">
                                <strong>NB</strong>{{ __('Seller ID Verification will come from') }} <a href="{{ route('admin.kyc-form.index') }}">{{ __('ID Verification Settings') }}</a>
                            </div>
                            <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
