@php
    $checkingRouteName = isset($listing) ? 'seller.listing.edit' : 'seller.listing.create';
@endphp
<div class="selling-steps">
    <div class="all-steps">
        <div class="steps">
            <a href="{{ route($checkingRouteName, ['category', request()->id]) }}" @class([isMenuOpen($checkingRouteName, ['category', request()->id])])>
                <span @class(['normal', 'd-none' => !in_array($step, ['category'])])>1</span>
                <span @class(['success', 'deactive' => in_array($step, ['category'])])>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                        <path d="M14.6673 1L5.50065 10.1667L1.33398 6" stroke="#080808" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{ __('Choose a Category') }}
            </a>
            <a href="{{ route($checkingRouteName, ['description', request()->id]) }}" @class([
                'has-not-cursor' => in_array($step, ['category', 'description']),
                isMenuOpen($checkingRouteName, ['description', request()->id]),
            ])>
                <span @class([
                    'normal',
                    'd-none' => in_array($step, ['delivery', 'review']),
                ])>2</span>
                <span @class([
                    'success',
                    'deactive' => !in_array($step, ['delivery', 'review']),
                ])>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12"
                        fill="none">
                        <path d="M14.6673 1L5.50065 10.1667L1.33398 6" stroke="#080808" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{ __('Product Details') }}
            </a>
            <a href="{{ route($checkingRouteName, ['delivery', request()->id]) }}" @class([
                'has-not-cursor' => in_array($step, [
                    'category',
                    'description',
                    'delivery',
                ]),
                isMenuOpen($checkingRouteName, ['delivery', request()->id]),
            ])>
                <span @class(['normal', 'd-none' => in_array($step, ['review'])])>3</span>
                <span @class(['success', 'deactive' => !in_array($step, ['review'])])>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12"
                        fill="none">
                        <path d="M14.6673 1L5.50065 10.1667L1.33398 6" stroke="#080808" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{ __('Delivery Method') }}
            </a>
            <a href="{{ route($checkingRouteName, ['review', request()->id]) }}" @class([
                'has-not-cursor' => in_array($step, [
                    'category',
                    'description',
                    'delivery',
                    'review',
                ]),
                isMenuOpen($checkingRouteName, ['review', request()->id]),
            ])>
                <span @class(['normal'])>4</span>
                <span @class(['success', 'deactive'])>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12"
                        fill="none">
                        <path d="M14.6673 1L5.50065 10.1667L1.33398 6" stroke="#080808" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{-- @dump(request()->url() , route($route, $parameter)) --}}
                {{ __('Review & Confirm') }}
            </a>
        </div>
    </div>
</div>
@push('js')
    <script>
        "use strict";

        //category check
        $(document).ready(function() {
            $(document).on('click', '.category-box', function() {
                $(this).parents('.all-common').find('.category-box').removeClass('active');
                $(this).parents('.all-common').find('.category-box input[type="checkbox"]').prop('checked',
                    false);

                $(this).addClass('active');
                $(this).find('input[type="checkbox"]').prop('checked', true);
            });
        });
    </script>
@endpush
