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
        $sections = \App\Models\LandingPage::where('code', 'faq')->get();
    @endphp

    @foreach ($sections as $section)
        @include('frontend::home.include.__' . $section->code, [
            'data' => json_decode($section->data, true),
        ])
    @endforeach

    <!-- section  -->
    @if (isset($data->section_id) && $data->section_id)
        @php
            $sections = \App\Models\LandingPage::whereIn('id', $section_ids)
                ->when($commaIds != null && !blank($commaIds), function ($query) use ($commaIds) {
                    $query->orderByRaw("FIELD(id, $commaIds)");
                })
                ->get();
        @endphp

        @foreach ($sections as $section)
            @include('frontend::home.include.__' . $section->code, [
                'data' => json_decode($section->data, true),
            ])
        @endforeach
    @endif
    <!-- section end-->
@endsection
