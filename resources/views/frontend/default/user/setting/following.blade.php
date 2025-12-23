@extends('frontend::layouts.user')
@section('title')
    {{ __('Following List') }}
@endsection
@push('css')
@endpush
@section('content')
    <div class="follow">
        <div class="transactions-history-box sold-orders-box">
            <x-luminous.dashboard-breadcrumb title="{{ __('Following List') }}" />
        </div>

        <div class="all-follow-list">
            <div class="row g-4">
                @forelse ($following as $follow)
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2">
                        @include('frontend::seller.seller-card', ['seller' => $follow, ($isTwo = true)])
                    </div>

                @empty
                    <x-luminous.no-data-found type="following" />
                @endforelse
                {{ $following->links() }}
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
