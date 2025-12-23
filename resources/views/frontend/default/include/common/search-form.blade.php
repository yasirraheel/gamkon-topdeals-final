<form class=" {{ $searchFormClass ?? 'search' }}" method="get" action="{{ route('search.listing') }}">
    <input autocomplete="off" type="text" name="q" value="{{ request('q') }}" required
        placeholder="{{ __('Search items') }}">
    <input type="hidden" name="category" id="headerSearchFormCategory" value="all">

    @php
        $category = request('category', __('All Category'));
        $category = is_object($category) ? $category->name : $category;
    @endphp
    <div class="search-modal-buttons">
        <button type="button" class="search-dropdown" data-value="{{ $category }}">
            {{ $category }}
            <span class="arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                    fill="none">
                    <path d="M5 7.5L10 12.5L15 7.5" stroke="#080808" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>
        </button>
        <button aria-label="Search" class="search-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="none">
                <path
                    d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z"
                    stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            @isset($fromMobileSearchModal)
                {{ __('Search') }}
            @endisset
        </button>
    </div>
    <div class="search-suggestion-box">
        @if (getRecentSearch())
            <div class="top-search mb-3">
                <h6>{{ __('Recently Search') }}</h6>
                <div class="top-search-buttons">
                    @foreach (getRecentSearch() as $item)
                        @php
                            $searchItem = is_string($item) ? $item : $item->search;
                        @endphp
                        <div class="top-search-button cursor-pointer">
                            <span
                                onclick="window.location.href = '{{ route('search.listing', ['q' => $searchItem]) }}';">{{ $searchItem }}</span>
                            <button type="button" class=""
                                href="{{ route('search.listing', ['q' => $searchItem]) }}">
                                <span class="close recent-search-remove-btn" data-value="{{ $item }}"><img
                                        src="{{ themeAsset('images/icon/humbleicons--times.svg') }}"
                                        alt="CROSS ICON"></span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="top-search">
            <h6>{{ __('Top Search') }}</h6>
            <div class="top-search-buttons">
                @foreach (getTopSearch() as $key => $item)
                    <a href="{{ route('search.listing', ['q' => $item->query]) }}" class="top-search-button">
                        {{ $item->query }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="search-dropdown-lists">
        @include('frontend::include.common.category')
    </div>
</form>
