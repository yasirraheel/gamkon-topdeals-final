@extends('frontend::layouts.user')
@section('title')
    Chat
@endsection
@push('css')
    <style>
        .avatar-thumb img {
            height: 100%;
        }
    </style>
@endpush
@section('content')
    <div class="chatting-system">
        <button class="open-recent-chat">{{ __('Open Recent Chat') }}</button>
        <div class="row g-4">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="support-chat-box">
                    @if ($receiver)
                        <div class="user-name">
                            <p><a target="_blank"
                                    href="{{ route('seller.details', $receiver->username) }}">{{ $receiver->full_name }}</a>
                            </p>
                        </div>
                    @endif
                    <div class="chat-body chat-body-2">
                        @foreach ($currentChat as $chat)
                            <div class="message {{ $chat->sender_id == $authUser ? 'user-message' : 'reply-message' }}">
                                <div class="avatar-thumb">
                                    <div class="user-info">
                                        <h4>{{ $chat->sender->full_name }}</h4>
                                        <p>{{ '@' . $chat->sender->username }}</p>
                                    </div>
                                    <div class="img">
                                        <img src="{{ $chat->sender->avatar_path }}" alt="{{ $chat->sender->full_name }}">
                                    </div>
                                </div>
                                <div class="contents-inner">
                                    <div class="contents">
                                        <p>{{ $chat->message }}</p>
                                        @if ($chat->attachments->count())
                                            <div class="has-attachment">
                                                <h6>{{ __('Attachments') }}</h6>
                                                @foreach ($chat->attachments as $file)
                                                    <div class="attachment-box">
                                                        <div class="icon">
                                                            <iconify-icon icon="lucide:file"
                                                                class="file-icon"></iconify-icon>
                                                        </div>
                                                        <a href="{{ asset($file->path) }}"
                                                            target="_blank">{{ basename($file->path) }}</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="td-chat-footer">
                        @if ($receiver)
                            <form action="{{ buyerSellerRoute('chat.store', $receiver?->username) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" accept="image/*" name="attachments[]" id="fileInput" multiple hidden>
                                <div class="preview-file-box hidden"></div>
                                <div class="message-box">
                                    <div class="td-form-group td-form-group-message">
                                        <button type="button" class="file-input"
                                            onclick="document.getElementById('fileInput').click()">
                                            <iconify-icon icon="lucide:paperclip" class="file-clip"></iconify-icon>
                                        </button>
                                        <div class="input-field">
                                            <input class="form-control" type="text"
                                                placeholder="{{ __('Type a message...') }}" name="message" required>
                                        </div>
                                        <button class="send-button" type="submit">
                                            <iconify-icon icon="lucide:send" class="send-icon"></iconify-icon>
                                            {{ __('send') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center">
                                {{ __('Select a user to start chat') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                @include('frontend::chat.include.recent-chat')
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';

        $(".chat-body").animate({
            scrollTop: $('.chat-body').height()
        }, 500);
        $(document).ready(function() {


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

            $(".open-chat").on("click", function() {
                const $chatLists = $(".mobile-chat-lists");

                if ($chatLists.hasClass("open")) {
                    $chatLists.removeClass("open");
                } else {
                    $chatLists.addClass("open");
                }
            });

            $(".mobile-chat-lists").on("click", function(e) {
                if (e.target === this) {
                    $(this).removeClass("open");
                }
            });
        });
    </script>
@endpush
