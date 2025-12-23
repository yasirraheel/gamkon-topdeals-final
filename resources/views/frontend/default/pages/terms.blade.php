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
    <div class="common-auth-page-text section_space-py">
        <div class="container">
            <div class="text-editor-content">
                {!! $data['content'] !!}
            </div>
        </div>
    </div>
@endsection
