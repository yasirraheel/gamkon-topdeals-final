@extends('backend.layouts.app')
@section('title')
    {{ __('Coupons') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Coupons') }}</h2>
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
                                        <div class="filter">
                                            <div class="search">
                                                <input type="text" id="search" name="search"
                                                    value="{{ request('search') }}" placeholder="{{ __('Search') }}...">
                                            </div>
                                            <button type="submit" class="apply-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    data-lucide="search" class="lucide lucide-search">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="m21 21-4.3-4.3"></path>
                                                </svg>{{ __('Search') }}
                                            </button>
                                        </div>
                                        <div class="filter d-flex">
                                            <select class="form-select form-select-sm show"
                                                aria-label=".form-select-sm example" name="perPage" id="perPage">
                                                <option @selected(request('perPage') == 15) value="15">{{ __('15') }}
                                                </option>
                                                <option @selected(request('perPage') == 30) value="30">{{ __('30') }}
                                                </option>
                                                <option @selected(request('perPage') == 45) value="45">{{ __('45') }}
                                                </option>
                                                <option @selected(request('perPage') == 60) value="60">{{ __('60') }}
                                                </option>
                                            </select>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                name="status" id="status">
                                                <option value="" disabled="" selected="">
                                                    {{ __('Review Status') }}
                                                </option>
                                                <option @selected(request('status') == 'all') value="all">{{ __('All') }}
                                                </option>
                                                <option @selected(request('status') == 'pending') value="pending">{{ __('Pending') }}
                                                </option>
                                                <option @selected(request('status') == 'approved') value="approved">{{ __('Approved') }}
                                                </option>
                                                <option @selected(request('status') == 'rejected') value="rejected">{{ __('Rejected') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Seller') }}</th>
                                            <th scope="col">{{ __('Code') }}</th>
                                            @include('backend.filter.th', [
                                                'label' => 'Value',
                                                'field' => 'discount_value',
                                            ])
                                            @include('backend.filter.th', [
                                                'label' => 'Expires At',
                                                'field' => 'expires_at',
                                            ])
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Approval Status') }}</th>
                                            @include('backend.filter.th', [
                                                'label' => 'Max Use Limit',
                                                'field' => 'max_use_limit',
                                            ])
                                            @include('backend.filter.th', [
                                                'label' => 'Total Used',
                                                'field' => 'total_used',
                                            ])
                                            <th scope="col">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $coupon)
                                            <tr>
                                                <td><a class="link"
                                                        href="{{ route('admin.user.edit', $coupon->seller_id) }}">{{ $coupon->seller?->username ?? 'N/A' }}</a>
                                                </td>
                                                <td><strong>{{ $coupon->code }}</strong></td>
                                                <td> {{ $coupon->discount_value }}{{ $coupon->discount_type == 'percentage' ? '%' : ' ' . $currency }}
                                                </td>
                                                <td>{{ $coupon->expires_at->format('Y-m-d') }}</td>
                                                <td>
                                                    @if ($coupon->expires_at->isFuture())
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Expired') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($coupon->admin_approval == 1)
                                                        <div class="site-badge success">{{ __('Approved') }}</div>
                                                    @elseif($coupon->admin_approval == 2)
                                                        <div class="site-badge danger">{{ __('Rejected') }}</div>
                                                    @else
                                                        <div class="site-badge pending">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>
                                                <td>{{ $coupon->max_use_limit }}</td>
                                                <td>{{ $coupon->total_used }}</td>
                                                <td>
                                                    @can('coupon-edit')
                                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                                            class="round-icon-btn primary-btn" id="edit"
                                                            data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                            data-bs-original-title="{{ __('Edit Coupon') }}">
                                                            <i data-lucide="edit-3"></i>
                                                        </a>
                                                    @endcan
                                                    @can('coupon-delete')
                                                        <a href="#" class="round-icon-btn red-btn" id="deleteBtn"
                                                            data-id="{{ $coupon->id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-bs-original-title="{{ __('Delete Coupon') }}">
                                                            <i data-lucide="trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="10" class="text-center">{{ __('No Data Found!') }}</td>
                                        @endforelse
                                    </tbody>
                                </table>
                                @include('frontend::coupons.include.__delete_modal')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function($) {
            "use strict";

            // Delete Modal
            $('body').on('click', '#deleteBtn', function() {
                var id = $(this).data('id');
                var url = '{{ route('admin.coupon.delete', ':id') }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

        })(jQuery);
        $(document).on('change', '#filterForm select', function() {
            $('#filterForm').submit();
        });
    </script>
@endsection
