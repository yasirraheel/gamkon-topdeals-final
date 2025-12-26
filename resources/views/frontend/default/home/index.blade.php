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

@section('meta')
    @php
        $metaTitle = setting('site_title', 'global');
        $metaDesc = trim(setting('meta_description', 'meta'));
        $metaImg = asset(setting('site_logo', 'global'));
    @endphp
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:image" content="{{ $metaImg }}">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image" content="{{ $metaImg }}">
@endsection

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
