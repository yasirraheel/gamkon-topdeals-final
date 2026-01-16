@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection

@section('page-content')
    <div class="contact-us-area section_space-py">
        <div class="container">
            <div class="contact-us-area-content">
                <div class="contact-box-full">
                    <div class="contact-info-box">
                        <div class="row g-4">
                            <div class="col-sm-6 col-lg-4">
                                <div class="info-card one">
                                    <div class="info-card-icon">
                                        <iconify-icon icon="{{ $data['email_icon'] }}"
                                            class="info-email-icon"></iconify-icon>
                                    </div>
                                    <p><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="info-card two">
                                    <div class="info-card-icon">
                                        <iconify-icon icon="{{ $data['phone_icon'] }}"
                                            class="info-phone-icon"></iconify-icon>
                                    </div>
                                    <p><a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="info-card three">
                                    <div class="info-card-icon">
                                        <iconify-icon icon="{{ $data['location_icon'] }}"
                                            class="info-location-icon"></iconify-icon>
                                    </div>
                                    <p><a href="#">{{ $data['location'] }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-box">
                        <div class="row g-4 justify-content-center">
                            <div class="col-lg-12">
                                <div class="left">
                                    <div class="auth-forms">
                                        <form action="{{ route('mail-send') }}" method="POST">
                                            @csrf
                                            <div class="row gy-3">
                                                <div class="col-12">
                                                    <div class="td-form-group">
                                                        <label class="input-label">{{ __('Name') }}
                                                            <span>*</span></label>
                                                        <div class="input-field">
                                                            <input type="text" name="name" class="form-control"
                                                                required>
                                                        </div>
                                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="td-form-group">
                                                        <label class="input-label">{{ __('Email') }}
                                                            <span>*</span></label>
                                                        <div class="input-field">
                                                            <input type="email" name="email" class="form-control"
                                                                required>
                                                        </div>
                                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="td-form-group">
                                                        <label class="input-label">{{ __('Subject') }}
                                                            <span>*</span></label>
                                                        <div class="input-field">
                                                            <input type="text" name="subject" class="form-control"
                                                                required>
                                                        </div>
                                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="td-form-group">
                                                        <label class="input-label">{{ __('Message') }}
                                                            <span>*</span></label>
                                                        <div class="input-field">
                                                            <textarea name="msg" required></textarea>
                                                        </div>
                                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="auth-action">
                                                        <button class="primary-button xl-btn w-100">
                                                            {{ __($data['form_button_title']) ?? __('Send') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @if ($googleReCaptcha)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endpush
