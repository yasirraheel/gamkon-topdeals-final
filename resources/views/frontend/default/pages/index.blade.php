@extends('frontend::layouts.app')

@section('content')
    <main>
        @include('frontend::common.page-header', [
            'title' =>
                Route::getCurrentRoute()->getName() == 'blog-details' ? $blog->title : $data['title'] ?? $title,
        ])
        @yield('page-content')
    </main>
@endsection
