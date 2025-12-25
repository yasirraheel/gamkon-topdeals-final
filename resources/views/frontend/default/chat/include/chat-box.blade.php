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
                <h5>
                    {{ $chat->role == 'sender' ? $chat->receiver?->full_name ?? 'Deleted User' : $chat->sender?->full_name ?? 'Deleted User' }}
                    @php
                        $chatUser = $chat->role == 'sender' ? $chat->receiver : $chat->sender;
                    @endphp
                    @if($chatUser && $chatUser->kyc == 1)
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#3b82f6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-left: 2px;" title="{{ __('Verified Seller') }}" data-bs-toggle="tooltip">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.78 4.78 4 4 0 0 1-6.74 0 4 4 0 0 1-4.78-4.78 4 4 0 0 1 0-6.74z"></path>
                            <polyline points="9 11 12 14 22 4"></polyline>
                        </svg>
                    @endif
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
