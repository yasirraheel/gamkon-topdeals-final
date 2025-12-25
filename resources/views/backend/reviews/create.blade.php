@extends('backend.layouts.app')
@section('title')
    {{ __('Add Review') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add Review') }}</h2>
                            <a href="{{ route('admin.reviews.index') }}" class="title-btn"><i
                                    data-lucide="arrow-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.reviews.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label for="listing_id" class="box-input-label">{{ __('Listing') }}</label>
                                            <select name="listing_id" class="form-select" id="listing_id" required>
                                                <option value="">{{ __('Select Listing') }}</option>
                                                @foreach ($listings as $listing)
                                                    <option value="{{ $listing->id }}">{{ $listing->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label for="buyer_id" class="box-input-label">{{ __('Buyer') }}</label>
                                            <select name="buyer_id" class="form-select" id="buyer_id" required>
                                                <option value="">{{ __('Select Buyer') }}</option>
                                                @foreach ($buyers as $buyer)
                                                    <option value="{{ $buyer->id }}">{{ $buyer->username }} ({{ $buyer->first_name }} {{ $buyer->last_name }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label for="rating" class="box-input-label">{{ __('Rating') }}</label>
                                            <select name="rating" class="form-select" id="rating" required>
                                                <option value="">{{ __('Select Rating') }}</option>
                                                <option value="5">5 {{ __('Stars') }}</option>
                                                <option value="4">4 {{ __('Stars') }}</option>
                                                <option value="3">3 {{ __('Stars') }}</option>
                                                <option value="2">2 {{ __('Stars') }}</option>
                                                <option value="1">1 {{ __('Star') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label for="review" class="box-input-label">{{ __('Review') }}</label>
                                            <textarea name="review" id="review" class="form-textarea" rows="5" required placeholder="{{ __('Write your review here...') }}"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <button type="submit" class="site-btn primary-btn">{{ __('Add Review') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
