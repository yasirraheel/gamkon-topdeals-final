@if ($paginator->hasPages())
    <div class="common-pagination title_mt">
        <ul>
            {{-- Previous Page Link --}}
            <li>
                @if ($paginator->onFirstPage())
                    <a href="#" aria-disabled="true" class="td-pagination-prev disabled">
                        <iconify-icon icon="hugeicons:arrow-left-01" class="arrow"></iconify-icon>
                    </a>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="td-pagination-prev">
                        <iconify-icon icon="hugeicons:arrow-left-01" class="arrow"></iconify-icon>
                    </a>
                @endif
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <a href="{{ $url }}" class="active">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif

                {{-- Three Dots Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="td-pagination-next">
                        <iconify-icon icon="hugeicons:arrow-right-01" class="arrow"></iconify-icon>
                    </a>
                @else
                    <a href="#" aria-disabled="true" class="td-pagination-next disabled">
                        <iconify-icon icon="hugeicons:arrow-right-01" class="arrow"></iconify-icon>
                    </a>
                @endif
            </li>
        </ul>
    </div>
@endif
