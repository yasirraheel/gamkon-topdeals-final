<div class="full-payment-form">
    <div class="inside">
        <div class="payment-box" data-background="{{ themeAsset('images/payment-method/payment-bg.png') }}">
            <div class="withdraw-box">
                <p>{{ __('Withdrawable Funds') }}</p>
                <h3>{{ amountWithCurrency(auth()->user()->balance) }}</h3>
            </div>
        </div>
        <div class="withdraw-form">
            <div class="title">
                <h4>{{ __('Payout Form') }}</h4>
            </div>
            <form class="forms" action="{{ buyerSellerRoute('payment.withdraw.now') }}" method="POST">
                @csrf
                <div class="row gy-3">
                    <div class="col-12">
                        <div class="td-form-group common-image-select2">
                            <label class="input-label" for="imageSelect1">{{ __('Withdraw Account') }}
                                <span>*</span></label>
                            <select name="withdraw_account" id="imageSelect1" style="width: 100%">
                                <option value="" disabled selected>{{ __('Select Account') }}</option>
                                @foreach ($accounts as $account)
                                    <option data-image="{{ asset($account->method->icon) }}"
                                        value="{{ $account->id }}">
                                        {{ $account->method_name }} ({{ ucwords($account->method->type) }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="td-form-group">
                            <label class="input-label">{{ __('Amount') }} <span>*</span></label>
                            <div class="input-field">
                                <input type="text" max="{{ auth()->user()->balance }}" name="amount"
                                    class="form-control withdraw-amount" required>
                            </div>
                            <div class="range text-danger mt-1"></div>
                        </div>
                    </div>
                    <div class="col-12 row detailsCol gy-2">

                    </div>
                    <div class="col-12">
                        <div class="action-btn">
                            <button type="submit" class="primary-button xl-btn w-100">{{ __('Payout') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
