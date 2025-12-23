@extends('frontend::layouts.user')
@section('title')
    {{ __('Coupons') }}
@endsection

@section('content')
    <div class="transactions-history-box">
        <x-luminous.dashboard-breadcrumb title="{{ __('Coupons') }}" class="table-sort-2">
            <div class="left">
                <select class="nice-select-active sort-coupon" style="display: none;">
                    <option @selected(request('filter') == 'active') value="active">
                        {{ __('Active') }}</option>
                    <option @selected(request('filter') == 'inactive') value="inactive">
                        {{ __('Expired/Inactive') }}</option>

                    <option @selected(request('filter') == '') value="">{{ __('All') }}
                    </option>
                </select>
            </div>
            <div class="right">
                <a href="{{ buyerSellerRoute('coupon.create') }}"
                    class="primary-button common-modal-button">{{ __('Create Coupon') }}</a>
            </div>
        </x-luminous.dashboard-breadcrumb>
    </div>
    <div class="common-table">
        <div class="common-table-full">
            <table class="table align-middle listing-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">{{ __('Code') }}
                        </th>
                        <th scope="col" class="text-nowrap">{{ __('Value') }}
                        </th>
                        <th scope="col" class="text-nowrap">
                            {{ __('Expires At') }}</th>
                        <th scope="col" class="text-nowrap">{{ __('Status') }}
                        </th>
                        <th scope="col" class="text-nowrap">
                            {{ __('Approval Status') }}</th>
                        <th scope="col" class="text-nowrap">
                            {{ __('Max Use Limit') }}</th>
                        <th scope="col" class="text-nowrap">
                            {{ __('Total Used') }}</th>
                        <th scope="col" class="text-nowrap">{{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td class=""><strong>{{ $coupon->code }}</strong></td>
                            <td class="">{{ $coupon->discount_value }}
                                {{ $coupon->discount_type == 'percentage' ? '%' : $currency }}
                            </td>
                            <td class="">{{ $coupon->expires_at->format('Y-m-d') }}
                            </td>
                            <td class="">
                                @if ($coupon->status == 0)
                                    <span class="badge rounded-pill bg-danger">{{ __('Inactive') }}</span>
                                @elseif($coupon->expires_at->isFuture())
                                    <span class="badge rounded-pill bg-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">{{ __('Expired') }}</span>
                                @endif
                            </td>
                            <td class="">
                                @if ($coupon->admin_approval === 1)
                                    <span class="badge rounded-pill bg-success">{{ __('Approved') }}</span>
                                @elseif($coupon->admin_approval === 2)
                                    <span class="badge rounded-pill bg-danger">{{ __('Rejected') }}</span>
                                @else
                                    <span class="badge rounded-pill pending">{{ __('Pending') }}</span>
                                    <!-- Fixed typo in class name -->
                                @endif
                            </td>
                            <td class="">{{ $coupon->max_use_limit }}</td>
                            <td class="">{{ $coupon->total_used }}</td>
                            <td class="">
                                <div class="d-flex justify-content-center">
                                    <div class="tooltip-action-btns">
                                        <a href="{{ buyerSellerRoute('coupon.edit', $coupon->enc_id) }}"
                                            class="edit tooltip-btn edit-btn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                            <iconify-icon icon="lucide:edit" class="tooltip-icon"></iconify-icon>
                                        </a>
                                        <a href="{{ buyerSellerRoute('coupon.delete', $coupon->enc_id) }}"
                                            class="delete tooltip-btn delete-modal delete-btn"
                                            data-id="{{ $coupon->enc_id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                                            <iconify-icon icon="lucide:trash-2" class="tooltip-icon"></iconify-icon>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="">
                                <x-luminous.no-data-found type="Coupon" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-pagination">
            <div class="pagination">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        "use strict";

        $(document).on('click', '.has-not-cursor', function() {
            return false;
        });

        (function($) {

            // Delete Modal
            $('body').on('click', '#deleteBtn', function() {
                var id = $(this).data('id');
                var url = '{{ route('user.coupon.delete', ':id') }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

        })(jQuery);

        $(document).on('change', '.sort-coupon', function() {
            var url = "{{ buyerSellerRoute('coupon.index', ['filter' => '__filter']) }}";
            url = url.replaceAll('__filter', $(this).val());
            window.location.href = url;
        });
    </script>
@endpush
