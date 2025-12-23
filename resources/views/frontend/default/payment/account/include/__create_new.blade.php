<!-- page modal start -->
<div class="common-modal-full" id="withdrawNewAccount">
    <div class="common-modal-box">
        <div class="content">
            <div class="add-new-withdrawal">
                <div class="title-and-close">
                    <h4>{{ __('Add New Payout Account') }}</h4>
                </div>
                <div class="add-forms">
                    <form action="{{ buyerSellerRoute('payment.withdraw.account.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="td-form-group common-image-select2">
                                <label class="input-label" for="selectMethod">{{ __('Gateway') }} <span>*</span></label>
                                <select name="withdraw_method_id" id="imageSelect1" style="width: 100%">
                                    <option disabled data-image="{{ asset($withdrawMethods->first()?->icon) }}"
                                        selected>{{ __('Select Gateway') }}</option>
                                    @foreach ($withdrawMethods as $raw)
                                        <option data-image="{{ asset($raw->icon ?? $withdrawMethods->first()?->icon) }}"
                                            value="{{ $raw->id }}">{{ $raw->name }} ({{ ucwords($raw->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="feedback-invalid">{{ __('This field is required') }}</p>
                            </div>
                        </div>
                        <div class="col-12 row manual-row gy-4 mt-0"></div>
                        <div class="modal-action-btn mt-4">
                            <button type="submit" class="primary-button">{{ __('Create Payout Account') }}</button>
                            <button type="button" class="close withdraw-close">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page modal end -->
