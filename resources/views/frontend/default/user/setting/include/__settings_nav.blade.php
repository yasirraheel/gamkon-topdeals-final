<div class="ads-step">
    <div class="ads-step-inner">
        <a class="step-btn {{ Route::is('user.setting.show') ? 'is-active' : '' }}"
            href="{{ buyerSellerRoute('setting.show') }}">{{ __('Settings') }}</a>
        <a class="step-btn {{ Route::is('user.change.password') ? 'is-active' : '' }}"
            href="{{ buyerSellerRoute('change.password') }}">{{ __('Change Password') }}</a>
        @if (setting('kyc_verification', 'permission'))
            <a class="step-btn {{ Route::is('user.kyc') ? 'is-active' : '' }}"
                href="{{ buyerSellerRoute('kyc') }}">{{ __('ID Verification') }}</a>
        @endif
    </div>
</div>
