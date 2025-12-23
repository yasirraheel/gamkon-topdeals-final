<div class="chat-list">
    @forelse ($allChats as $chat)
        @php
            $otherUser = $chat->role == 'sender' ? $chat->receiver : $chat->sender;
        @endphp

        <a href="{{ buyerSellerRoute('chat.index', $otherUser?->username) }}"
            class="chat
               @if ($chat->receiver_id == auth()->id() && !$chat->seen) unread @endif">
            <div class="left">
                <div class="user">
                    <img src="{{ $otherUser?->avatar_path }}" alt="USER IMAGE">
                </div>
                <div class="texts">
                    <h6>{{ $otherUser?->full_name ?? 'Deleted User' }}</h6>
                    <p class="{{ $chat->seen ? 'has-seen' : '' }}">
                        <span class="truncateText">{{ Str::limit($chat->message, 25) }}</span>
                    </p>
                </div>
            </div>
            <div class="right">
                <p>{{ \Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</p>
            </div>
        </a>
    @empty
        <div class="text-center my-4">
            {{ __('No Chat Found!') }}</div>
    @endforelse
</div>
