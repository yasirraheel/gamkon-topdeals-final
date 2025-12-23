{{-- data --}}
{{-- $routesLists ['Create Listing' => buyerSellerRoute('listing.create', 'category')] --}}
{{-- icon --}}
{{-- is_seller --}}

@php
    $routeArr = array_values($routesLists);
    $routeNames = array_keys($routesLists);

    $isCurrentRoute = in_array(url()->current(), $routeArr);
@endphp
<li class="slide {{ $isCurrentRoute ? 'open active' : '' }} has-submenu-slide">
    <a href="{{ route($routeValues, 'category') }}"
        class="sidebar-menu-item has-dropdown {{ $isCurrentRoute ? 'open' : '' }}">
        <span class="side-menu-icon">
            <iconify-icon icon="{{ $icon }}" class="listing-icon dashbaord-icon"></iconify-icon>
        </span>
        <span class="sidebar-menu-label">{{ $sectionName }}</span>
        <span class="dropdown-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M5.83333 8.33333L9.99999 12.5L14.1667 8.33333" stroke="#303030" stroke-width="1.66667"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </a>
    <ul class="has-submenu-slide-content {{ $isCurrentRoute ? 'open' : '' }}"
        style="{{ $isCurrentRoute ? 'display: block;' : 'display: none;' }}">
        @foreach ($routesLists as $key => $route)
            <li>
                <a href="{{ $route }}"
                    class="sidebar-inside-menu-item {{ url()->current() == $route ? 'active' : '' }}">
                    <span class="sidebar-menu-label">{{ $key }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</li>
