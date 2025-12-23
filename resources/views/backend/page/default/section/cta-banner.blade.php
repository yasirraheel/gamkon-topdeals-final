@extends('backend.layouts.app')
@section('title')
    {{ __('CTA Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('CTA Section') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="site-tab-bars">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item" role="presentation">
                            <a href="" class="nav-link  {{ $loop->index == 0 ? 'active' : '' }}"
                                id="pills-informations-tab" data-bs-toggle="pill" data-bs-target="#{{ $language->locale }}"
                                type="button" role="tab" aria-controls="pills-informations" aria-selected="true"><i
                                    data-lucide="languages"></i>{{ $language->name }}</a>
                        </li>
                    @endforeach


                </ul>
            </div>

            <div class="tab-content" id="pills-tabContent">

                @foreach ($groupData as $key => $value)
                    @php
                        $data = new Illuminate\Support\Fluent($value);
                    @endphp

                    <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $key }}"
                        role="tabpanel" aria-labelledby="pills-informations-tab">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Contents') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="section_code" value="cta-banner">
                                    <input type="hidden" name="section_locale" value="{{ $key }}">
                                    @if ($key == 'en')
                                        <div class="site-input-groups row">
                                            <label for=""
                                                class="col-sm-3 col-label pt-0">{{ __('Section Visibility') }}<i
                                                    data-lucide="info" data-bs-toggle="tooltip" title=""
                                                    data-bs-original-title="Manage Section Visibility"></i></label>
                                            <div class="col-sm-3">
                                                <div class="site-input-groups">
                                                    <div class="switch-field">
                                                        <input type="radio" id="active" name="status"
                                                            @if ($status) checked @endif
                                                            value="1" />
                                                        <label for="active">{{ __('Show') }}</label>
                                                        <input type="radio" id="deactivate" name="status"
                                                            @if (!$status) checked @endif
                                                            value="0" />
                                                        <label for="deactivate">{{ __('Hide') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Title') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="box-input"
                                                value="{{ $data->title }}">
                                            <small class="text-muted">
                                                {{ __('Use this shortcode to highlight words. Example: [[color_text= Your Text Here ]]') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Button') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                        <div class="col-sm-9">
                                            <div class="form-row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for=""
                                                            class="box-input-label">{{ __('Button Label') }}</label>
                                                        <input type="text" name="button_level" class="box-input"
                                                            value="{{ $data->button_level }}">
                                                    </div>
                                                </div>
                                                @if ($key == 'en')
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for=""
                                                                class="box-input-label">{{ __('Button URL') }}</label>
                                                            <div class="site-input-groups">
                                                                <div class="site-input-groups">
                                                                    <input type="text" name="button_url"
                                                                        class="box-input" value="{{ $data->button_url }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for=""
                                                                class="box-input-label">{{ __('Target') }}</label>
                                                            <div class="site-input-groups">
                                                                <select name="button_target" class="form-select">
                                                                    <option
                                                                        @if ($data->button_target == '_self') selected @endif
                                                                        value="_self">{{ __('Same Tab') }}</option>
                                                                    <option
                                                                        @if ($data->button_target == '_blank') selected @endif
                                                                        value="_blank">{{ __('Open In New Tab') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-row">

                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for=""
                                                            class="box-input-label">{{ __('2nd Button Label') }}</label>
                                                        <input type="text" name="second_button_level"
                                                            class="box-input" value="{{ $data->second_button_level }}">
                                                    </div>
                                                </div>
                                                @if ($key == 'en')
                                                    {{-- 2nd button --}}
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for=""
                                                                class="box-input-label">{{ __('2nd Button URL') }}</label>
                                                            <div class="site-input-groups">
                                                                <div class="site-input-groups">
                                                                    <input type="text" name="second_button_url"
                                                                        class="box-input"
                                                                        value="{{ $data->second_button_url }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for=""
                                                                class="box-input-label">{{ __('2nd Button Target') }}</label>
                                                            <div class="site-input-groups">
                                                                <select name="second_button_target" class="form-select">
                                                                    <option
                                                                        @if ($data->second_button_target == '_self') selected @endif
                                                                        value="_self">{{ __('Same Tab') }}</option>
                                                                    <option
                                                                        @if ($data->second_button_target == '_blank') selected @endif
                                                                        value="_blank">{{ __('Open In New Tab') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($key == 'en')
                                        <div class="site-input-groups row">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                                {{ __('Background Image') }} <small>(1440x812)</small>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                                <div class="wrap-custom-file">
                                                    <input type="file" name="background_image" id="leftSmallestImg"
                                                        accept=".gif, .jpg, .png" />
                                                    <label for="leftSmallestImg" id="background_image"
                                                        @if ($data['background_image']) class="file-ok" style="background-image: url({{ asset($data['background_image']) }})" @endif>
                                                        <img class="upload-icon"
                                                            src="{{ asset('global/materials/upload.svg') }}"
                                                            alt="" />
                                                        <span>{{ __('Update Image') }}</span>
                                                    </label>
                                                    @removeimg($data['background_image'], background_image)
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit"
                                                class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="section-design-nb">
                <strong>NB:</strong>{{ __('All Categories will come from') }} <a
                    href="{{ route('admin.category.index') }}">{{ __('Category') }}</a>
                {{ __('page') }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.page.section.include.__section_image_remove')
@endsection
