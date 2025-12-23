@extends('backend.layouts.app')
@section('title')
    {{ __('What You Can Sell') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('What You Can Sell Page') }}</h2>
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
                                    <input type="hidden" name="page_code" value="what-i-can-do">
                                    <input type="hidden" name="page_locale" value="{{ $key }}">
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Title') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Page Title will show in title"></i></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="box-input"
                                                value="{{ $data->title }}">
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label">{{ __('Description') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Page description will be shown after category dropdown"></i></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="category_text" class="box-input"
                                                value="{{ $data->category_text }}">
                                        </div>
                                    </div>
                                    @if ($key == 'en')
                                        <div class="site-input-groups row">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                                {{ __('Right Image') }} <small>({{ __('626x626') }})</small>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                                <div class="wrap-custom-file">
                                                    <input type="file" name="right_image" id="heroRightTopImg"
                                                        accept=".gif, .jpg, .png" />
                                                    <label for="heroRightTopImg" id="right_image"
                                                        @if ($data->right_image) class="file-ok"
                                                   style="background-image: url({{ asset($data->right_image) }})" @endif>
                                                        <img class="upload-icon"
                                                            src="{{ asset('global/materials/upload.svg') }}"
                                                            alt="" />
                                                        <span>{{ __('Update Image') }}</span>
                                                    </label>
                                                    @removeimg($data->right_image, right_image)
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
                                        <label for="" class="col-sm-3 col-label">{{ __('Seo Keywords') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
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
                @php
                    $landingContent = App\Models\LandingContent::where('type', 'what-i-can-do')
                        ->where('locale', 'en')
                        ->get();
                @endphp
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="title">{{ __('What I Can Do Section Contents') }}</h3>
                        <div class="card-header-links">
                            <a href="" class="card-header-link" type="button" data-bs-toggle="modal"
                                data-bs-target="#addNew">{{ __('Add New') }}</a>
                        </div>
                    </div>
                    <div class="site-card-body">
                        <div class="site-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($landingContent as $content)
                                        <tr>
                                            <td>
                                                {{ $content->title }}
                                            </td>
                                            <td>{{ $content->description }}</td>
                                            <td>
                                                <button class="round-icon-btn primary-btn editContent" type="button"
                                                    data-id="{{ $content->id }}">
                                                    <i data-lucide="edit-3"></i>
                                                </button>
                                                <button class="round-icon-btn red-btn deleteContent" type="button"
                                                    data-id="{{ $content->id }}">
                                                    <i data-lucide="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Modal for Add New  -->
    @include('backend.page.' . site_theme() . '.section.include.__add_new_content')
    <!-- Modal for Add New How It Works End -->

    <!-- Modal for Edit -->
    @include('backend.page.' . site_theme() . '.section.include.__edit_faq')
    <!-- Modal for Edit  End-->

    <!-- Modal for Delete  -->
    @include('backend.page.' . site_theme() . '.section.include.__delete_faq')
    <!-- Modal for Delete  End-->
@endsection
@section('script')
    @include('backend.page.section.include.__section_image_remove')
    <script>
        "use strict";

        $('.editContent').on('click', function(e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');

            var url = '{{ route('admin.page.content-edit', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Handle the response HTML
                    $('#target-element').html(response.html);
                    $('#editContent').modal('show');
                },
                error: function(xhr) {
                    // Handle any errors that occurred during the request
                    console.log(xhr.responseText);
                }
            });
        });

        $('.deleteContent').on('click', function(e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteId').val(id);
            $('#deleteContent').modal('show');
        });
    </script>
@endsection
