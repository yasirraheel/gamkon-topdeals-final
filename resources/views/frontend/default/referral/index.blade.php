@extends('frontend::layouts.user')
@section('title')
    {{ __('Referral') }}
@endsection
@section('content')

    <div class="referral-program">
        <x-luminous.dashboard-breadcrumb title="{{ __('Referral') }}" />
        <div class="">
            <div class="referral-program-box">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="account-balance active">
                            <h5>{{ __('Account Balance') }}</h5>
                            <div class="card-box text-center"
                                data-background="{{ themeAsset('images/referral/account-balance-bg.png') }}">
                                <p>{{ __('Withdrawable Funds') }}</p>
                                <h2>{{ amountWithCurrency(auth()->user()->balance) }}</h2>
                                <a href="{{ route('user.payment.withdraw.index') }}"
                                    class="primary-button mt-2">{{ __('Withdraw') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="successful-referrals">
                            <h5>{{ __('Total Referrals') }}</h5>
                            <div class="card-box"
                                data-background="{{ themeAsset('images/referral/total-referrals-bg.png') }}">
                                <p>{{ __('Successful Referrals') }}</p>
                                <h2>{{ $getReferral?->relationships()?->count() ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="link-share-box">
                            <div class="referral-link-content">
                                <div class="referral-link-input">
                                    @if ($getReferral)
                                        <input type="text" value="{{ $getReferral?->link }}" readonly>
                                        <button class="copy-btn">{{ __('Copy') }}</button>
                                    @else
                                        <div class="alert alert-warning">
                                            {{ __('No referral link found. Please generate one.') }}
                                            <a href="{{ buyerSellerRoute('referral.generate') }}"
                                                class="btn btn-sm btn-primary ms-2">
                                                {{ __('Generate Link') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <p>{{ __(':people_count People join using this link', ['people_count' => $getReferral?->relationships()?->count() ?? 0]) }}
                                </p>
                                @if ($getReferral)
                                    <div class="share-link">
                                        <h5>{{ __('Share Url:') }}</h5>
                                        <div class="share-btn">
                                            <button class="share-btn-item">
                                                <iconify-icon icon="lucide:share-2" class="share-icon"></iconify-icon>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if (is_array($rules) && setting('referral_rules_visibility'))
                    <div class="how-to-earn">
                        <h4>{{ __('How to Earn with Our Referral Program') }}</h4>
                        <div class="earn-box">
                            @foreach ($rules as $rule)
                                <div class="earn-list">
                                    <h6>{{ $loop->iteration }}. {{ $rule->title }}</h6>
                                    <p>{{ $rule->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="transactions-history-box mt-4">
        <div class="sort-title sort-title-2">
            <h4>{{ __('Referred Users') }}</h4>
            <div class="table-sort">
                <div class="left">
                    <a href="{{ buyerSellerRoute('referral.tree') }}" class="primary-button">{{ __('Referral Tree') }}</a>
                </div>
            </div>
        </div>
        <div class="common-table">
            <div class="common-table-full">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Joined At') }}</th>
                            <th>{{ __('Total Sold') }}</th>
                            <th>{{ __('Total Purchased') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($refferedUsers as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->total_sold }} ({{ amountWithCurrency($user->total_amount_sold) }})</td>
                                <td>{{ $user->total_purchased }} ({{ amountWithCurrency($user->total_amount_sold) }})</td>
                                <td>
                                    <span
                                        class="badge {{ $user->status == 1 ? 'success' : 'danger' }}">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <x-luminous.no-data-found type="Referred Users" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';
        $(document).on('click', '.share-btn-item', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'Referral Link',
                    text: 'Join using my referral link!',
                    url: '{{ $getReferral?->link }}',
                }).catch(console.error);
            } else {
                alert('Your browser does not support the Web Share API.');
            }
        })
    </script>
@endpush
