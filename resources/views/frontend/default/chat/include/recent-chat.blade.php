<div class="recent-chat-box d-none d-lg-block">
    @include('frontend::chat.include.chat-box')
</div>

{{-- for mobile --}}

<div class="recent-chat-mobile">
    <button class="close">{{ __('x') }}</button>
    <div class="recent-chat-box d-lg-none d-block">
        @include('frontend::chat.include.chat-box')
    </div>
</div>
