@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])
@section('title')
    {{ $category->name ?? __('All Categories') }}
@endsection
@section('meta_keywords')
    {{ trim(setting('meta_keywords', 'meta')) }}
@endsection
@section('meta_description')
    {{ trim(setting('meta_description', 'meta')) }}
@endsection

@section('content')
    @include('frontend::common.page-header', [
        'title' => __('Search Result of :query', ['query' => request('q')]),
    ])
    <div class="container section_space-py">
        <div class="all-games-page">
            <form class="all-games-filter-form" method="get" id="searchForm" action="">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <div class="all-games-filter all-games-filter-box">
                    <div class="filter-button-box">
                        @if (!$allCategories->isEmpty())
                            <a href="{{ route('all.listing') }}"
                                class="filter-button filter-button-2 {{ !request('category') ? 'active' : '' }}">
                                <img src="{{ themeAsset('/images/product-category/category-icon-1.png') }}" alt="All">
                                <span>{{ __('All') }}</span>
                            </a>
                        @endif
                        @foreach ($allCategories as $index => $categoryData)
                            <a href="{{ route('search.listing', array_merge(request()->query(), ['category' => $categoryData->slug])) }}"
                                class="filter-button filter-button-2 {{ $categoryData->slug == request('category') ? 'active' : '' }}">
                                <img src="{{ asset($categoryData->image) }}" alt="{{ $categoryData->name }}">
                                <span>{{ $categoryData->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="all-games-filter title_mt">
                    <div class="left-filter">
                        <div class="price-range">
                            <div class="title">
                                <h6>{{ __('Price Range') }}:</h6>
                            </div>
                            <div class="all-range">
                                <div class="price-range-box">
                                    <p>{{ __('Min') }}</p>
                                    <div class="td-form-group">
                                        <div class="input-field">
                                            <input type="number" class="form-control" value="{{ request('min_price') }}"
                                                name="min_price" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="price-range-box-saperate"><span></span></div>
                                <div class="price-range-box">
                                    <p>{{ __('Max') }}</p>
                                    <div class="td-form-group">
                                        <div class="input-field">
                                            <input type="number" class="form-control" value="{{ request('max_price') }}"
                                                name="max_price" placeholder="1000">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="primary-button">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-filter">
                        <div class="filters">
                            <div class="sort-filter common-filter">
                                <select class="nice-select-active" name="sort">
                                    <option value="">{{ __('Sort by') }}</option>
                                    <option value="max-to-min" @selected(request('sort') == 'max-to-min')>{{ __('Max to Min') }}</option>
                                    <option value="min-to-max" @selected(request('sort') == 'min-to-max')>{{ __('Min to Max') }}</option>
                                    <option value="trending" @selected(request('sort') == 'trending')>{{ __('Trending') }}</option>
                                    <option value="best-rated" @selected(request('sort') == 'best-rated')>{{ __('Best Rated') }}</option>
                                    <option value="newest" @selected(request('sort') == 'newest')>{{ __('Newest') }}</option>
                                    <option value="oldest" @selected(request('sort') == 'oldest')>{{ __('Oldest') }}</option>
                                    <option @selected(request('sort') == 'flash-sale') value="flash-sale">{{ __('Flash Sale') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="all-games-box title_mt">
                <div class="row g-4">
                    @forelse ($listings as $listing)
                        @include('frontend::listings.include.category-block', [
                            'listing' => $listing,
                            'hasAnimation' => true,
                            'loop' => $loop,
                        ])
                    @empty
                        <x-luminous.no-data-found type="Search Item" />
                    @endforelse
                </div>
                <div class="common-pagination title_mt">
                    {{ $listings->withQueryString() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';

        $(document).on('change', 'select', function() {
            $('#searchForm').submit();
        })
    </script>
@endpush
