@extends('frontend::layouts.app',['bodyClass' => 'home-2'])
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
@include('frontend::common.page-header', ['title' =>  __('All Categories')])
<section class="category-area section_space-py">
    <div class="container">
      <div class="category-all title_mt">
        <div class="category-all-card {{ $allCategories->isEmpty() ? 'd-block' : '' }}">
          @forelse ($allCategories as $category)
            <a href="{{ route('category.listing', $category->slug) }}" class="category-card">
              <div class="icon">
                <img src="{{ asset($category->image) }}" alt="">
              </div>
              <div class="text">
                <h5>{{ $category->name }}</h5>
                <p>{{ $category->listings_count }} {{ __('Offers') }}</p>
              </div>
            </a>
          @empty
            <x-luminous.no-data-found has-bg type="Categories" class="mt-3" />
          @endforelse
        </div>
      </div>
    </div>
  </section>
@endsection
