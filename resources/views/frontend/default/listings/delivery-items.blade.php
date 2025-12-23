@extends('frontend::layouts.user')
@section('title')
    {{ __('Listing Delivery Items') }}
@endsection
@section('content')
    <div class="transactions-history-box">
        <div class="sort-title">
            <h4>{{ __('Listing Delivery Items') }}</h4>
        </div>
        <div class="listing-delivery-item">
            <form method="post"
                action="{{ buyerSellerRoute('listing.delivery-items.store', [
                    'id' => request()->id,
                    'order_id' => request()->order_id,
                    'redirect' => request()->redirect,
                ]) }}">
                @csrf
                <div class="row g-4">
                    @foreach ($listing->deliveryItems as $items)
                        @if (request('order_id') && $order && $loop->iteration > $order->quantity)
                            @continue;
                        @endif
                        <div class="col-lg-6">
                            <div class="td-form-group common-select2-dropdown">
                                <label for="" class="input-label">{{ __('Delivery Items for Item no.') }}.
                                    {{ $loop->iteration }} {{ $items->is_used ? '(Used)' : '' }} <span>*</span></label>
                                <div class="input-field id-{{ $items->id }}">
                                    <textarea @readonly($items->is_used) required name="delivery_items[{{ encrypt($items->id) }}]" placeholder="Enter Delivery Items"
                                        id="">{{ $items->data }}</textarea>
                                </div>
                                <p class="feedback-invalid">{{ __('This field is required') }}</p>
                            </div>
                        </div>
                    @endforeach
                    @if ($listing->quantity <= $listing->deliveryItemsNoData()->count())
                        <div class="col-12">
                            <div class="set-method-btn">
                                <button class="primary-button primary-button-full xl-btn primary-button-blue w-100">
                                    {{ __('Update Delivery Items') }}
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
@endpush
