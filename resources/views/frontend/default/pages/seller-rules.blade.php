@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')
    @php
        $landingContent = getLandingContents('what-i-can-do');
    @endphp
    <div class="what-you-can-sell section_space-my">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="left">
                        <div class="all-what-can-sell-content">
                            @foreach ($landingContent as $content)
                                <div class="content-box">
                                    <h5>{{ $loop->iteration }}. {{ $content->title }}</h5>
                                    <p>{{ $content->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="action-button mt-5">
                        <a href="{{ route('register') }}" target="_blank" class="primary-button xl-btn">
                            {{ 'Register Seller' }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right">
                        <div class="image-box">
                            <img src="{{ asset($data->right_image) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
