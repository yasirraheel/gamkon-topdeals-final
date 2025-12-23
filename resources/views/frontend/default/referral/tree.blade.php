@extends('frontend::layouts.user')
@section('title')
    {{ __('Referral Tree') }}
@endsection
@section('content')
    <div class="referrals-tree">
        <div class="title">
            <h4>{{ __('Referral Tree') }}</h4>
        </div>
        <div class="referrals-tree-box">
            <div class="referral-program-section default-area-style">
                <div class="td-referral-tree-wrapper table-responsive">
                    <div class="td-referral-tree">
                        @if ($user->referrals->count() > 0)
                            <ul>
                                <li>
                                    @include('frontend::referral.include.__tree', [
                                        'levelUser' => $user,
                                        'level' => $level,
                                        'depth' => 1,
                                        'me' => true,
                                    ])
                                </li>
                            </ul>
                        @else
                            <x-luminous.no-data-found type="Referral Tree" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
