@extends('frontend::layouts.app', ['bodyClass' => '', 'mainClass' => ''])
@section('title', __('Home'))
@push('css')
    <style>
        .swiper-wrapper {
            height: fit-content;
        }
    </style>
@endpush
@section('meta_keywords', trim(setting('meta_keywords', 'meta')))
@section('meta_description', trim(setting('meta_description', 'meta')))

@section('content')
    @foreach ($homeContent as $content)
        @php
            $data = json_decode($content->data, true);
        @endphp
        @include('frontend::home.include.__' . $content->code, [
            'data' => $data,
            'bgClass' =>
                !in_array($content->code, ['hero', 'cta-banner', 'blog']) && $loop->odd ? 'section-bg' : '',
        ])
    @endforeach
@endsection
