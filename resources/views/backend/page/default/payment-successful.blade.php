@extends('backend.layouts.app')
@section('title')
    {{ __('Payment Successful') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Payment Successful Page') }}</h2>
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
                                <form action="{{ route('admin.page.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="page_code" value="payment-successful">
                                    <input type="hidden" name="page_locale" value="{{ $key }}">
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Title') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="box-input"
                                                value="{{ $data->title }}">
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Bottom Text') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="bottom_text" class="box-input"
                                                value="{{ $data->bottom_text }}">
                                        </div>
                                    </div>
                                    @if ($key == 'en')
                                        <div class="site-input-groups row">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                                {{ __('Image') }} <small>({{ __('626x626') }})</small>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                                <div class="wrap-custom-file">
                                                    <input type="file" name="image" id="heroRightTopImg"
                                                        accept=".gif, .jpg, .png" />
                                                    <label for="heroRightTopImg" id="image"
                                                        @if ($data->image) class="file-ok"
                                                   style="background-image: url({{ asset($data->image) }})" @endif>
                                                        <img class="upload-icon"
                                                            src="{{ asset('global/materials/upload.svg') }}"
                                                            alt="" />
                                                        <span>{{ __('Update Image') }}</span>
                                                    </label>
                                                    @removeimg($data->image, right_image)
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit"
                                                class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
@endsection
