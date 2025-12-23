@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])
@section('title')
    {{ __('All Sellers') }}
@endsection
@section('meta_keywords')
    {{ trim(setting('meta_keywords', 'meta')) }}
@endsection
@section('meta_description')
    {{ trim(setting('meta_description', 'meta')) }}
@endsection

@section('content')
    @include('frontend::common.page-header', ['title' => __('All Sellers')])
    <div class="all-seller-page-area section_space-py">
        <div class="container">
            <div class="all-games-filter">
                <div class="left-filter">

                </div>
                <div class="right-filter">
                    <form action="" class="" id="searchForm">
                        <div class="filters">
                            <div class="category-flter common-filter">
                                <select name="sort" class="nice-select-active" style="display: none;">
                                    <option value="">{{ __('Select Sort') }}</option>
                                    <option value="newest" selected="">{{ __('Newest') }}</option>
                                    <option value="oldest">{{ __('Oldest') }}</option>
                                    <option value="popular">{{ __('Popular') }}</option>
                                    <option value="best-seller">{{ __('Best Sellers') }}</option>
                                    <option value="rated">{{ __('Best Rated') }}</option>

                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="all-seller-page-cards title_mt {{ $sellers->isEmpty() ? 'd-block' : '' }}">
                @forelse ($sellers as $seller)
                    <div class="all-seller-card">
                        @include('frontend::seller.seller-card', ['seller' => $seller])
                    </div>
                @empty
                    <x-luminous.no-data-found type="Seller" />
                @endforelse
            </div>
            <div class="common-pagination title_mt">
                {{ $sellers->withQueryString() }}
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';
        $(document).on('change', '#searchForm', function() {
            $('#searchForm').submit();
        })
    </script>
@endpush
