<div class="td-referral-tree-card {{ $me ? 'tree-parent' : '' }}">
    <div class="thumb">
        <img src="{{ $levelUser->avatar_path }}" alt="{{ $levelUser->full_name }}">
    </div>
    <div class="content">
        <h6 class="title">
            @if ($me)
                {{ __("It's Me") }} ({{ $levelUser->full_name }})
            @else
                {{ $levelUser->full_name }}
            @endif
        </h6>
        <p class="info">
            {{ __('Sold') }} {{ $currencySymbol . $levelUser->total_amount_sold }}, {{ __('Purchased') }}
            {{ $currencySymbol . $levelUser->total_amount_purchased }}
        </p>
    </div>
</div>

@if ($depth && $level >= $depth && $levelUser->referrals->count() > 0)
    <ul>
        @foreach ($levelUser->referrals as $childUser)
            <li>
                @include('frontend::referral.include.__tree', [
                    'levelUser' => $childUser,
                    'level' => $level,
                    'depth' => $depth + 1,
                    'me' => false,
                ])
            </li>
        @endforeach
    </ul>
@endif
