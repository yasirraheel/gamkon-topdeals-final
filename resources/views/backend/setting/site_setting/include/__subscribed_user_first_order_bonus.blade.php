<div class="">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{ __($fields['title']) }}</h3>
        </div>
        <div class="site-card-body">

            @include('backend.setting.site_setting.include.form.__open_action')



            <div class="site-input-groups row">
                <label for="" class="col-sm-4 col-label">{{ __('Status') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input
                                onclick="fieldActiveToggle('subscribed_user_first_order_bonus','.subscribed_user_first_order_bonus-input')"
                                @checked(setting('subscribed_user_first_order_bonus', 'fee')) type="radio"
                                id="subscribed_user_first_order_bonus-disable-yes" class="site-currency-type"
                                name="subscribed_user_first_order_bonus" value="1" checked="">
                            <label for="subscribed_user_first_order_bonus-disable-yes">{{ __('Yes') }}</label>
                            <input
                                onclick="fieldActiveToggle('subscribed_user_first_order_bonus','.subscribed_user_first_order_bonus-input')"
                                @checked(!setting('subscribed_user_first_order_bonus', 'fee')) type="radio"
                                id="subscribed_user_first_order_bonus-disable-no"
                                name="subscribed_user_first_order_bonus" class="site-currency-type" value="0">
                            <label for="subscribed_user_first_order_bonus-disable-no">{{ __('No') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- subscribed_user_first_order_bonus_title --}}
            <div
                class="site-input-groups row subscribed_user_first_order_bonus-input {{ oldSetting('subscribed_user_first_order_bonus', 'fee') == 0 ? 'd-none' : '' }}">
                <div class="col-sm-4 col-label pt-0">{{ __('Title') }}</div>
                <div class="col-sm-8">
                    <div class="input-group joint-input">

                        <input name="subscribed_user_first_order_bonus_title"
                            value="{{ oldSetting('subscribed_user_first_order_bonus_title', 'fee') }}"
                            class="form-control ">
                    </div>
                </div>
            </div>

            {{-- subscribed_user_first_order_bonus_header --}}
            <div
                class="site-input-groups row subscribed_user_first_order_bonus-input {{ oldSetting('subscribed_user_first_order_bonus', 'fee') == 0 ? 'd-none' : '' }}">
                <div class="col-sm-4 col-label pt-0">{{ __('Header') }}</div>
                <div class="col-sm-8">
                    <div class="input-group joint-input">

                        <input name="subscribed_user_first_order_bonus_header"
                            value="{{ oldSetting('subscribed_user_first_order_bonus_header', 'fee') }}"
                            class="form-control ">
                    </div>
                </div>
            </div>

            {{-- subscribed_user_first_order_bonus_message --}}
            <div
                class="site-input-groups row subscribed_user_first_order_bonus-input {{ oldSetting('subscribed_user_first_order_bonus', 'fee') == 0 ? 'd-none' : '' }}">
                <div class="col-sm-4 col-label pt-0">{{ __('Message') }}</div>
                <div class="col-sm-8">
                    <textarea name="subscribed_user_first_order_bonus_message" class="form-textarea  ">{{ oldSetting('subscribed_user_first_order_bonus_message', 'fee') }}</textarea>
                </div>
            </div>
            <div
                class="site-input-groups row subscribed_user_first_order_bonus-input {{ oldSetting('subscribed_user_first_order_bonus', 'fee') == 0 ? 'd-none' : '' }}">
                <label for="" class="col-sm-4 col-label">{{ __('Amount') }}</label>
                <div class="col-sm-8">
                    <div class="site-input-groups position-relative">
                        <div class="position-relative">
                            <input type="text" class="box-input"
                                value="{{ oldSetting('subscribed_user_first_order_bonus_amount', 'fee') }}"
                                name="subscribed_user_first_order_bonus_amount">
                            <div class="prcntcurr">
                                <select name="subscribed_user_first_order_bonus_type" class="form-select"
                                    id="">
                                    @foreach (['fixed' => setting('currency_symbol', 'fee'), 'percentage' => '%'] as $key => $value)
                                        <option @if (oldSetting('subscribed_user_first_order_bonus_type', 'fee') == $key) selected @endif
                                            value="{{ $key }}"> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.setting.site_setting.include.form.__close_action')

        </div>
    </div>
</div>
