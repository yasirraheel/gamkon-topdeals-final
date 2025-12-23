@extends('frontend::layouts.user')
@section('title')
    {{ __('Followers List') }}
@endsection
@push('css')
@endpush
@section('content')
    <div class="follow">
        <h4>{{ __('Followers List') }}</h4>
        <div class="follow-box">
            <div class="row g-4 all-following">
                @forelse ($followers as $follow)
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2">
                        @include('frontend::seller.seller-card', ['seller' => $follow, ($isTwo = true)])
                    </div>

                @empty
                    <x-luminous.no-data-found type="followers" />
                @endforelse
                {{ $followers->links() }}
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
