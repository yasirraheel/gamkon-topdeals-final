<div class="withdrawl-history">
    <h3>{{ __('Withdrawal History') }}</h3>
    <div class="withdrawl-history-table">
        <div class="common-full-table table-responsive-lg">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center text-nowrap">{{ __('Description') }}</th>
                        <th scope="col" class="text-center text-nowrap">{{ __('Transaction ID') }}</th>
                        <th scope="col" class="text-center text-nowrap">{{ __('Amount') }}</th>
                        <th scope="col" class="text-center text-nowrap">{{ __('Charge') }}</th>
                        <th scope="col" class="text-center text-nowrap">{{ __('Status') }}</th>
                        <th scope="col" class="text-center text-nowrap">{{ __('Gateway') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdrawHistory as $history)
                        <tr>
                            <td class="text-center text-nowrap">{{ $history->description }}<p class="date">
                                    {{ $history->created_at }}</p>
                            </td>
                            <td class="text-center text-nowrap">{{ $history->tnx }}</td>
                            <td class="text-center text-nowrap">{{ $currencySymbol . $history->amount }}</td>
                            <td class="text-center text-nowrap">{{ $currencySymbol . $history->charge }}</td>
                            <td class="text-center text-nowrap">
                                <span @class([
                                    'badge',
                                    'bg-warning text-black' => $history->status->value == 'pending',
                                    'bg-success' => $history->status->value == 'success',
                                    'bg-danger' => $history->status->value == 'failed',
                                ])> {{ ucfirst($history->status->value) }} </span>
                            </td>
                            <td class="text-center text-nowrap">{{ $history->method }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <x-luminous.no-data-found type="Withdrawal History" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
