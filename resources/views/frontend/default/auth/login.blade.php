@extends('frontend::layouts.auth')

@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    <div class="auth-content auth-content-2">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('home') }}"><x-luminous.logo /></a>
            </div>
        </div>
        <div class="auth-content-inside">
            <div class="auth-header">
                <h3>{{ $data['title'] }}</h3>
            </div>
            <div class="auth-forms">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="td-form-group">
                                <label class="input-label">{{ __('Email') }} <span>*</span></label>
                                <div class="input-field">
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <p class="feedback-invalid">{{ __('This field is required') }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="td-form-group has-right-icon">
                                <label class="input-label">{{ __('Password') }} <span>*</span></label>
                                <div class="input-field input-field-icon">
                                    <input name="password" type="password" class="form-control" required>
                                    <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                </div>
                                <p class="feedback-invalid">{{ __('This field is required') }}</p>
                            </div>
                        </div>
                        @if ($googleReCaptcha)
                            <div class="col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $googleReCaptchaKey }}"></div>
                                @error('g-recaptcha-response')
                                    <p class="feedback-invalid active">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="auth-checking">
                                <div class="auth-checkbox">
                                    <div class="animate-custom">
                                        <input class="inp-cbx" id="auth_remind" name="remember" type="checkbox">
                                        <label class="cbx" for="auth_remind">
                                            <span>
                                                <svg width="12px" height="9px" viewBox="0 0 12 9">
                                                    <polyline points="1 5 4 8 11 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>{{ __('Remember me') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="forgot-password">
                                    <a href="{{ route('password.request') }}"
                                        class="forgot-btn">{{ __('Forgot Password?') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="auth-action">
                                <button type="submit" class="primary-button xl-btn w-100">{{ __('Log in') }}</button>
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
                                    <a href="{{ route('social.login', 'facebook') }}" class="social-btn">
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
                                    <a href="{{ route('social.login', 'google') }}" class="social-btn">
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
            @if (setting('account_creation', 'permission'))
                <div class="switch-page">
                    <p>{{ __('Don’t have an account?') }} <a href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    @if ($googleReCaptcha)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicon = document.querySelector('.input-icon i'); // Fixed selector to match current DOM if needed, but keeping logic similar to before but safer
            let passo = document.querySelector('input[name="password"]');

             // Re-implementing logic to match structure of other pages or fixing it if ID is missing
             // The original code used getElementById 'eyeicon' but the HTML above uses class 'input-icon' containing 'i' class 'fa-regular fa-eye-slash'
             // And input doesn't have id 'passo'
             // Let's fix the script to actually work with the DOM elements present

            $(document).on('click', '.input-icon', function() {
                let input = $(this).siblings('input');
                let icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });

        })(jQuery);
    </script>
@endpush
