@extends('backend.layouts.app')
@section('title')
    {{ __('Hero Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Hero Section') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="site-tab-bars">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    @foreach($languages as $language)
                        <li class="nav-item" role="presentation">
                            <a
                                href=""
                                class="nav-link  {{ $loop->index == 0 ?'active' : '' }}"
                                id="pills-informations-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#{{$language->locale}}"
                                type="button"
                                role="tab"
                                aria-controls="pills-informations"
                                aria-selected="true"
                            ><i data-lucide="languages"></i>{{$language->name}}</a
                            >
                        </li>
                    @endforeach
    
    
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
    
                @foreach($groupData as $key => $value)
    
                 @php
                    $data = new Illuminate\Support\Fluent($value);
                 @endphp
    
                    <div
                        class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}"
                        id="{{$key}}"
                        role="tabpanel"
                        aria-labelledby="pills-informations-tab"
                    >
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Contents') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="section_code" value="hero">
                                    <input type="hidden" name="section_locale" value="{{$key}}">
                                    @if($key == 'en')
                                        <div class="site-input-groups row">
                                            <label for="" class="col-sm-3 col-label pt-0">{{ __('Section Visibility') }}<i
                                                    data-lucide="info" data-bs-toggle="tooltip" title=""
                                                    data-bs-original-title="Manage Section Visibility"></i></label>
                                            <div class="col-sm-3">
                                                <div class="site-input-groups">
                                                    <div class="switch-field">
                                                        <input type="radio" id="active" name="status" @if($status) checked
                                                               @endif value="1"/>
                                                        <label for="active">{{ __('Show') }}</label>
                                                        <input type="radio" id="deactivate" name="status" @if(!$status) checked
                                                               @endif value="0"/>
                                                        <label for="deactivate">{{ __('Hide') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Hero Title') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="hero_title" class="box-input"
                                                   value="{{ $data->hero_title }}">
                                            <small class="text-muted mt-4">
                                                {{ __('Use this shortcode to highlight words. Example: [[color_text= Your Text Here ]]') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Hero Description') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="hero_description" class="box-input"
                                                   value="{{ $data->hero_description }}">

                                        </div>
                                    </div>
      
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Hero Button') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                        <div class="col-sm-9">
                                            <div class="form-row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for=""
                                                               class="box-input-label">{{ __('Button Label') }}</label>
                                                        <input type="text" name="hero_button_level" class="box-input"
                                                               value="{{ $data->hero_button_level }}">
                                                    </div>
                                                </div>
                                                @if($key == 'en')
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for="" class="box-input-label">{{ __('Button URL') }}</label>
                                                            <div class="site-input-groups">
                                                                <div class="site-input-groups">
                                                                    <input type="text" name="hero_button_url" class="box-input"
                                                                           value="{{ $data->hero_button_url }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="site-input-groups">
                                                            <label for="" class="box-input-label">{{ __('Target') }}</label>
                                                            <div class="site-input-groups">
                                                                <select name="hero_button_target" class="form-select">
                                                                    <option @if($data->hero_button_target == '_self') selected
                                                                            @endif value="_self">{{ __('Same Tab') }}</option>
                                                                    <option @if($data->hero_button_target == '_blank') selected
                                                                            @endif value="_blank">{{ __('Open In New Tab') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($key == 'en')
                                    
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Background Image') }} <small>(1440x812)</small>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="wrap-custom-file">
                                                <input type="file" name="background_image" id="backgroundImg" accept=".gif, .jpg, .png"/>
                                                <label for="backgroundImg" id="background_image" @if($data['background_image']) class="file-ok" style="background-image: url({{ asset($data['background_image']) }})" @endif>
                                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                    <span>{{ __('Update Image') }}</span>
                                                </label>
                                                @removeimg($data['background_image'],background_image)
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hero Avatar Images Section -->
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Hero Avatar Image') }}
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="box-input-label">{{ __('Hero Avatar') }}</label>
                                                    <div class="wrap-custom-file">
                                                        <input type="file" name="hero_avatar" id="heroAvatar1" accept=".gif, .jpg, .png"/>
                                                        <label for="heroAvatar1" id="hero_avatar" @if($data['hero_avatar']) class="file-ok" style="background-image: url({{ asset($data['hero_avatar']) }})" @endif>
                                                            <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                            <span>{{ __('Update Image') }}</span>
                                                        </label>
                                                        @removeimg($data['hero_avatar'],hero_avatar)
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    @endif

                                    <!-- User Stats Section -->
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('All Users Stats') }}
                                        </div>
                                        <div class="col row">
                                            <div class="col-md-6">
                                                <label for="all_users_count" class="col-sm-3 col-label">{{ __('Count') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="all_users_count" class="box-input"
                                                        placeholder="500+"
                                                        value="{{ $data->all_users_count }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="all_users_text" class="col-sm-3 col-label">{{ __('Text') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="all_users_text" class="box-input"
                                                        placeholder="All User"
                                                        value="{{ $data->all_users_text }}">
                                                </div>
                                            </div>
                                            @if ($key == 'en')
                                                <div class="col-12">
                                                    <label class="col-sm-3 col-label">{{ __('User Profile Images') }}</label>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="wrap-custom-file">
                                                                <input type="file" name="hero_user" id="hero_user" accept=".gif, .jpg, .png" />
                                                                <label for="hero_user" class="file-ok"
                                                                    style="background-image: url( {{ asset($data->hero_user) }} )">
                                                                    <img class="upload-icon"
                                                                        src="{{ asset('global/materials/upload.svg') }}"
                                                                        alt="" />
                                                                    <span>{{ __('User 1') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Positive Review Section -->
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Positive Review Stats') }}
                                        </div>
                                        <div class="col row">
                                            <div class="col-md-6">
                                                <label for="positive_review_count" class="col-sm-3 col-label">{{ __('Count') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="positive_review_count" class="box-input"
                                                        placeholder="200+"
                                                        value="{{ $data->positive_review_count }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="positive_review_text" class="col-sm-3 col-label">{{ __('Text') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="positive_review_text" class="box-input"
                                                        placeholder="Positive Review"
                                                        value="{{ $data->positive_review_text }}">
                                                </div>
                                            </div>
                                            @if ($key == 'en')
                                                <div class="col-12">
                                                    <label for="positive_review_icon" class="col-sm-3 col-label">{{ __('Icon') }}</label>
                                                    <div class="wrap-custom-file">
                                                        <input type="file" name="positive_review_icon" id="positiveReviewIcon" accept=".gif, .jpg, .png, .svg" />
                                                        <label for="positiveReviewIcon" class="file-ok"
                                                            style="background-image: url( {{ asset($data->positive_review_icon) }} )">
                                                            <img class="upload-icon"
                                                                src="{{ asset('global/materials/upload.svg') }}"
                                                                alt="" />
                                                            <span>{{ __('Update Icon') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
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
@section('script')
    @include('backend.page.section.include.__section_image_remove')
@endsection