@extends('frontend::layouts.user')
@section('title')
    {{ __('Privacy & Security') }}
@endsection
@push('css')
    <style>
        .overview-full {
            max-width: unset !important;
        }
    </style>
@endpush
@section('content')
    <div class="account-overview">
        <h3>{{ __('Privacy & Security') }}</h3>
        <div class="account-overview-box row account-overview-box-2">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="overview-full">
                        <h3>{{ __('Privacy Settings') }}</h3>

                        <form action="{{ buyerSellerRoute('setting.privacy.update') }}" method="POST">
                            @csrf
                            <div class="row gy-3 gy-sm-4">
                                <!-- Email -->
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Email') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', auth()->user()->email) }}">
                                        </div>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <!-- Old Password -->
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Old Password') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="password" class="form-control" name="old_password"
                                                value="{{ old('old_password') }}">
                                        </div>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <!-- New Password -->
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('New Password') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}">
                                        </div>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <!-- Security Section (for sellers) -->
                                @if (auth('web')->user()->is_seller)
                                    <!-- Show Follower and Following List -->
                                    <div class="col-12">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Show Follower and Following List') }}</label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select class="nice-select-active" name="show_following_follower_list">
                                                    <option value="1" @selected(old('show_following_follower_list', $user->show_following_follower_list))>{{ __('Yes') }}
                                                    </option>
                                                    <option value="0" @selected(!old('show_following_follower_list', $user->show_following_follower_list))>{{ __('No') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Accept Chat from Users -->
                                    <div class="col-12">
                                        <div class="td-form-group">
                                            <label class="input-label">{{ __('Accept Chat from Users') }}</label>
                                            <div class="auth-nice-select auth-nice-select-2">
                                                <select class="nice-select-active" name="accept_profile_chat">
                                                    <option value="1" @selected(old('accept_profile_chat', $user->accept_profile_chat))>{{ __('Yes') }}
                                                    </option>
                                                    <option value="0" @selected(!old('accept_profile_chat', $user->accept_profile_chat))>{{ __('No') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- Submit Button -->
                                <div class="col-12">
                                    <div class="account-form-submit-button">
                                        <button type="submit"
                                            class="primary-button xl-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="overview-full">
                        <h3 class="my-3">{{ __('Security Settings') }}</h3>

                        <!-- Two Factor Authentication -->
                        @if (setting('fa_verification', 'permission'))
                            <div class="row gy-3 gy-sm-4">
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Two Factor Authentication') }}</label>
                                        @if ($user->google2fa_secret && !is_null($user->google2fa_secret) && !empty($user->google2fa_secret))
                                            @php
                                                $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
                                                $inlineUrl = $google2fa->getQRCodeInline(
                                                    setting('site_title', 'global'),
                                                    $user->email,
                                                    $user->google2fa_secret,
                                                );
                                            @endphp
                                            <div class="qr-code">
                                                @if (Str::of($inlineUrl)->startsWith('data:image/'))
                                                    <img src="{{ $inlineUrl }}"
                                                        alt="tyku
                
                System: "QR Code">
                                                @else
                                                    {!! $inlineUrl !!}
                                                @endif
                                            </div>
                                            <form action="{{ buyerSellerRoute('setting.action-2fa') }}" method="POST">
                                                @csrf
                                                <div class="td-form-group">
                                                    <label class="input-label">
                                                        @if ($user->two_fa)
                                                            {{ __('Enter Your Password') }}
                                                        @else
                                                            {{ __('Enter the PIN from Google Authenticator App') }}
                                                        @endif
                                                    </label>
                                                    <div class="input-field">
                                                        <input type="password" class="form-control" name="one_time_password"
                                                            required>
                                                    </div>
                                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                                </div>
                                                <div class="account-form-submit-button">
                                                    @if ($user->two_fa)
                                                        <button type="submit"
                                                            class="primary-button d-flex xl-btn w-100 bg-danger"
                                                            value="disable" name="status">
                                                            <span>{{ __('Disable 2FA') }}</span>
                                                        </button>
                                                    @else
                                                        <button type="submit" class="primary-button d-flex xl-btn w-100"
                                                            value="enable" name="status">
                                                            <span>{{ __('Enable 2FA') }}</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        @else
                                            <div class="account-form-submit-button">
                                                <a href="{{ buyerSellerRoute('setting.2fa') }}"
                                                    class="primary-button d-flex xl-btn w-100">
                                                    <span>{{ __('Generate Key') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script>
            "use strict";
            // handle show_following_follower_list
            $(document).ready(function() {
                $('#button-3').click(function() {
                    // $('#button-3').toggleClass('on');
                });
            });
        </script>
    @endpush
