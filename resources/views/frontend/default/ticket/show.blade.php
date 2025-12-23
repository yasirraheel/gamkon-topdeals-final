@extends('frontend::layouts.user')
@section('title')
    {{ __('View Ticket') }}
@endsection
@push('css')
    <style>
        .message .contents-inner {
            width: 100%;
        }

        .text-white {
            color: white;
        }
    </style>
@endpush
@section('supportTicket', 'active')
@section('content')
    <div class="support-chat-box">
        <div class="user-name user-name-2">
            <p>{{ __('Support Ticket ID: :id', ['id' => $ticket->uuid]) }}</p>
            @if ($ticket->isOpen())
                <a href="{{ route('user.ticket.close.now', $ticket->uuid) }}"
                    class="primary-button">{{ __('Close Ticket') }}</a>
            @endif
        </div>
        <div class="chat-body chat-body-2">

            <div class="message user-message">
                <div class="avatar-thumb">
                    <div class="user-info">
                        <h4>{{ $user->full_name }}</h4>
                        <p>{{ '@' . $user->username }}</p>
                    </div>
                    <div class="img">
                        <img src="{{ asset($user->avatar_path ?? 'global/materials/user.png') }}" alt="User Avatar">

                    </div>
                </div>
                <div class="contents-inner">
                    <div class="contents">
                        <p>{{ $ticket->message }}</p>
                        @php
                            $attachments = $ticket->attachments;
                        @endphp

                        @if (is_array($attachments) && count($attachments) > 0)
                            <div class="message-attachments">
                                <div class="title">{{ __('Attachments') }}</div>
                                <div class="single-attachment">
                                    @foreach ($attachments as $attachment)
                                        <div class="attach">
                                            <a href="{{ asset($attachment) }}" target="_blank">
                                                <i data-lucide="file"></i> {{ substr($attachment, 14) }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @foreach ($ticket->messages as $message)
                <div class="message {{ $message->model == 'user' ? 'user-message' : 'reply-message' }}">
                    <div class="avatar-thumb">
                        @if ($message->model != 'user')
                            <div class="img">
                                <img src="{{ asset($message->user->avatar ?? 'global/materials/admin.png') }}"
                                    alt="Admin Avatar">
                            </div>
                        @endif
                        <div class="user-info">
                            @if ($message->model == 'user')
                                <h4>{{ $user->full_name }}</h4>
                                <p>{{ '@' . $user->username }}</p>
                            @else
                                <h4>{{ $message->user->name }}</h4>
                            @endif
                        </div>
                        @if ($message->model == 'user')
                            <div class="img">
                                <img src="{{ asset($user->avatar_path ?? 'global/materials/user.png') }}"
                                    alt="User Avatar">
                            </div>
                        @endif
                    </div>
                    <div class="contents-inner">
                        <div class="contents">
                            <p>{{ $message->message }}</p>
                            @php
                                $attachments = json_decode($message->attachments);
                            @endphp

                            @if (is_array($attachments) && count($attachments) > 0)
                                <div class="has-attachment">
                                    <h6 class="title">Attachments</h6>
                                    @foreach ($attachments as $attachment)
                                        <div class="attachment-box">
                                            <div class="icon">
                                                <iconify-icon icon="lucide:file" class="file-icon"></iconify-icon>
                                            </div>
                                            <a href="{{ asset($attachment) }}" target="_blank">
                                                <i data-lucide="file"></i> {{ substr($attachment, 14) }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="td-chat-footer mt-20">
            <form action="{{ buyerSellerRoute('ticket.reply', $ticket->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="uuid" value="{{ $ticket->uuid }}">

                <input type="file" id="fileInput" class="file-input" name="attachments[]" multiple hidden>
                <div class="preview-file-box hidden">
                </div>

                <div class="message-box">
                    <div class="td-form-group td-form-group-message">
                        <label for="fileInput" type="button" class="file-input">
                            <iconify-icon icon="lucide:paperclip" class="file-clip"></iconify-icon>
                        </label>
                        <div class="input-field">
                            <input class="form-control" name="message" value="{{ old('message') }}" type="text"
                                placeholder="Type a message...">
                        </div>
                        <button class="send-button">
                            <iconify-icon icon="lucide:send" class="send-icon"></iconify-icon>
                            {{ __('Send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @push('js')
        <script>
            'use strict';
            $(document).ready(function() {

                $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);

                $(document).ready(function() {
                    $(".file-input").on("click", function() {
                        $("#fileInput").click();
                    });

                    $("#fileInput").on("change", function(event) {
                        let files = event.target.files;

                        $(".preview-file-box").show();

                        $.each(files, function(index, file) {
                            let reader = new FileReader();

                            reader.onload = function(e) {
                                let filePreview;

                                if (file.type.startsWith("image/")) {
                                    filePreview = `<div class="preview-file">
                                                        <div class="img-or-file-preview">
                                                            <img src="${e.target.result}" alt="${file.name}">
                                                        </div>
                                                        <p class="file-name">${file.name}</p>
                                                        <button class="remove-item">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 22 22" fill="none">
                                                                                                <path d="M14 8L8 14L14 8ZM8 8L14 14L8 8ZM21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" fill="#FF5353" fill-opacity="0.3"/>
                                                                                                <path d="M14 8L8 14M8 8L14 14M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#FF5353" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                            </svg>
                                                        </button>
                                                    </div>`;
                                } else {
                                    filePreview = `<div class="preview-file">
                                                        <div class="img-or-file-preview">
                                                            <i class="fa-solid fa-file file-icon"></i>
                                                        </div>
                                                        <p class="file-name">${file.name}</p>
                                                        <button class="remove-item">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 22 22" fill="none">
                                                                                                <path d="M14 8L8 14L14 8ZM8 8L14 14L8 8ZM21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" fill="#FF5353" fill-opacity="0.3"/>
                                                                                                <path d="M14 8L8 14M8 8L14 14M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#FF5353" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                            </svg>
                                                            </button>
                                                    </div>`;
                                }
                                $(".preview-file-box").append(filePreview);
                            };

                            reader.readAsDataURL(file);
                        });
                    });

                    $(document).on("click", ".remove-item", function() {
                        $(this).closest(".preview-file").remove();

                        if ($(".preview-file-box").children().length === 0) {
                            $(".preview-file-box").hide();
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
