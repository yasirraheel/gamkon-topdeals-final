@extends('frontend::layouts.user', ['mainClass' => '-2'])
@section('title')
    {{ __('Plan History') }}
@endsection
@section('content')
    <div class="transactions-history-box">
        <form method="GET" id="filterForm" action="{{ url()->current() }}">
            <x-luminous.dashboard-breadcrumb title="{{ __('Plan History') }}">

            </x-luminous.dashboard-breadcrumb>
        </form>
        <div class="common-table">
            <div class="common-table-full">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center text-nowrap">{{ __('Description') }}</th>
                            <th scope="col" class="text-center text-nowrap">{{ __('Plan') }}</th>
                            <th scope="col" class="text-center text-nowrap">{{ __('Amount') }}</th>
                            <th scope="col" class="text-center text-nowrap">{{ __('Status') }}</th>
                            <th scope="col" class="text-center text-nowrap">{{ __('Subscribed At') }}</th>
                            <th scope="col" class="text-center text-nowrap">{{ __('Validity At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($histories as $history)
                            <tr>
                                <td class="text-center text-nowrap">
                                    <div class="description">
                                        <div class="content">
                                            <div class="title">
                                                {{ __('Subscribed to :plan', ['plan' => $history->plan->name ?? 'N/A']) }}
                                            </div>
                                            <div class="date">{{ $history->created_at->format('d M Y h:i A') }}</div>
                                        </div>
                                </td>
                                <td class="text-center text-nowrap">{{ $history->plan->name ?? 'N/A' }}</td>
                                <td class="text-center text-nowrap green-color">
                                    {{ amountWithCurrency($history->amount) }}
                                </td>
                                <td class="text-center text-nowrap">
                                    @if ($history->status == App\Enums\PlanHistoryStatus::ACTIVE)
                                        <div class="type badge bg-success">{{ __('Active') }}</div>
                                    @elseif($history->status == App\Enums\PlanHistoryStatus::PENDING)
                                        <div class="type badge bg-warning text-black">{{ __('Pending') }}</div>
                                    @elseif($history->status == App\Enums\PlanHistoryStatus::EXPIRED)
                                        <div class="type badge bg-danger">{{ __('Expired') }}</div>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">{{ $history->created_at->format('d M Y h:i A') }}</td>
                                <td class="text-center text-nowrap">{{ $history->validity_at->format('d M Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <x.luminous.no-data-found type="Subscription" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-pagination">
            <div class="pagination">
                {{ $histories->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
