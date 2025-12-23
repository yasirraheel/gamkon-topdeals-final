@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords', $data['meta_keywords'])
@section('meta_description', $data['meta_description'])
@section('page-content')

    @php
        $blogs = \App\Models\Blog::where('locale', app()->getLocale())
            ->latest()
            ->paginate(9);
    @endphp
    <!-- Blog area start -->
    <section class="blogs-area section_space-my">
        <div class="container">
            <div class="blogs-area-content">
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                        @include('frontend::pages.include.__blog-card', ['blog' => $blog])
                    @endforeach
                </div>
                <div class="common-pagination">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- Blog area end -->
@endsection
