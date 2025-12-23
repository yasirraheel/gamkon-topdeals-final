<div class="title">
    <h4>{{ __('Recent Chat') }}</h4>
</div>
<div class="recent-chat">
    @forelse ($allChats as $chat)
        @php
            $chatMatchId = $chat->role == 'sender' ? $chat->receiver_id : $chat->sender_id;
        @endphp
        <a href="{{ buyerSellerRoute('chat.index', $chat->role == 'sender' ? $chat->receiver?->username : $chat->sender?->username) }}"
            class="chat @if ($chatMatchId == $receiver?->id) active @endif">
            <div class="left">
                <div class="user-img">
                    <img src="{{ $chat->role == 'sender' ? $chat->receiver?->avatar_path : $chat->sender?->avatar_path }}"
                        alt="User Image">
                </div>
            </div>
            <div class="right">
                <h5>{{ $chat->role == 'sender' ? $chat->receiver?->full_name ?? 'Deleted User' : $chat->sender?->full_name ?? 'Deleted User' }}
                </h5>
                <p class="truncateMessageText {{ $chat->seen ? 'has-seen' : '' }}">
                    <span class="check-icon">
                        <img src="{{ themeAsset('/images/chat/check.svg') }}" alt="Check Icon">
                    </span>
                    {{ Str::limit($chat->message, 30) }}
                </p>
                <p class="time">{{ $chat->chat_time }}</p>
            </div>
        </a>
    @empty
        <x-luminous.no-data-found type="chat" />
    @endforelse
</div>
