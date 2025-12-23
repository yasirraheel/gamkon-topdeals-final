@extends('frontend::layouts.auth')
@section('title')
    {{ __('Verify Email') }}
@endsection
@section('content')
    <div class="auth-content auth-content-2">
        <div class="auth-content-inside">
            <div class="logo-container">
                <div class="logo">
                    <x-luminous.logo />
                </div>
            </div>
            <div class="auth-header auth-header-2">
                <h3>{{ __('Verify Email') }}</h3>
                <p>{{ __('Enter your registered email address, and we\'ll send you a link to verify your email.') }}</p>
            </div>
            <div class="auth-forms">
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="primary-button xl-btn w-100">{{ __('Resend Link') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
