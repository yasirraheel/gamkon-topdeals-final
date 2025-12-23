<div class="info-withdraw">
    <h6>{{ __('Withdraw Fee') }}</h6>
    <p><span class="withdrawFee">{{ $charge }}</span> <span class="withdrawFeeType">{{ $currency }}</span></p>
</div>

@if ($conversionRate != null)
    <div class="info-withdraw">
        <h6>{{ __('Conversion Rate') }}</h6>
        <p class="conversion-rate">1 {{ $currency }} = {{ $conversionRate }}</p>
    </div>
    <div class="info-withdraw">
        <h6>{{ __('Pay Amount') }}</h6>
        <p class="pay-amount"></p>
    </div>
@endif

<div class="info-withdraw">
    <h6>{{ __('Withdraw Account') }}</h6>
    <p>{{ $name }}</p>
</div>
<div class="info-withdraw">
    <h6>{{ __('Processing Time') }}</h6>
    <p class="processing-time"></p>
</div>

@foreach ($credentials as $name => $data)
    <div class="info-withdraw">
        <h6>{{ str($name)->headline() }}</h6>
        <p>
            @if ($data['type'] == 'file')
                <img src="{{ asset(data_get($data, 'value')) }}" alt="">
            @else
                {{ data_get($data, 'value') }}
            @endif
        </p>
    </div>
@endforeach
