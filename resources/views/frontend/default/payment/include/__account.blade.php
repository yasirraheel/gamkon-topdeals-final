<div class="col-12">
    <div class="td-form-group">
        <label class="input-label">{{ __('Method Name') }} <span>*</span></label>
        <div class="input-field">
            <input type="text" class="form-control" name="method_name"
                value="{{ $withdrawMethod->name . '-' . $withdrawMethod->currency }}" required>
            <p class="feedback-invalid">{{ __('This field is required') }}</p>
        </div>
    </div>
</div>
@foreach (json_decode($withdrawMethod->fields, true) as $key => $field)
    <input type="hidden" name="credentials[{{ $field['name'] }}][name]" value="{{ $field['name'] }}">
    <input type="hidden" name="credentials[{{ $field['name'] }}][type]" value="{{ $field['type'] }}">
    <input type="hidden" name="credentials[{{ $field['name'] }}][validation]" value="{{ $field['validation'] }}">
    @if ($field['type'] == 'file')
        <div class="col-12">
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }} <span>*</span></label>
                <div class="input-field">
                    <div class="upload-custom-file without-image">
                        <input type="file" name="credentials[{{ $field['name'] }}][value]"
                            id="credentials_{{ $field['name'] }}" accept=".gif, .jpg, .png"
                            onchange="showCloseButton(event)" @if ($field['validation'] == 'required') required @endif />
                        <label for="credentials_{{ $field['name'] }}">
                            <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt="" />
                            <span>{{ __('Upload') . ' ' . $field['name'] }}</span>
                        </label>
                    </div>
                    <button type="button" class="upload-thumb-close" onclick="removeUploadedFile(this)">
                        <i class="iconamoon--sign-times-bold"></i>
                    </button>
                    <p class="feedback-invalid">{{ $field['name'] . ' ' . __('is required') }}</p>
                </div>
            </div>
        </div>
    @elseif($field['type'] == 'textarea')
        <div class="col-12">
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }} <span>*</span></label>
                <div class="input-field">
                    <textarea class="form-control" name="credentials[{{ $field['name'] }}][value]"
                        @if ($field['validation'] == 'required') required @endif></textarea>
                    <p class="feedback-invalid">{{ $field['name'] . ' ' . __('is required') }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }} <span>*</span></label>
                <div class="input-field">
                    <input type="text" class="form-control" name="credentials[{{ $field['name'] }}][value]"
                        @if ($field['validation'] == 'required') required @endif>
                    <p class="feedback-invalid">{{ $field['name'] . ' ' . __('is required') }}</p>
                </div>
            </div>
        </div>
    @endif
@endforeach
