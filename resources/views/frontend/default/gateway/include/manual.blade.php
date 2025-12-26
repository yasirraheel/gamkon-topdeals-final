<div class="col-xl-12 col-md-12">
    <div class="site-card">
        <div class="site-card-body">
            <div class="payment-instruction-content">
                {!! $paymentDetails !!}
            </div>
        </div>
    </div>
</div>
<style>
    .payment-instruction-content {
        color: var(--td-text-primary, #333);
    }
    .payment-instruction-content p {
        color: var(--td-text-primary, #333);
        margin-bottom: 10px;
    }
    .payment-instruction-content strong {
        color: var(--td-heading, #000);
    }
</style>
@foreach (json_decode($fieldOptions, true) as $key => $field)
    @if ($field['type'] == 'file')
        <div class="td-form-group mt-2 position-relative">
            <label class="input-label" for="">{{ $field['name'] }} @if ($field['validation'] == 'required')
                    <span class="text text-danger d-inline">*</span>
                @endif
            </label>
            <div class="upload-custom-file without-image">
                <input type="file" name="manual_data[{{ $field['name'] }}]" id="manual_data[{{ $field['name'] }}]"
                    accept=".gif, .jpg, .png" onchange="showCloseButton(event)"
                    @if ($field['validation'] == 'required') required @endif />
                <label for="manual_data[{{ $field['name'] }}]">
                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="" />
                    <span> {{ __('Upload') . ' ' . $field['name'] }}</span>
                </label>
            </div>
            <button type="button" class="upload-thumb-close" onclick="removeUploadedFile(this)">
                <iconify-icon icon="stash:times-duotone" class="referral-icon dashbaord-icon"></iconify-icon>
            </button>
        </div>
    @elseif($field['type'] == 'textarea')
        <div class="td-form-group mt-2">
            <label class="input-label" for="">{{ $field['name'] }} @if ($field['validation'] == 'required')
                    <span class="text text-danger d-inline">*</span>
                @endif
            </label>
            <div class="input-field">
                <textarea class="form-control form-control-2" name="manual_data[{{ $field['name'] }}]"
                    @if ($field['validation'] == 'required') required @endif> </textarea>
            </div>
        </div>
    @else
        <div class="td-form-group mt-2">
            <label class="input-label" for="">{{ $field['name'] }} @if ($field['validation'] == 'required')
                    <span class="text text-danger d-inline">*</span>
                @endif
            </label>
            <div class="input-field">
                <input type="text" class="form-control form-control-2" name="manual_data[{{ $field['name'] }}]"
                    @if ($field['validation'] == 'required') required @endif>
            </div>
        </div>
    @endif
@endforeach
