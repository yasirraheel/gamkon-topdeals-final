@extends('frontend::layouts.auth')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <!-- Reset Password start -->
    <div class="auth-content auth-content-2">
        <div class="auth-title-box">
            <div class="logo-container">
                <div class="logo">
                    <a href="{{ route('home') }}"><x-luminous.logo /></a>
                </div>
            </div>
            <div class="auth-content-inside">
                <div class="auth-header">
                    <h3>{{ $data['title'] }}</h3>
                    <p>{{ $data['description'] }}</p>
                </div>
                <div class="auth-forms">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="row gy-3">
                            <!-- Email Input -->
                            <div class="col-12">
                                <div class="td-form-group">
                                    <div class="input-field input-field-icon">
                                        <input readonly hidden type="email" name="email" class="form-control"
                                            value="{{ old('email', $request->email) }}" required
                                            placeholder="{{ __('Enter email') }}">
                                        <span class="input-icon"><i class="icon-sms"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="col-12">
                                <div class="td-form-group has-right-icon">
                                    <label class="input-label">{{ __('Password') }} <span>*</span></label>
                                    <div class="input-field input-field-icon">
                                        <input type="password" name="password" class="form-control" required
                                            placeholder="{{ __('Enter password') }}">
                                        <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="col-12">
                                <div class="td-form-group has-right-icon">
                                    <label class="input-label">{{ __('Confirm Password') }} <span>*</span></label>
                                    <div class="input-field input-field-icon">
                                        <input type="password" name="password_confirmation" class="form-control" required
                                            placeholder="{{ __('Enter password') }}">
                                        <span class="input-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="auth-action">
                                    <button type="submit"
                                        class="primary-button xl-btn w-100 primary-button-full primary-button-blue">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Sign Up Redirect -->
                            <div class="col-12">
                                <div class="switch-page">
                                    <p>{{ __('Don\'t have an account?') }} <a
                                            href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password end -->
@endsection
