@push('css')
    <style>

    </style>
@endpush
<div class="choose-common">
    <h4>{{ __('Delivery Method') }}</h4>
    <div class="all-common">
        <form method="post" action="{{ buyerSellerRoute('listing.edit', ['review', request()->id]) }}">
            @csrf
            <div class="row g-4">
                <div class="col-12">
                    <div class="td-form-group common-select2-dropdown">
                        <input type="hidden" name="product_id" value="{{ request()->id }}">
                        <div class="auth-nice-select">
                            <select name="delivery_method" id="select2Delivary" class="nice-select-active">
                                @foreach (json_decode(setting('delivery_method')) as $deliveryMethod)
                                    <option @selected($deliveryMethod == $listing?->delivery_method) value="{{ $deliveryMethod }}">
                                        {{ ucwords($deliveryMethod) }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <span class="form-info">Product automatically send the product upon purchase.</span> --}}
                        {{-- <p class="feedback-invalid">This field is required</p> --}}
                    </div>
                </div>
                <div class="col-12 delivery_method_info {{ $listing?->delivery_method == 'manual' ? '' : 'd-none' }}">
                    <div class="td-form-group">
                        <label for="" class="input-label">{{ __('Select Delivery Speed') }}</label>
                        <div class="input-field">
                            <input type="text" class="form-control"
                                value="{{ old('delivery_speed', $listing?->delivery_speed) }}"
                                placeholder="{{ $listing?->delivery_speed }}" name="delivery_speed">
                            <div class="right-dropdown">
                                <div class="form-right-dropdown-nice-select">
                                    <select name="delivery_speed_unit" @disabled(!$listing?->delivery_method == 'manual')
                                        class="nice-select-active" id="delivery_speed_unit">
                                        <option @selected(old('delivery_speed_unit', $listing?->delivery_speed_unit) == 'second') value="second">Seconds</option>
                                        <option @selected(old('delivery_speed_unit', $listing?->delivery_speed_unit) == 'minute') value="minute">Minutes</option>
                                        <option @selected(old('delivery_speed_unit', $listing?->delivery_speed_unit) == 'hour') value="hour">Hours</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="set-method-btn">
                        <button class="primary-button primary-button-full xl-btn primary-button-blue w-100">
                            @if ($listing)
                                {{ __('Update Delivery Method') }}
                            @else
                                {{ __('Set Delivery Method') }}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        "use strict";
        $(document).on('change', '#select2Delivary', function() {
            if ($(this).val() == 'manual') {
                $('.delivery_method_info').removeClass('d-none');
                $('#delivery_speed_unit').val('minute');
                $('#delivery_speed_unit').prop('disabled', false);
            } else {
                $('.delivery_method_info').addClass('d-none');
                $('#delivery_speed_unit').prop('disabled', true);
            }
            $('#delivery_speed_unit').niceSelect('update');

        })
        $('#select2Delivary').trigger('change')
    </script>
@endpush
