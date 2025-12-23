@extends('backend.layouts.app')
@section('title')
    {{ __('Account Plans') }} - {{ $catalog->name }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Account Plans') }} - {{ $catalog->name }}</h2>
                            <div>
                                <a href="{{ route('admin.product-catalog.index') }}" class="title-btn me-2"><i
                                        data-lucide="arrow-left"></i>{{ __('Back to Catalogs') }}</a>
                                @can('product-catalog-create')
                                    <a href="{{ route('admin.account-plans.create', $catalog->id) }}" class="title-btn"><i
                                            data-lucide="plus-circle"></i>{{ __('Add Plan') }}</a>
                                @endcan
                            </div>
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
                                            @include('backend.filter.th', [
                                                'label' => __('Plan Name'),
                                                'field' => 'plan_name',
                                            ])
                                            <th scope="col">{{ __('Description') }}</th>
                                            <th scope="col">{{ __('Order') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($plans as $plan)
                                            <tr>
                                                <td><strong>{{ $plan->plan_name }}</strong></td>
                                                <td>{{ Str::limit($plan->description ?? '-', 50) }}</td>
                                                <td>{{ $plan->order }}</td>
                                                <td>
                                                    @if ($plan->status)
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('product-catalog-edit')
                                                        <a href="{{ route('admin.account-plans.edit', [$catalog->id, $plan->id]) }}"
                                                            class="round-icon-btn primary-btn" id="edit"
                                                            data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                            data-bs-original-title="{{ __('Edit Plan') }}">
                                                            <i data-lucide="edit-3"></i>
                                                        </a>
                                                        <a href="{{ route('admin.account-plans.status.toggle', [$catalog->id, $plan->id]) }}"
                                                            class="round-icon-btn {{ $plan->status ? 'danger-btn' : 'success-btn' }}"
                                                            id="status-toggle"
                                                            data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                            data-bs-original-title="{{ $plan->status ? __('Deactivate') : __('Activate') }}">
                                                            <i data-lucide="{{ $plan->status ? 'x-circle' : 'check-circle' }}"></i>
                                                        </a>
                                                    @endcan
                                                    @can('product-catalog-delete')
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#deletePlan-{{ $plan->id }}"
                                                            class="round-icon-btn danger-btn"
                                                            data-bs-original-title="{{ __('Delete Plan') }}">
                                                            <i data-lucide="trash-2"></i>
                                                        </button>
                                                        @include('backend.account-plans.include.__delete', [
                                                            'plan' => $plan,
                                                            'catalog' => $catalog,
                                                        ])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-section">
                                    {{ $plans->links('backend.include.__pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
