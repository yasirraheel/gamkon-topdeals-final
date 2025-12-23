@extends('frontend::layouts.user')
@section('title')
    {{ $kyc->name }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
    <style>
        .flatpickr-wrapper {
            width: 100% !important;
        }

        .has-verified-box label {
            display: flex;
        }
    </style>
@endpush
@section('sellerKycSection', 'active')
@section('content')
    <div class="transactions-history-box">
        <x-luminous.dashboard-breadcrumb title="{{ __('ID Verification: :name', ['name' => $kyc->name]) }}" />

        <div class="add-forms">
            <form action="{{ buyerSellerRoute('kyc.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kyc_id" value="{{ encrypt($kyc->id) }}">

                <div class="row gy-3 gy-sm-4">
                    @foreach (json_decode($kyc->fields, true) as $key => $field)
                        <div class="col-12">
                            @if ($field['type'] == 'file')
                                <div class="common-upload-image-system">
                                    <div class="title">
                                        <div class="left">
                                            <p>{{ $field['name'] }}@if ($field['validation'] == 'required')
                                                    <sup>*</sup>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="upload-container">
                                        <div class="upload-thumb">
                                            <div class="upload-thumb-inner">
                                                <input type="file" class="file-upload-input"
                                                    name="kyc_credential[{{ $field['name'] }}]"
                                                    id="fileInput{{ $key }}" multiple="" hidden="">
                                                <div class="upload-thumb-img">
                                                    <!-- Preview images will appear here -->
                                                </div>
                                                <div class="upload-thumb-content">
                                                    <h4><a href="#" class="attach-file">{{ __('Attach File') }}</a>
                                                        {{ __('Or Drag & Drop') }}</h4>
                                                    <p>{{ __('JPEG/PNG/PDF/Docs file') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($field['type'] == 'textarea')
                                <div class="td-form-group">
                                    <label class="input-label">{{ $field['name'] }}
                                        @if ($field['validation'] == 'required')
                                            <span>*</span>
                                        @endif
                                    </label>
                                    <div class="input-field">
                                        <textarea name="kyc_credential[{{ $field['name'] }}]" @if ($field['validation'] == 'required') required @endif></textarea>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            @elseif($field['type'] == 'date')
                                <div class="td-form-group birth-date-picker common-flatpicker-design">
                                    <label class="input-label">{{ $field['name'] }}
                                        @if ($field['validation'] == 'required')
                                            <span>*</span>
                                        @endif
                                    </label>
                                    <div class="input-field">
                                        <input type="text" class="form-control flatpickr-input"
                                            name="kyc_credential[{{ $field['name'] }}]"
                                            @if ($field['validation'] == 'required') required @endif>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            @elseif($field['type'] == 'select')
                                <div class="td-form-group">
                                    <label class="input-label">{{ $field['name'] }}
                                        @if ($field['validation'] == 'required')
                                            <span>*</span>
                                        @endif
                                    </label>
                                    <div class="auth-nice-select auth-nice-select-2">
                                        <select class="nice-select-active" name="kyc_credential[{{ $field['name'] }}]"
                                            @if ($field['validation'] == 'required') required @endif>
                                            @foreach ($field['options'] ?? [] as $option)
                                                <option value="{{ $option['value'] }}"
                                                    {{ $option['selected'] ? 'selected' : '' }}>
                                                    {{ $option['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            @else
                                <div class="td-form-group">
                                    <label class="input-label">{{ $field['name'] }}
                                        @if ($field['validation'] == 'required')
                                            <span>*</span>
                                        @endif
                                    </label>
                                    <div class="input-field">
                                        <input type="text" class="form-control"
                                            name="kyc_credential[{{ $field['name'] }}]"
                                            @if ($field['validation'] == 'required') required @endif>
                                    </div>
                                    <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="col-12">
                        <div class="account-form-submit-button">
                            <button type="submit" class="primary-button xl-btn">{{ __('Submit Now') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('frontend/default/js/flatpickr.js') }}"></script>

    <script>
        "use strict";

        function showCloseButton(event) {
            const button = event.target.parentElement.nextElementSibling;
            button.style.display = 'block';
        }
        $(".flatpickr-input").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: false,
            defaultDate: null,
            position: "below",
            static: true
        });

        $(document).ready(function() {
            // Initialize all upload thumbs
            $('.upload-thumb').each(function() {
                initUploadThumb($(this));
            });

            function initUploadThumb($thumb) {
                const $input = $thumb.find('.file-upload-input');
                const $thumbImg = $thumb.find('.upload-thumb-img');
                const $thumbContent = $thumb.find('.upload-thumb-content');
                const $attachFile = $thumb.find('.attach-file');

                // Click handler for attach file link
                $attachFile.on('click', function(e) {
                    e.preventDefault();
                    $input.click();
                });

                // Click handler for the whole thumb area
                $thumb.on('click', function(e) {
                    // Don't trigger if click originated from delete button or its children
                    if ($(e.target).closest('.delete-btn').length) {
                        return;
                    }

                    if ($(e.target).is('.upload-thumb') ||
                        $(e.target).is('.upload-thumb-content') ||
                        $(e.target).is('.upload-thumb-content *:not(.attach-file)')) {
                        $input.click();
                    }
                });

                // File input change handler
                $input.on('change', function(e) {
                    const files = e.target.files;
                    if (files.length > 0) {
                        processFiles(files, $thumbImg, $thumbContent, $input);
                    }
                });

                // Drag and drop handlers
                $thumb.on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'var(--td-secondary)');
                });

                $thumb.on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');
                });

                $thumb.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');

                    const files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        $input[0].files = files;
                        $input.trigger('change');
                    }
                });
            }

            // Process uploaded files
            function processFiles(files, $uploadThumbImg, $uploadThumbContent, $input) {
                // Clear previous files if you want to replace them
                $uploadThumbImg.empty();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const imageBox = $('<div class="image-box"></div>');

                    // Create delete button
                    const deleteBtn = $('<span class="delete-btn">×</span>')
                        .css({
                            'position': 'absolute',
                            'top': '5px',
                            'right': '5px',
                            'width': '20px',
                            'height': '20px',
                            'background': 'rgba(0,0,0,0.5)',
                            'color': 'white',
                            'border-radius': '50%',
                            'display': 'flex',
                            'align-items': 'center',
                            'justify-content': 'center',
                            'cursor': 'pointer',
                            'font-size': '14px',
                            'z-index': '10'
                        })
                        .on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            $(this).parent().remove();
                            checkEmptyState($uploadThumbImg, $uploadThumbContent, $input);
                        });

                    imageBox.append(deleteBtn);

                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>').attr('src', e.target.result);
                            imageBox.append(img);
                            $uploadThumbImg.append(imageBox);
                            updateUploadState($uploadThumbImg, $uploadThumbContent);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const fileInfo = $('<div></div>')
                            .text(file.name)
                            .css({
                                'width': '100%',
                                'height': '100%',
                                'display': 'flex',
                                'align-items': 'center',
                                'justify-content': 'center',
                                'padding': '10px',
                                'word-break': 'break-all'
                            });
                        imageBox.append(fileInfo);
                        $uploadThumbImg.append(imageBox);
                        updateUploadState($uploadThumbImg, $uploadThumbContent);
                    }
                }
            }

            function updateUploadState($uploadThumbImg, $uploadThumbContent) {
                $uploadThumbImg.addClass('has-img');
                $uploadThumbContent.addClass('has-img');
            }

            function checkEmptyState($uploadThumbImg, $uploadThumbContent, $input) {
                if ($uploadThumbImg.children().length === 0) {
                    $uploadThumbImg.removeClass('has-img');
                    $uploadThumbContent.removeClass('has-img');
                    $input.val('');
                }
            }
        });
    </script>
@endpush
