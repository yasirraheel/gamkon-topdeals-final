@extends('frontend::layouts.auth')
@section('title')
    {{ __('Forgot password') }}
@endsection
@section('content')
    <div class="auth-content auth-content-2">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <x-luminous.logo />
                </a>
            </div>
        </div>
        <div class="auth-content-inside">
            <div class="auth-header">
                <h3>{{ $data['title'] }}</h3>
                <p>{{ $data['description'] }}</p>
            </div>
            <div class="auth-forms">
                <form action="{{ route('password.email') }}" method="POST">
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
                            <div class="auth-action">
                                <button type="submit"
                                    class="primary-button xl-btn w-100">{{ __('Get Reset Link') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if (setting('account_creation', 'permission'))
                <div class="switch-page">
                    <p>{{ __('Password Remembered?') }} <a href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
