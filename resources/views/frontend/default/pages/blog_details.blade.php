@extends('frontend::layouts.app')
@section('title')
    {{ $blog->title }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('content')
    <main>
        @include('frontend::common.page-header', [
            'title' => $blog->title,
        ])
        @yield('page-content')
    </main>
    <!-- Postbox area start -->
    <div class="blog-details-area section_space-my">
        <div class="container">
            <div class="blog-details-content">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="text-editor-content">
                            <img src="{{ asset($blog->cover) }}" alt="{{ $blog->title }} cover image">
                            {!! $blog->details !!}
                        </div>
                        <hr>
                        <div class="share-box">
                            <div class="share">
                                <h6>{{ __('Share') }}:</h6>
                                <div class="share-icon">
                                    <a href="javascript:void(0)"
                                        onclick="navigator.share({ title: '{{ $blog->title }}', url: '{{ route('blog-details', $blog->slug) }}' })">
                                        <iconify-icon icon="hugeicons:share-08" class="social-icon"></iconify-icon>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog-details', $blog->slug)) }}"
                                        target="_blank">
                                        <iconify-icon icon="hugeicons:facebook-02" class="social-icon"></iconify-icon>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . route('blog-details', $blog->slug)) }}"
                                        target="_blank">
                                        <iconify-icon icon="hugeicons:whatsapp" class="social-icon"></iconify-icon>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(route('blog-details', $blog->slug)) }}"
                                        target="_blank">
                                        <iconify-icon icon="hugeicons:new-twitter" class="social-icon"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="trending-topic">
                            @foreach ($popularBlog as $blog)
                                <div class="blog-horizontal-card">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-sm-4">
                                            <a href="{{ route('blog-details', $blog->slug) }}" class="blog-img">
                                                <img src="{{ asset($blog->cover) }}" alt="blog image">
                                            </a>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="blog-content">
                                                <div class="date">
                                                    <div class="icon">
                                                        <iconify-icon icon="hugeicons:calendar-03"
                                                            class="date-icon"></iconify-icon>
                                                    </div>
                                                    <p>{{ \Carbon\Carbon::parse($blog->created_at)->format('d F Y') }}</p>
                                                </div>
                                                <h3><a
                                                        href="{{ route('blog-details', $blog->slug) }}">{{ $blog->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
