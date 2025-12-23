@extends('frontend::layouts.app', ['bodyClass' => 'home-2'])
@section('title', $category->name ?? __('All Items'))
@section('meta_keywords', trim(setting('meta_keywords', 'meta')))
@section('meta_description', trim($category->description ?? setting('meta_description', 'meta')))

@section('content')
    @include('frontend::common.page-header', [
        'title' => $category?->name ? __(':category', ['category' => $category->name]) : __('All Items'),
    ])
    <div class="container section_space-my">
        <div class="all-games-page">
            <div class="all-games-area bg-transparent section_space-mY">
                <div class="all-games-filter all-games-filter-box">
                    <div class="filter-button-box">
                        @if (!$allCategories->isEmpty())
                            <a href="{{ route('all.listing') }}"
                                class="filter-button filter-button-2 {{ !$category ? 'active' : '' }}">
                                <img src="{{ themeAsset('/images/product-category/category-icon-1.png') }}" alt="All">
                                <span>{{ __('All') }}</span>
                            </a>
                        @endif
                        @foreach ($allCategories as $index => $categoryData)
                            <a href="{{ route('category.listing', $categoryData->slug) }}"
                                class="filter-button filter-button-2 {{ $categoryData->slug == $reqCat?->slug || $categoryData->id == $reqCat?->parent_id ? 'active' : '' }}">
                                <img src="{{ asset($categoryData->image) }}" alt="{{ $categoryData->name }}">
                                <span>{{ $categoryData->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <form class="all-games-filter all-games-filter-form title_mt">
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
                                            name="min_price" placeholder="$0">
                                    </div>
                                </div>
                            </div>
                            <div class="price-range-box-saperate">
                                <span></span>
                            </div>
                            <div class="price-range-box">
                                <p>{{ __('Max') }}</p>
                                <div class="td-form-group">
                                    <div class="input-field">
                                        <input type="number" class="form-control" value="{{ request('max_price') }}"
                                            name="max_price" placeholder="$1000">
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
                            <select class="nice-select-active" name="per_page">
                                <option value="">{{ __('Per Page') }}</option>
                                @foreach (range(12, 40, 4) as $pageNo)
                                    <option @selected(request('per_page') == $pageNo) value="{{ $pageNo }}">
                                        {{ $pageNo }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($category && ($category->parent_id || $category->children->count()))
                            <div class="sort-filter common-filter">
                                <select class="nice-select-active" name="category">
                                    <option value="">{{ __('Subcategory') }}</option>
                                    @foreach ($category->parent_id ? $category->parent->children : $category->children()->active()->get() as $subcategory)
                                        <option @selected(request('category') && request('category') == $subcategory->slug) value="{{ $subcategory->slug }}">
                                            {{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="sort-filter common-filter">
                            <select class="nice-select-active" name="sort">
                                <option @selected(request('sort') == '') value="">{{ __('Sort by') }}</option>
                                <option @selected(request('sort') == 'max-to-min') value="max-to-min">{{ __('Max to Min') }}</option>
                                <option @selected(request('sort') == 'min-to-max') value="min-to-max">{{ __('Min to Max') }}</option>
                                <option @selected(request('sort') == 'trending') value="trending">{{ __('Trending') }}</option>
                                <option @selected(request('sort') == 'best-rated') value="best-rated">{{ __('Best Rated') }}</option>
                                <option @selected(request('sort') == 'newest') value="newest">{{ __('Newest') }}</option>
                                <option @selected(request('sort') == 'oldest') value="oldest">{{ __('Oldest') }}</option>
                                <option @selected(request('sort') == 'flash-sale') value="flash-sale">{{ __('Flash Sale') }}</option>

                            </select>
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
                        <x-luminous.no-data-found type="{{ __('Items') }}" has-bg="true" />
                    @endforelse
                </div>
                <div class="common-pagination title_mt">
                    {{ $listings->withQueryString()->links() }}
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
        $(document).on('change', '.common-filter select', function() {
            $('.all-games-filter-form').submit();
        })
    </script>
@endpush
