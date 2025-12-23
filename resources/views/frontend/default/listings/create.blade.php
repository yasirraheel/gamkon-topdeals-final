@extends('frontend::layouts.user')
@section('title')
    {{ __('Create Listing') }}

    {{-- @dd(request()->route()->getName()) --}}
@endsection
@section('content')
    <div class="create-listing-box">
        <div class="create-listing-overview">
            @include('frontend::listings.include.step_list', ['listing' => $data['listing'] ?? null])
            <div class="choose-common-container">
                @include('frontend::listings.create.steps.' . $step, $data)
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';
        $(document).on('click', '.has-not-cursor', function() {
            return false;
        });
    </script>
@endpush
