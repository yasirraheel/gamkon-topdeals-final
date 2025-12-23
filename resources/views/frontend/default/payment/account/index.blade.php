@extends('frontend::layouts.user')
@section('title')
    {{ __('Payout Account') }}
@endsection
@section('content')
    <div class="payment-form">
        <h4>{{ __('Payout Account') }}</h4>
        <div class="add-payment-button">
            <button class="primary-button common-modal-button">
                {{ __('Add New Payout Account') }}
            </button>
        </div>
        <div class="common-table">
            <div class="common-table-full">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">{{ __('Account') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accounts as $account)
                            <tr>
                                <th>
                                    <div class="account-name">
                                        <div class="icon">
                                            <img src="{{ asset($account->method->icon) }}"
                                                alt="{{ $account->method_name }}">
                                        </div>
                                        <div class="text">
                                            <p>{{ $account->method_name }}
                                                {{ $account->method->currency ? '(' . $account->method->currency . ')' : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <div class="tooltip-action-btns">
                                        <a href="javascript:void(0)" type="button" class="tooltip-btn edit-btn"
                                            data-id="{{ encrypt($account->id) }}">
                                            <iconify-icon icon="lucide:edit" class="tooltip-icon"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)" type="button" class="tooltip-btn delete-btn"
                                            data-id="{{ encrypt($account->id) }}" data-bs-target="#withdrawDeleteAcount">
                                            <iconify-icon icon="lucide:trash-2"
                                                class="tooltip-icon tooltip-icon-trash"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    <x-luminous.no-data-found type="Payout Account" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('frontend::payment.account.include.__create_new', ['withdrawMethods' => $withdrawMethods])
    @include('frontend::payment.account.include.__edit')
    @include('frontend::payment.account.include.__delete')
    @push('js')
        <script>
            "use strict";

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = '{{ buyerSellerRoute('payment.withdraw.account.delete', ':id') }}';
                url = url.replace(':id', id);
                $('#withdrawDeleteAccount form').attr('action', url);
                $("#withdrawDeleteAccount").addClass("open");
            });

            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = "{{ buyerSellerRoute('payment.withdraw.account.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                var formUrl = "{{ buyerSellerRoute('payment.withdraw.account.update', ['id' => ':id']) }}";

                $.get(url, function(response) {
                    $('#withdrawEditAccount .manual-row').html(response.html);
                    $('#edit-form').attr('action', formUrl.replace(':id', id));
                    $("#withdrawEditAccount").addClass("open");
                })
            });

            $(document).on('change', "[name=withdraw_method_id],#editSelectMethod", function(e) {

                e.preventDefault();
                var id = $(this).val()

                var url = '{{ buyerSellerRoute('payment.withdraw.account.method', ':id') }}';
                url = url.replace(':id', id);

                $.get(url, function(data) {
                    $('.manual-row').html(data);
                })
            });
        </script>
    @endpush
@endsection
