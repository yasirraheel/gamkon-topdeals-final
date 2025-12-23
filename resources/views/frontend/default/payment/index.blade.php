@extends('frontend::layouts.user')
@section('title')
    {{ __('Payout') }}
@endsection
@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444 !important;
        }
    </style>
@endpush
@section('content')
    <div class="payment-form">
        <x-luminous.dashboard-breadcrumb title="{{ __('Payout') }}">
            <a href='{{ buyerSellerRoute('payment.withdraw.account.index') }}'
                class='primary-button'>{{ __('Payout Accounts') }}</a>
        </x-luminous.dashboard-breadcrumb>
        <div>
            @include('frontend::payment.include.__withdraw_form')
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';
        $('.common-modal .close').on('click', function() {
            $(this).parents('.common-modal').removeClass('open');
        });

        $(document).on('click', '.click-to-open-modal', function() {
            $($(this).data('target')).addClass('open');
            if ($(this).hasClass('edit')) {
                edit(this);
            }
        })

        function edit(sel) {
            var id = $(sel).data('id');
            var url = "{{ buyerSellerRoute('payment.withdraw.account.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);

            var formUrl = "{{ buyerSellerRoute('payment.withdraw.account.update', ['id' => ':id']) }}";
            $('#edit-form').attr('action', formUrl.replace(':id', id));

            $.get(url, function(response) {
                $('.edit-manual-row').html(response.html);
                // editSelectMethod select2
                $('.editSelectMethod').select2({
                    templateResult: formatOption,
                    templateSelection: formatOption,
                    minimumResultsForSearch: Infinity
                });
            })
        }

        //common image select
        function formatOption(option) {
            if (!option.id) return option.text;
            const imgSrc = $(option.element).data('image');
            return $('<span><img src="' + imgSrc + '" style="width:20px; margin-right:10px;">' + option.text + '</span>');
        }
        $('#selectMethod,.editSelectMethod, #selectWithdrawMethod').select2({
            templateResult: formatOption,
            templateSelection: formatOption,
            minimumResultsForSearch: Infinity
        });



        var currency = @json($currency);
        var info = [];

        $('.method').hide();

        $(document).on('change input', "#imageSelect1,input[name=amount].withdraw-amount", function(e) {

            var accountId = $('#imageSelect1').val()
            var amount = $('input[name=amount].withdraw-amount').val();

            if (!isNaN(accountId)) {
                var url =
                    '{{ buyerSellerRoute('payment.withdraw.details', ['accountId' => ':accountId', 'amount' => ':amount']) }}';
                url = url.replace(':accountId', accountId, );
                url = url.replace(':amount', amount);
                $.get(url, function(data) {
                    $(".detailsCol").html(data.html);
                    info = data.info;

                    // Update all the details with the received data
                    $('.range').text(info.range);
                    $('.processing-time').text(info.processing_time);
                    $('.method').html('<span class="type site-badge badge-primary">' + info.name +
                        '</span>');
                    $('.method').show();
                    $('.method-logo').attr('src', info.logo);
                    $('.withdrawFee').text(info.charge);

                    // Update conversion rate if available
                    if (info.rate && info.pay_currency) {
                        $('.conversion-rate').text('1 ' + currency + ' = ' + info.rate + ' ' + info
                            .pay_currency);

                        // Calculate and update pay amount
                        if (amount) {
                            $('.pay-amount').text(info.pay_amount + ' ' + info.pay_currency);
                        }
                    }
                })
            }

        })


        function calPercentage(num, percentage) {
            const result = num * (percentage / 100);
            return parseFloat(result.toFixed(2));
        }
    </script>
@endpush
