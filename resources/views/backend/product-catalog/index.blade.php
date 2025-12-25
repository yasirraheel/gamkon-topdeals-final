@extends('backend.layouts.app')
@section('title')
    {{ __('Product Catalog') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Product Catalog') }}</h2>
                            @can('product-catalog-create')
                                <a href="{{ route('admin.product-catalog.create') }}" class="title-btn"><i
                                        data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="">
                            <div class="site-table table-responsive">
                                <form action="{{ request()->fullUrl() }}" method="get" id="filterForm">
                                    <div class="table-filter">
                                        <div class="filter d-flex">
                                            <div class="search">
                                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                                    placeholder="{{ __('Search') }}...">
                                            </div>
                                            <button type="submit" class="apply-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" data-lucide="search"
                                                    class="lucide lucide-search">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="m21 21-4.3-4.3"></path>
                                                </svg>{{ __('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Icon') }}</th>
                                            <th scope="col">{{ __('Thumbnail') }}</th>
                                            @include('backend.filter.th', [
                                                'label' => __('Product Name'),
                                                'field' => 'name',
                                            ])
                                            <th scope="col">{{ __('Durations') }}</th>
                                            <th scope="col">{{ __('Plans') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($catalogs as $catalog)
                                            <tr>
                                                <td>
                                                    @if($catalog->icon)
                                                        <img src="{{ asset($catalog->icon) }}" alt="{{ $catalog->name }}" width="40">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($catalog->thumbnail)
                                                        <img src="{{ asset($catalog->thumbnail) }}" alt="{{ $catalog->name }}" width="50">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $catalog->name }}</strong></td>
                                                <td>
                                                    @if($catalog->durations && count($catalog->durations) > 0)
                                                        @foreach($catalog->durations as $duration)
                                                            <span class="badge bg-info text-white me-1">{{ $duration }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($catalog->plans && count($catalog->plans) > 0)
                                                        @foreach($catalog->plans as $plan)
                                                            <span class="badge bg-primary text-white me-1 mb-1">{{ $plan }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($catalog->status)
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-btn-group">
                                                        @can('product-catalog-edit')
                                                            <a href="{{ route('admin.product-catalog.edit', $catalog->id) }}"
                                                                class="round-icon-btn primary-btn" id="edit"
                                                                data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                                data-bs-original-title="{{ __('Edit Product Catalog') }}">
                                                                <i data-lucide="edit-3"></i>
                                                            </a>
                                                            <a href="{{ route('admin.product-catalog.status.toggle', $catalog->id) }}"
                                                                class="round-icon-btn {{ $catalog->status ? 'danger-btn' : 'success-btn' }}"
                                                                id="status-toggle"
                                                                data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                                data-bs-original-title="{{ $catalog->status ? __('Deactivate') : __('Activate') }}">
                                                                <i data-lucide="{{ $catalog->status ? 'x-circle' : 'check-circle' }}"></i>
                                                            </a>
                                                        @endcan
                                                        @can('product-catalog-delete')
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#deleteCatalog-{{ $catalog->id }}"
                                                                class="round-icon-btn danger-btn"
                                                                data-bs-original-title="{{ __('Delete Product Catalog') }}">
                                                                <i data-lucide="trash-2"></i>
                                                            </button>
                                                            @include('backend.product-catalog.include.__delete', [
                                                                'catalog' => $catalog,
                                                            ])
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-section">
                                    {{ $catalogs->links('backend.include.__pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
