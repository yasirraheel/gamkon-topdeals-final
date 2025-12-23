@extends('backend.layouts.app')
@section('setting-title')
    {{ __('View Order') }}
@endsection
@section('title')
    {{ __('View Order') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content d-flex justify-content-between">
                            <h2 class="title">{{ __('View Order: :orderNo', ['orderNo' => '#' . $order->order_number]) }}
                            </h2>
                            <a href="{{ route('admin.order.index') }}" class="title-btn">{{ __('Back') }}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Order Information') }}</h3>


                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                                    <div class="site-card">
                                        <div class="site-card-header">
                                            <h4 class="title-small">{{ __('Seller Information') }}</h4>
                                        </div>
                                        <div class="site-card-body">
                                            @if ($order->seller)
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Name') }}</div>
                                                    <div class="value"><a class="link"
                                                            href="{{ route('admin.user.edit', $order->seller_id ?? 0) }}">{{ $order->seller?->username }}</a>
                                                    </div>
                                                </div>
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Email') }}</div>
                                                    <div class="value">{{ $order->seller?->email }}</div>
                                                </div>
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Phone') }}</div>
                                                    <div class="value">{{ $order->seller?->phone }}</div>
                                                </div>
                                            @else
                                                <p class="text-danger text-center">{{ __('Seller not found') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                                    <div class="site-card">
                                        <div class="site-card-header">
                                            <h4 class="title-small">{{ __('Buyer Information') }}</h4>
                                        </div>
                                        <div class="site-card-body">
                                            @if ($order->buyer)
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Name') }}</div>
                                                    <div class="value"><a class="link"
                                                            href="{{ route('admin.user.edit', $order->buyer_id ?? 0) }}">{{ $order->buyer?->username }}</a>
                                                    </div>
                                                </div>
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Email') }}</div>
                                                    <div class="value">{{ $order->buyer->email }}</div>
                                                </div>
                                                <div class="profile-text-data">
                                                    <div class="attribute">{{ __('Phone') }}</div>
                                                    <div class="value">{{ $order->buyer->phone }}</div>
                                                </div>
                                            @else
                                                <p class="text-danger text-center">{{ __('Buyer not found') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                                    <div class="site-card">
                                        <div class="site-card-header">
                                            <h4 class="title-small">{{ __('Order Information') }}</h4>
                                        </div>
                                        <div class="site-card-body">
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Order Number') }}</div>
                                                <div class="value">
                                                    {{ $order->order_number }}
                                                </div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Order Date') }}</div>
                                                <div class="value">{{ $order->created_at }}</div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Order Status') }}</div>
                                                <div class="value">{!! bsToAdminBadges($order->status_badge) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @can('order-update')
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                                        <div class="site-card">
                                            <div class="site-card-header">
                                                <h4 class="title-small">{{ __('Update Order Status') }}</h4>
                                            </div>
                                            <form id="updateStatusForm"
                                                action="{{ route('admin.order.update-status', $order->id) }}" method="post">
                                                @csrf
                                                <div class="site-card-body">
                                                    <div class="col-md-12">
                                                        <div class="site-input-groups row">
                                                            <label class="box-input-label col-auto col-label"
                                                                for="">{{ __('Order Status') }}</label>
                                                            <select name="status" id="" class="form-select col">
                                                                @foreach ($orderStatus as $status)
                                                                    <option @selected($order->status == $status->value)
                                                                        value="{{ $status->value }}">
                                                                        {{ str($status->name)->headline() }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="site-input-groups row">
                                                            <label class="box-input-label col-auto col-label"
                                                                for="">{{ __('Payment Status') }}</label>
                                                            <select name="payment_status" id=""
                                                                class="form-select col">
                                                                @foreach ($paymentStatus as $status)
                                                                    <option @selected($order->payment_status == $status->value)
                                                                        value="{{ $status->value }}">{{ $status->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="site-card">
                            <div class="site-card-header d-flex">
                                <h3 class="title">{{ __('Order Details') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="site-table table-responsive profile-text-data">
                                    <table class="table attribute mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Item Name') }}</th>
                                                <th>{{ __('Unit Price') }}</th>
                                                <th>{{ __('Coupon Discount') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Subtotal') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a target="_blank" class="link"
                                                        href="{{ route('listing.details', $order->listing->slug ?? 'not-found') }}">{{ $order->listing?->product_name ?? '[Deleted]' }}</a>
                                                </td>
                                                <td>
                                                    @if ($order->is_topup)
                                                        {{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}
                                                    @else
                                                        {{ amountWithCurrency($order->org_unit_price, setting('site_currency', 'global')) }}
                                                        <br>
                                                        @if ($order->org_unit_price > $order->unit_price)
                                                            <small><i><b>{{ __('Discount: -') . amountWithCurrency($order->org_unit_price - $order->unit_price, setting('site_currency', 'global')) }}</b></i></small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ amountWithCurrency($order->discount_amount, setting('site_currency', 'global')) }}
                                                </td>
                                                <td>{{ $order->quantity }}</td>
                                                <td>{{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}
                                                </td>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">{{ __('Subtotal') }}</td>
                                                <td>{{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">{{ __('Gateway Charge') }}</td>
                                                <td>{{ amountWithCurrency($order->transaction->charge, setting('site_currency', 'global')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><strong>{{ __('Total') }}</strong></td>
                                                <td>
                                                    <strong style="color:#000000;">
                                                        {{ amountWithCurrency($order->transaction->amount, $order->transaction->pay_currency) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
            "use strict";
            $(document).on('change', '#updateStatusForm', function() {
                $('#updateStatusForm').submit();
            });
        </script>
    @endsection
