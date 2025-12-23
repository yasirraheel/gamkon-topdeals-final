@extends('frontend::layouts.auth')
@section('title')
    {{ __('2FA Security') }}
@endsection

@section('content')
    <!-- auth area start -->
    <div class="auth-content auth-content-2">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <x-luminous.logo />
                </a>
            </div>
        </div>
        <div class="auth-content-inside">
            <div class="auth-header auth-header-2">
                <h3>{{ __('Verify OTP') }}</h3>
                <p>
                    {!! __(
                        'Please enter the <strong>OTP</strong> generated on your Authenticator App.<br>Ensure you submit the current one because it refreshes every 30 seconds.',
                    ) !!}
                </p>
            </div>
            <div class="auth-forms">
                <form class="twoFAform" action="{{ buyerSellerRoute('setting.2fa.verify') }}" method="POST">
                    @csrf
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="td-form-otp">
                                <div id="twoStepsForm">
                                    <div class="auth-input-wrapper numeral-mask-wrapper">
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" autofocus required>
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" required>
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" required>
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" required>
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" required>
                                        <input type="text" name="one_time_password[]"
                                            class="form-control auth-input text-center numeral-mask" maxlength="1"
                                            pattern="[0-9]" autocomplete="off" required>
                                    </div>
                                    <input type="hidden" name="otp">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="auth-action">
                                <button type="submit" class="primary-button xl-btn w-100">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="switch-page">
                <p>{{ __('Need help?') }} <a href="{{ route('dynamic.page', 'contact') }}">{{ __('Contact Support') }}</a>
                </p>
            </div>
        </div>
    </div>
    <!-- auth area end -->
@endsection

@push('js')
    <script>
        (function($) {
            'use strict';

            // password hide show
            const form = document.querySelector('.twoFAform')
            const inputs = form.querySelectorAll('input')
            console.log(inputs, form)
            const KEYBOARDS = {
                backspace: 8,
                arrowLeft: 37,
                arrowRight: 39,
            }

            function handleInput(e) {
                const input = e.target
                const nextInput = input.nextElementSibling
                if (nextInput && input.value) {
                    nextInput.focus()
                    if (nextInput.value) {
                        nextInput.select()
                    }
                }
            }

            function handlePaste(e) {
                e.preventDefault()
                const paste = e.clipboardData.getData('text')
                inputs.forEach((input, i) => {
                    input.value = paste[i] || ''
                })
            }

            function handleBackspace(e) {
                const input = e.target
                if (input.value) {
                    input.value = ''
                    return
                }

                input.previousElementSibling.focus()
            }

            function handleArrowLeft(e) {
                const previousInput = e.target.previousElementSibling
                if (!previousInput) return
                previousInput.focus()
            }

            function handleArrowRight(e) {
                const nextInput = e.target.nextElementSibling
                if (!nextInput) return
                nextInput.focus()
            }

            form.addEventListener('input', handleInput)
            inputs[0].addEventListener('paste', handlePaste)

            inputs.forEach(input => {
                input.addEventListener('focus', e => {
                    setTimeout(() => {
                        e.target.select()
                    }, 0)
                })

                input.addEventListener('keydown', e => {
                    switch (e.keyCode) {
                        case KEYBOARDS.backspace:
                            handleBackspace(e)
                            break
                        case KEYBOARDS.arrowLeft:
                            handleArrowLeft(e)
                            break
                        case KEYBOARDS.arrowRight:
                            handleArrowRight(e)
                            break
                        default:
                    }
                })
            })

        })(jQuery);
    </script>
@endpush
