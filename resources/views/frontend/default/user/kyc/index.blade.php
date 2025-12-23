@extends('frontend::layouts.user')
@section('title')
    {{ __('ID Verification') }}
@endsection
@section('sellerKycSection', 'active')
@section('content')
    <div class="transactions-history-box">
        <x-luminous.dashboard-breadcrumb title="{{ __('ID Verification Center') }}" />
        <div class="">
            <div class="all-verification-box">

                <div class="verification-box">
                    <div class="verification-center verification-card">
                        @if ($user->kyc == \App\Enums\KYCStatus::Verified->value)
                            <div class="verification-buttons justify-content-center">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="49" height="49" viewBox="0 0 49 49"
                                        fill="none">
                                        <g clip-path="url(#clip0_518_3840)">
                                            <path
                                                d="M24.5 49C38.031 49 49 38.031 49 24.5C49 10.969 38.031 0 24.5 0C10.969 0 0 10.969 0 24.5C0 38.031 10.969 49 24.5 49Z"
                                                fill="#31B269"></path>
                                            <path
                                                d="M20.557 34.9504L10.9102 25.4184L14.3937 21.8582L20.557 27.9449L34.6063 14.0488L38.0898 17.5707L20.557 34.9504Z"
                                                fill="white"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_518_3840">
                                                <rect width="49" height="49" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p>{{ __('You have submitted your documents and it is verified') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="verification-buttons justify-content-center">
                                @forelse ($kycs as $kyc)
                                    <a href="{{ buyerSellerRoute('kyc.submission', encrypt($kyc->id)) }}"
                                        class="primary-button">
                                        {{ $kyc->name }}
                                    </a>
                                @empty
                                    <x-luminous.no-data-found type="Submittable KYC" />
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>


                <div class="verification-box">
                    <h4>{{ __('KYC History') }}</h4>
                    <div class="verification-center verification-card">
                        <div class="all-table-card">
                            @forelse ($user_kycs as $kyc)
                                <div class="table-card">
                                    <div class="left">
                                        <div class="left-card">
                                            <div class="icon">
                                                @if ($kyc->status == 'approved')
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="49" height="49"
                                                        viewBox="0 0 49 49" fill="none">
                                                        <g clip-path="url(#clip0_518_3840)">
                                                            <path
                                                                d="M24.5 49C38.031 49 49 38.031 49 24.5C49 10.969 38.031 0 24.5 0C10.969 0 0 10.969 0 24.5C0 38.031 10.969 49 24.5 49Z"
                                                                fill="#31B269"></path>
                                                            <path
                                                                d="M20.557 34.9504L10.9102 25.4184L14.3937 21.8582L20.557 27.9449L34.6063 14.0488L38.0898 17.5707L20.557 34.9504Z"
                                                                fill="white"></path>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_518_3840">
                                                                <rect width="49" height="49" fill="white"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                @elseif($kyc->status == 'rejected')
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                        viewBox="0 0 50 50" fill="none">
                                                        <path
                                                            d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z"
                                                            fill="#DC3545"></path>
                                                        <path
                                                            d="M14.9889 34.9444C15.2473 35.2065 15.5552 35.4146 15.8948 35.5566C16.2343 35.6986 16.5986 35.7717 16.9667 35.7717C17.3347 35.7717 17.6991 35.6986 18.0386 35.5566C18.3781 35.4146 18.686 35.2065 18.9445 34.9444L24.9333 28.9556L30.9222 34.9444C31.4468 35.469 32.1582 35.7637 32.9 35.7637C33.6418 35.7637 34.3533 35.469 34.8778 34.9444C35.4023 34.4199 35.697 33.7085 35.697 32.9667C35.697 32.2248 35.4023 31.5134 34.8778 30.9889L28.8889 25L34.8778 19.0111C35.1375 18.7514 35.3435 18.443 35.4841 18.1037C35.6247 17.7643 35.697 17.4006 35.697 17.0333C35.697 16.666 35.6247 16.3023 35.4841 15.963C35.3435 15.6236 35.1375 15.3153 34.8778 15.0555C34.6181 14.7958 34.3097 14.5898 33.9704 14.4492C33.631 14.3087 33.2673 14.2363 32.9 14.2363C32.5327 14.2363 32.169 14.3087 31.8296 14.4492C31.4903 14.5898 31.182 14.7958 30.9222 15.0555L24.9333 21.0444L18.9445 15.0555C18.6847 14.7958 18.3764 14.5898 18.037 14.4492C17.6977 14.3087 17.334 14.2363 16.9667 14.2363C16.5994 14.2363 16.2357 14.3087 15.8963 14.4492C15.557 14.5898 15.2486 14.7958 14.9889 15.0555C14.7292 15.3153 14.5231 15.6236 14.3826 15.963C14.242 16.3023 14.1697 16.666 14.1697 17.0333C14.1697 17.4006 14.242 17.7643 14.3826 18.1037C14.5231 18.7514 14.7292 18.7514 14.9889 19.0111L20.9778 25L14.9889 30.9889C14.7269 31.2473 14.5188 31.5552 14.3768 31.8947C14.2348 32.2343 14.1616 32.5986 14.1616 32.9667C14.1616 33.3347 14.2348 33.6991 14.3768 34.0386C14.5188 34.3781 14.7269 34.686 14.9889 34.9444Z"
                                                            fill="#FFF7ED"></path>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                        viewBox="0 0 50 50" fill="none">
                                                        <g clip-path="url(#clip0_518_3876)">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M50 25C50 38.8071 38.8071 50 25 50C11.1929 50 0 38.8071 0 25C0 11.1929 11.1929 0 25 0C38.8071 0 50 11.1929 50 25ZM25 12.5V25H12.5V29.1667H29.1667V12.5H25Z"
                                                                fill="#FF8D29"></path>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_518_3876">
                                                                <rect width="50" height="50" fill="white"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text">
                                                <h6>{{ __(':name', ['name' => $kyc->kyc?->name ?? $kyc->type]) }}</h6>
                                                <p>{{ __('Submission Date') }}:
                                                    {{ $kyc->created_at->format('d M Y h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <p
                                            class="badge {{ $kyc->status == 'approved' ? 'success' : ($kyc->status == 'rejected' ? 'error' : 'pending') }}">
                                            {{ ucfirst($kyc->status) }}</p>
                                        <div class="view">
                                            <a href="javascript:void(0)"
                                                class="primary-button details-btn border-btn-secondary"
                                                data-id="{{ $kyc->id }}">{{ __('View Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <x-luminous.no-data-found type="KYC History" />
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="common-modal-full" id="kycDetails">
        <div class="common-modal-box">
            <div class="content">
                <div class="add-new-withdrawal">
                    <h4>{{ __('KYC Details') }}</h4>
                    <div class="add-forms">
                    </div>
                    <div class="logout-content">
                        <div class="logout-buttons modal-action-btn">
                            <button class="primary-button border-btn close">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        "use strict";
        $(document).on('click', '.details-btn', function() {

            let id = $(this).data('id');

            $.get("{{ buyerSellerRoute('kyc.details') }}", {
                id: id
            }, function(response) {
                $('.add-forms').html(response.html);
                $('#kycDetails').addClass('open');
            });

        });
    </script>
@endpush
