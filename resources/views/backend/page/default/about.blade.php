@extends('backend.layouts.app')
@section('title')
    {{ __('About Us') }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/css/choices.min.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('About Us Page') }}</h2>
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

                <div class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}" id="{{$key}}" role="tabpanel" aria-labelledby="pills-informations-tab">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Contents') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="page_code" value="about">
                                <input type="hidden" name="page_locale" value="{{$key}}">
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Page Title') }}<i data-lucide="info"
                                                                                                      data-bs-toggle="tooltip"
                                                                                                      title=""
                                                                                                      data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" value="{{ $data->title }}">
                                    </div>
                                </div>

                                @if($key == 'en')
         
                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('About Us Right-Top Image') }}
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="right_top_img" id="aboutusRightTopImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="aboutusRightTopImg" class="file-ok"
                                                   style="background-image: url( {{ asset( $data->right_top_img ) }} )">
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('About Us Right-Middle Image') }}
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="right_middle_img" id="aboutusRightMiddleImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="aboutusRightMiddleImg" class="file-ok"
                                                   style="background-image: url( {{ asset( $data->right_middle_img ) }} )">
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('About Us Right-Bottom Image') }}
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="right_bottom_img" id="aboutusRightBottomImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="aboutusRightBottomImg" class="file-ok"
                                                   style="background-image: url( {{ asset( $data->right_bottom_img ) }} )">
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('About Us Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Don't need this title? Leave it blank"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title_small" class="box-input"
                                               value="{{ $data->title_small }}">
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="total_Seller" class="col-sm-3 col-label">{{ __('Right Middle Image data') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="right_image_level" class="box-input" placeholder="50+" value="{{ $data->right_image_level }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="total_Seller" class="col-sm-3 col-label">{{ __('Right Middle Image Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="right_image_title" class="box-input" placeholder="Seller" value="{{ $data->right_image_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="total_seller_description" class="col-sm-3 col-label">{{ __('Right Middle Image Description') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="total_seller_description" class="box-input" placeholder="Scrambled it to make a type specimen book. It has only five centuries" value="{{ $data->total_seller_description }}">
                                    </div>
                                </div>
                                
                                <div class="site-input-groups row">
                                    <label for="left_title" class="col-sm-3 col-label">{{ __('Left Section title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="left_title" class="box-input" placeholder="A Legacy of Excellence in Game Solutionsons" value="{{ $data->left_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="left_description" class="col-sm-3 col-label">{{ __('Left Section Description') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="left_description" class="box-input" placeholder="when an unknown printer took a galley of type and scrambled it to make a type specimen book">{{ $data->left_description }}</textarea>
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('About Us Button') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Button Label') }}</label>
                                                    <input type="text" name="about_us_button_level" class="box-input"
                                                           value="{{ $data->about_us_button_level }}">
                                                </div>
                                            </div>
                                            @if($key == 'en')
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Button URL') }}</label>
                                                        <div class="site-input-groups">
                                                            <div class="site-input-groups">
                                                                <input type="text" name="about_us_button_url" class="box-input"
                                                                       value="{{ $data->about_us_button_url }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Target') }}</label>
                                                        <div class="site-input-groups">
                                                            <select name="about_us_button_target" class="form-select">
                                                                <option @if($data->about_us_button_target == '_self') selected
                                                                        @endif value="_self">{{ __('Same Tab') }}</option>
                                                                <option @if($data->about_us_button_target == '_blank') selected
                                                                        @endif value="_blank">{{ __('Open In New Tab') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('About Us Content') }}</label>
                                    <div class="col-sm-9">
                                    <textarea name="content" class="form-textarea summernote"
                                          placeholder="Content">{!! $data->content !!}</textarea>
                                    </div>
                                </div>

                                @if($key == 'en')
                                <div class="site-input-groups row mb-0">
                                    <label for="" class="col-sm-3 col-label">{{ __('Content Come From') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="The Contents will come from a Section"></i></label>
                                    <div class="col-sm-9">
                                        <div class="site-input-groups">
                                            <div class="site-input-groups">
                                                <select name="section_id[]" id="section_id" class="form-select" multiple>
                                                    <option value="" disabled>{{ __('--Select Section if Need--') }}</option>
                                                    @foreach($landingSections as $section)
                                                        <option @selected(is_array(json_decode($data->section_id)) && in_array($section->id,json_decode($data->section_id))) value="{{ $section->id }}">{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-4">
                                    <label for="" class="col-sm-3 col-label"></label>
                                    <div class="col-sm-9">
                                        <hr>
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Keywords') }}<i data-lucide="info"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title=""
                                                                                                        data-bs-original-title="Page Seo Keywords"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="meta_keywords" class="box-input"
                                               value="{{ $data->meta_keywords }}">
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Description') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Page Seo Description"></i></label>
                                    <div class="col-sm-9">
                                        <textarea name="meta_description" cols="30" rows="5" class="form-textarea">{{ $data->meta_description }}</textarea>
                                    </div>
                                </div>
                                @if($key == 'en')
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label pt-0">{{ __('Page Status') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Manage Page Visibility"></i></label>
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

    <script src="{{ asset('backend/js/choices.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            "use strict";

            new Choices('#section_id', {
                removeItems: true,
                removeItemButton: true,
                shouldSort: false
            });
        })
    </script>
@endsection
