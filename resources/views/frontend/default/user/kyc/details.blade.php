<div class="modal-list-content">

    <div class="modal-list-info">
        <ul class="list-group">

            <li class="list-group-item border-0">
                {{ __('KYC Name') }} : {{ $kyc->kyc?->name ?? $kyc->type }}
            </li>
            <li class="list-group-item border-0">
                {{ __('Submission Date') }} : {{ $kyc->created_at->format('d M Y h:i A') }}
            </li>
            <li class="list-group-item border-0">
                {{ __('Status') }} :
                @if ($kyc->status == 'pending')
                    <div class="badge bg-primary">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'rejected')
                    <div class="badge bg-danger">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'approved')
                    <div class="badge bg-success">{{ ucfirst($kyc->status) }}</div>
                @endif
            </li>
            @if ($kyc->status != 'pending')
                <div class="list-group-item border-0">{{ __('Message From Admin') }} : <div class="badge bg-primary">
                        {{ $kyc->message }}</div>
                </div>
            @endif
            @foreach ($kyc->data as $key => $value)
                <li class="list-group-item border-0">{{ $key }} :
                    @if (file_exists(base_path('assets/' . $value)))
                        <br>
                        <a href="{{ asset($value) }}" target="_blank" data-bs-toggle="tooltip"
                            title="Click here to view document">
                            <img src="{{ asset($value) }}" alt="" />
                        </a>
                    @else
                        <strong>{{ $value }}</strong>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
