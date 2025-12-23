@php use App\Enums\TxnStatus; @endphp
@extends('frontend::layouts.user', ['mainClass' => '-2'])
@section('title')
    {{ __('Transactions') }}
@endsection
@push('style')
    <link rel="stylesheet" href="{{ themeAsset('css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ themeAsset('css/flat-picker-color-select.css') }}">

    <style>
        .file-upload-wrap {
            width: 100%;
        }

        .select2-selection__rendered {
            color: rgba(48, 48, 48, 0.80) !important;
        }
    </style>
@endpush
@section('content')
    <div class="transactions-history-box">
        <x-luminous.dashboard-breadcrumb title="{{ __('Ticket List') }}">
            <form method="GET" id="filterForm" class="w-100">
                <div class="table-sort table-sort-2">
                    <div class="left">
                        <div class="input-search">
                            <input name="subject" type="text" value="{{ request('subject') }}"
                                placeholder="Search by UUID Or Title">
                        </div>
                        <div class="calender">
                            <div class="custom-range-calender">
                                <input name="daterange" type="text" class="form-control flatpickr-input"
                                    placeholder="Date Posted" value="{{ request('daterange') }}" id="flatpickr-range"
                                    readonly="readonly">
                            </div>
                        </div>
                        <div class="action-btn">
                            <button class="primary-button">{{ __('Search') }}</button>
                        </div>
                    </div>
                    <div class="right">
                        <a href="javascript:void(0)"
                            class="primary-button common-modal-button">{{ __('Create Ticket') }}</a>
                    </div>
                </div>
            </form>
        </x-luminous.dashboard-breadcrumb>
        <div class="">
            <div class="common-table">
                <div class="common-table-full">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class=" text-nowrap">{{ __('Ticket') }}</th>
                                <th scope="col" class=" text-nowrap">{{ __('Precedence') }}</th>
                                <th scope="col" class=" text-nowrap">{{ __('Last Open') }}</th>
                                <th scope="col" class=" text-nowrap">{{ __('Status') }}</th>
                                <th scope="col" class=" text-nowrap">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <th>
                                        <div class="payment-name-and-date">
                                            <div class="name">
                                                <a href="{{ buyerSellerRoute('ticket.show', $ticket->uuid) }}">
                                                    [{{ __('Ticket') }} - {{ $ticket->uuid }}] {{ $ticket->title }}
                                                </a>
                                            </div>
                                            <div class="date">{{ $ticket->created_at }}</div>
                                        </div>
                                    </th>
                                    <td class=" text-nowrap">
                                        <div
                                            class="badge 
                                    {{ $ticket->priority == 'low' ? 'pending' : ($ticket->priority == 'high' ? 'delivered' : 'pending') }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </div>
                                    </td>
                                    <td class=" text-nowrap">
                                        {{ $ticket->messages->last()?->created_at->diffForHumans() ?? '--' }}
                                    </td>
                                    <td class=" text-nowrap">
                                        <span
                                            class="badge 
                                    {{ $ticket->isOpen() ? 'success' : ($ticket->isClosed() ? 'primary' : 'pending') }}">
                                            {{ $ticket->isOpen() ? __('Opened') : __('Closed') }}
                                        </span>
                                    </td>
                                    <td class=" text-nowrap">
                                        <div class="tooltip-action-btns">
                                            <a href="{{ buyerSellerRoute('ticket.show', $ticket->uuid) }}"
                                                class="tooltip-btn view-btn">
                                                <iconify-icon icon="lucide:eye" class="tooltip-icon"></iconify-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($tickets) == 0)
                                <tr>
                                    <td colspan="6" class="">
                                        <x-luminous.no-data-found type="Ticket" />
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-pagination">
                    <div class="pagination">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create Tricke start-->
    <div class="common-modal-full" id="createTicket" aria-labelledby="createTicketModalLabel" aria-hidden="true">
        <div class="common-modal-box">
            <div class="content">
                <div class="add-new-withdrawal">
                    <h4>{{ __('Create a New Ticket') }}</h4>
                    <div class="add-forms">
                        <form action="{{ buyerSellerRoute('ticket.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Subject') }} <span>*</span></label>
                                        <div class="input-field">
                                            <input type="text" class="form-control" id="subject" name="title"
                                                required>
                                        </div>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="td-form-group common-image-select2">
                                        <label class="input-label" for="priority">{{ __('Precedence') }}
                                            <span>*</span></label>
                                        <select class="" id="simpleSelect1" name="priority" required>
                                            <option value="" selected disabled>{{ __('Select precedence') }}</option>
                                            <option value="low">{{ __('Low') }}</option>
                                            <option value="medium">{{ __('Medium') }}</option>
                                            <option value="high">{{ __('High') }}</option>
                                        </select>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="td-form-group">
                                        <label class="input-label">{{ __('Message') }} <span>*</span></label>
                                        <div class="input-field input-field-textarea2">
                                            <textarea id="message" name="message" required></textarea>
                                        </div>
                                        <p class="feedback-invalid">{{ __('This field is required') }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="common-upload-image-system">
                                        <div class="title">
                                            <div class="left">
                                                <p>{{ __('Upload Image') }}</p>
                                            </div>
                                        </div>
                                        <div class="upload-thumb">
                                            <div class="upload-thumb-inner">
                                                <input type="file" class="file-upload-input" id="fileInput"
                                                    name="attachments[]" multiple
                                                    accept=".gif, .jpg, .png, .pdf, .doc, .docx" hidden>
                                                <div class="upload-thumb-img" id="previewContainer">
                                                </div>
                                                <div class="upload-thumb-content">
                                                    <h4><a href="#" class="attach-file"
                                                            onclick="document.getElementById('fileInput').click(); return false;">{{ __('Attach File') }}</a>
                                                        {{ __('Or Drag & Drop') }}</h4>
                                                    <p>{{ __('JPEG/PNG/PDF/Docs file') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="modal-action-btn">
                                        <button type="submit" class="primary-button">{{ __('Create') }}</button>
                                        <button type="button" class="close withdraw-close"
                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal create Tricke end-->
@endsection
@push('js')
    <script src="{{ themeAsset('js/moment.min.js') }}"></script>
    <script src="{{ themeAsset('js/flatpickr.js') }}"></script>
    <script src="{{ themeAsset('js/flatpicker-activation.js') }}"></script>
    <script>
        'use strict';
        @if (request('daterange') == null)
            // Set default is empty for date range
            $('input[name=daterange]').val('');
        @endif

        $(document).ready(function() {
            $('.attach-file').on('click', function(e) {
                e.preventDefault();
                $('#fileInput').click();
            });

            $('.upload-thumb').on('click', function(e) {
                if ($(e.target).is('.upload-thumb') ||
                    $(e.target).is('.upload-thumb-content') ||
                    $(e.target).is('.upload-thumb-content *:not(.attach-file)')) {
                    $('#fileInput').click();
                }
            });

            // Handle file selection
            $('#fileInput').on('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    processFiles(files);
                }
            });

            // Drag and drop functionality
            $('.upload-thumb').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css('border-color', 'var(--td-secondary)');
            });

            $('.upload-thumb').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');
            });

            $('.upload-thumb').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css('border-color', 'rgba(48, 48, 48, 0.30)');

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $('#fileInput')[0].files = files;
                    $('#fileInput').trigger('change');
                }
            });

            // Function to process uploaded files
            function processFiles(files) {
                const $uploadThumbImg = $('.upload-thumb-img');
                const $uploadThumbContent = $('.upload-thumb-content');

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
                            e.stopPropagation();
                            $(this).parent().remove();
                            checkEmptyState();
                        });

                    imageBox.append(deleteBtn);

                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>').attr('src', e.target.result);
                            imageBox.append(img);
                            $uploadThumbImg.append(imageBox);
                            updateUploadState();
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
                        updateUploadState();
                    }
                }
            }

            function updateUploadState() {
                const $uploadThumbImg = $('.upload-thumb-img');
                const $uploadThumbContent = $('.upload-thumb-content');
                $uploadThumbImg.addClass('has-img');
                $uploadThumbContent.addClass('has-img');
            }

            function checkEmptyState() {
                const $uploadThumbImg = $('.upload-thumb-img');
                const $uploadThumbContent = $('.upload-thumb-content');

                if ($uploadThumbImg.children().length === 0) {
                    $uploadThumbImg.removeClass('has-img');
                    $uploadThumbContent.removeClass('has-img');
                    $('#fileInput').val('');
                }
            }
        });

        @if (request('daterange') == null)
            // Set default is empty for date range
            $('input[name=daterange]').val('');
        @endif
    </script>
@endpush
